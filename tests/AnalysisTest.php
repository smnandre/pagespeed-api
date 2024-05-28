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
                    'performance' =>  LighthouseCategoryResultFactory::createData([
                        'id' => 'performance',
                        'title' => 'Performance',
                        'score' => 0.9,
                    ]),
                    'accessibility' =>  LighthouseCategoryResultFactory::createData([
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

    // public function auditScoresReturnsEmptyArrayWhenNoScores(): void
    // {
    //     $values = AnalysisFactory::createData([
    //         'id' => 'test-id',
    //         'analysisUTCTimestamp' => '2022-01-01T00:00:00Z',
    //         'lighthouseResult' => [
    //             'categories' => [],
    //         ],
    //     ]);
    //
    //     $analysis = Analysis::create($values);
    //
    //     self::assertSame([], $analysis->getAuditScores());
    // }

}
