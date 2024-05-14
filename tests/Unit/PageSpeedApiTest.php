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

namespace PageSpeed\Api\Tests\Unit;

use PageSpeed\Api\Analysis;
use PageSpeed\Api\PageSpeedApi;
use PageSpeed\Api\Tests\Fixtures\AnalysisFactory;
use PageSpeed\Api\Tests\Fixtures\LighthouseCategoryResultFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;

#[CoversClass(PageSpeedApi::class)]
class PageSpeedApiTest extends TestCase
{
    public function testAnalysis(): void
    {
        $response = JsonMockResponse::fromFile(__DIR__.'/../Fixtures/response.json');
        $api = new PageSpeedApi('API_KEY', new MockHttpClient($response));

        $analysis = $api->analyse('https://example.com');

        self::assertInstanceOf(Analysis::class, $analysis);
    }

    #[DataProvider('provideInvalidParameters')]
    public function testAnalysisInvalidParameters(array $parameters): void
    {
        $api = new PageSpeedApi();
        self::expectException(\InvalidArgumentException::class);

        $api->analyse(...$parameters);
    }

    public static function provideInvalidParameters(): iterable
    {
        yield 'invalid_url' => [['https://']];
        yield 'invalid_strategy' => [['https://example.com', 'invalid']];
        yield 'invalid_locale' => [['https://example.com', null, 'invalid']];
        yield 'invalid_category' => [['https://example.com', null, null, ['invalid']]];
    }
}
