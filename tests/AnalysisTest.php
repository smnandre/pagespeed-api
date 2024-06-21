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
use PageSpeed\Api\Tests\Fixtures\Factory\AnalysisFactory;
use PageSpeed\Api\Tests\Fixtures\Factory\LighthouseCategoryResultFactory;
use PageSpeed\Api\Tests\Fixtures\Factory\LighthouseResultFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Analysis::class)]
class AnalysisTest extends TestCase
{
    public function testAuditScoresReturnsCorrectValues(): void
    {
        $values = AnalysisFactory::createData([
            'lighthouseResult' => [
                'categories' => [
                    'performance' => LighthouseCategoryResultFactory::createData([
                        'id' => 'performance',
                        'title' => 'Performance',
                        'score' => 0.9,
                    ]),
                    'accessibility' => LighthouseCategoryResultFactory::createData([
                        'id' => 'accessibility',
                        'title' => 'Performance',
                        'score' => 0.95,
                    ]),
                ],
            ],
        ]);

        $analysis = Analysis::create($values);

        $expectedScores = [
            'performance' => 90,
            'accessibility' => 95,
        ];

        self::assertSame($expectedScores, $analysis->getAuditScores());
    }

    public function testGetId(): void
    {
        $values = AnalysisFactory::createData([
            'id' => 'test-id',
        ]);

        $analysis = Analysis::create($values);

        self::assertSame('test-id', $analysis->getId());
    }

    public function testGetAnalysisUtcDateTime(): void
    {
        $values = AnalysisFactory::createData([
            'analysisUTCTimestamp' => '2022-01-01T00:00:00Z',
        ]);

        $analysis = Analysis::create($values);

        self::assertSame('2022-01-01T00:00:00Z', $analysis->getAnalysisUtcDateTime()->format('Y-m-d\TH:i:s\Z'));
    }

    public function testGetLoadingMetricsReturnsCorrectValues(): void
    {
        $analysis = Analysis::create([
            ...AnalysisFactory::createData([]),
            'loadingExperience' => [
                'id' => 'loading-experience',
                'metrics' => [
                    'FIRST_CONTENTFUL_PAINT_MS' => [
                        'percentile' => 1000,
                        'distributions' => [],
                        'category' => 'FAST',
                    ],
                    'FIRST_INPUT_DELAY_MS' => [
                        'percentile' => 50,
                        'distributions' => [],
                        'category' => 'SLOW',
                    ],
                ],
                'overall_category' => 'FAST',
                'initial_url' => 'https://example.com',
                'origin_fallback' => null,
            ],
        ]);

        $expectedMetrics = [
            'FIRST_CONTENTFUL_PAINT_MS' => 'FAST',
            'FIRST_INPUT_DELAY_MS' => 'SLOW',
        ];

        self::assertSame($expectedMetrics, $analysis->getLoadingMetrics());
    }

    public function testGetOriginalLoadingMetricsReturnsCorrectValues(): void
    {
        $analysis = Analysis::create([
            ...AnalysisFactory::createData([]),
            'originLoadingExperience' => [
                'id' => 'loading-experience',
                'metrics' => [
                    'FIRST_CONTENTFUL_PAINT_MS' => [
                        'percentile' => 1000,
                        'distributions' => [],
                        'category' => 'FAST',
                    ],
                    'FIRST_INPUT_DELAY_MS' => [
                        'percentile' => 50,
                        'distributions' => [],
                        'category' => 'SLOW',
                    ],
                ],
                'overall_category' => 'FAST',
                'initial_url' => 'https://example.com',
                'origin_fallback' => null,
            ],
        ]);

        $expectedMetrics = [
            'FIRST_CONTENTFUL_PAINT_MS' => 'FAST',
            'FIRST_INPUT_DELAY_MS' => 'SLOW',
        ];

        self::assertSame($expectedMetrics, $analysis->getOriginalLoadingMetrics());
    }

}
