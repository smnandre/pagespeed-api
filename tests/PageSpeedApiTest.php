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

namespace PageSpeed\Api\Tests;

use PageSpeed\Api\Analysis;
use PageSpeed\Api\Analysis\Category;
use PageSpeed\Api\Analysis\Strategy;
use PageSpeed\Api\PageSpeedApi;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Component\HttpClient\Response\MockResponse;

#[CoversClass(PageSpeedApi::class)]
class PageSpeedApiTest extends TestCase
{
    public function testAnalysis(): void
    {
        $response = new MockResponse(
            file_get_contents(__DIR__.'/Fixtures/response/example.com.json'),
            ['response_headers' => ['content-type' => 'application/json']],
        );
        $api = new PageSpeedApi('API_KEY', new MockHttpClient($response));

        $analysis = $api->analyse('https://example.com');


        // $weakMap = new \WeakMap();
        // foreach ($result->categoryGroups as $categoryGroup) {
        //     foreach ($result->categories as $category) {
        //         foreach ($category->auditRefs as $auditRef) {
        //             if ($auditRef->group === $categoryGroup->id) {
        //                 $weakMap[$categoryGroup] ??= [];
        //                 $weakMap[$categoryGroup][$auditRef->group] ??= [];
        //                 $weakMap[$categoryGroup][$auditRef->group][] = [
        //                     $auditRef,
        //                     $result->audits[$auditRef->id],
        //                 ];
        //             }
        //         }
        //     }
        // }

        self::assertInstanceOf(Analysis::class, $analysis);
    }

    /**
     * @param list<mixed> $parameters
     */
    #[DataProvider('provideInvalidParameters')]
    public function testAnalysisInvalidParameters(array $parameters): void
    {
        $api = new PageSpeedApi();
        self::expectException(\InvalidArgumentException::class);

        /** @phpstan-ignore-next-line */
        $api->analyse(...$parameters);
    }

    /**
     * @return iterable<string, array<mixed>> $parameters
     */
    public static function provideInvalidParameters(): iterable
    {
        yield 'invalid_url' => [['https://']];
        yield 'invalid_strategy' => [['https://example.com', 'invalid']];
        yield 'invalid_locale' => [['https://example.com', null, 'invalid']];
        yield 'invalid_category' => [['https://example.com', null, null, ['invalid']]];
    }

    public function testAnalyseReturnsCorrectValues(): void
    {
        $response = new MockResponse(
            file_get_contents(__DIR__.'/Fixtures/response/example.com.json'),
            ['response_headers' => ['content-type' => 'application/json']],
        );
        $api = new PageSpeedApi('API_KEY', new MockHttpClient($response));

        $analysis = $api->analyse('https://example.com', Strategy::Desktop, 'en_US', [Category::Performance]);

        $this->assertInstanceOf(Analysis::class, $analysis);
    }

    public function testAnalyseFailsWithInvalidUrl(): void
    {
        $api = new PageSpeedApi('API_KEY');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid URL provided.');

        $api->analyse('invalid-url');
    }

    public function testAnalyseFailsWithInvalidStrategy(): void
    {
        $api = new PageSpeedApi('API_KEY');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid strategy "invalid" provided.');

        $api->analyse('https://example.com', 'invalid');
    }

    public function testAnalyseFailsWithInvalidLocale(): void
    {
        $api = new PageSpeedApi('API_KEY');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid locale "invalid" provided.');

        $api->analyse('https://example.com', Strategy::Desktop, 'invalid');
    }

    public function testAnalyseFailsWithInvalidCategory(): void
    {
        $api = new PageSpeedApi('API_KEY');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid category "invalid" provided.');

        /** @phpstan-ignore-next-line */
        $api->analyse('https://example.com', Strategy::Desktop, 'en_US', ['invalid']);
    }
}
