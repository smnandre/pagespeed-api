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

use PageSpeed\Api\Analysis\Strategy;
use PageSpeed\Api\Analysis\Category;
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

    public function analyse(string $url, ?Strategy $strategy = null, ?string $locale = null, array $category = []): Analysis
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new \InvalidArgumentException('Invalid URL provided.');
        }

        // PageSpeed API uses multiple category parameters
        $category = array_map(fn (Category $cat) => strtoupper(str_replace('-', '_', $cat->value)), Category::cases());


        $cache = __DIR__ . '/../tests/cache/cache-' . urlencode(str_replace(['://', '.'], '-', $url)) . $strategy?->value. '.json';
        if (file_exists($cache)) {
            /** @phpstan-ignore-next-line */
            return  Analysis::create(json_decode(file_get_contents($cache), true, 512, JSON_THROW_ON_ERROR));
        }

        $response = $this->get('runPagespeed?category='.implode('&category=', $category), [
            'url' => $url,
            'strategy' => $strategy?->value,
        ]);

        file_put_contents($cache, json_encode($response));

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
                'X-PageSpeed-Api' => self::BASE_URI
            ],
        ]);

        // if (200 !== $response->getStatusCode()) {
        //     throw new \RuntimeException('An error occurred while fetching the data.', $response->getStatusCode(), $response->getContent());
        // }

        return $response->toArray();
    }
}
