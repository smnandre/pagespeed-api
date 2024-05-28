<?php

declare(strict_types=1);

/*
 * This file is part of the pagespeed/api package.
 *
 * (c) Simon Andre <smn.andre@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PageSpeed\Api;

use PageSpeed\Api\Analysis\Category;
use PageSpeed\Api\Analysis\Strategy;
use SensitiveParameter;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class PageSpeedApi implements PageSpeedApiInterface
{
    private const string BASE_URI = 'https://www.googleapis.com/pagespeedonline/v5/';

    private HttpClientInterface $client;

    public function __construct(
        #[SensitiveParameter]
        private ?string $apiKey = null,
        ?HttpClientInterface $client = null,
    ) {
        $this->client = $client ?? HttpClient::create();
    }

    public function analyse(string $url, Strategy|string|null $strategy = null, ?string $locale = null, array $categories = []): Analysis
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL provided.');
        }

        if (is_string($strategy)) {
            if (!in_array($strategy, Strategy::values())) {
                throw new \InvalidArgumentException(sprintf('Invalid strategy "%s" provided.', $strategy));
            }
            $strategy = Strategy::from($strategy);
        }

        if ($locale && !preg_match('/^[a-z]{2}(_[A-Z]{2})?$/', $locale)) {
            throw new \InvalidArgumentException(sprintf('Invalid locale "%s" provided.', $locale));
        }

        foreach ($categories as $i => $category) {
            if (!$category instanceof Category) {
                if (!in_array($category, Strategy::values())) {
                    throw new \InvalidArgumentException(sprintf('Invalid category "%s" provided.', $category));
                }
                $categories[$i] = Category::from($category);
            }
        }
        if([] === $categories = array_unique($categories)) {
            $categories = Category::cases();
        }

        // PageSpeed API uses multiple category parameters
        $category =  array_map(fn (Category $cat) => strtoupper(str_replace('-', '_', $cat->value)), $categories);

        $response = $this->get('runPagespeed?category='.implode('&category=', $category), [
            'url' => $url,
            'strategy' => $strategy?->value,
            'locale' => $locale,
        ]);

        return Analysis::create($response);
    }

    /**
     * @param array<string, string|mixed> $parameters
     * @return array<string, mixed>
     */
    private function get(string $uri, array $parameters = []): array
    {
        if (null !== $this->apiKey) {
            $parameters['key'] = $this->apiKey;
        }

        $response = $this->client->request('GET', $uri, [
            'query' => $parameters,
            'base_uri' => self::BASE_URI,
            'headers' => [
                'Accept' => 'application/json',
                'User-Agent' => 'PageSpeed.md',
                'X-PageSpeed-Api' => self::BASE_URI,
            ],
        ]);

        if (200 !== $response->getStatusCode()) {
            throw new \RuntimeException('Unexpected response code "%s" returned by PageSpeed Api.', $response->getStatusCode());
        }

        return $response->toArray();
    }
}
