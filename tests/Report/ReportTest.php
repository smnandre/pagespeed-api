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

namespace PageSpeed\Api\Tests\Report;

use PageSpeed\Api\Analysis;
use PageSpeed\Api\Analysis\Category;
use PageSpeed\Api\Report\Bucket;
use PageSpeed\Api\Report\Rating;
use PageSpeed\Api\Report\Report;
use PageSpeed\Api\Tests\Fixtures\Factory\AnalysisFactory;
use PageSpeed\Api\Tests\Fixtures\Factory\LighthouseCategoryResultFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Report::class)]
final class ReportTest extends TestCase
{
    /**
     * @param array<string, mixed> $overrides
     */
    private static function report(array $overrides = []): Report
    {
        return Analysis::create(AnalysisFactory::createData($overrides))->report();
    }

    public function testScoresAsNamedProperties(): void
    {
        $report = self::report([
            'lighthouseResult' => ['categories' => [
                'performance' => LighthouseCategoryResultFactory::createData(['id' => 'performance', 'score' => 0.75]),
                'seo' => LighthouseCategoryResultFactory::createData(['id' => 'seo', 'title' => 'SEO', 'score' => 0.9]),
            ]],
        ]);

        self::assertNotNull($report->performance);
        self::assertSame(75, $report->performance->value);
        self::assertSame(Rating::NeedsImprovement, $report->performance->rating);
        self::assertSame(Category::Performance, $report->performance->category);

        self::assertNotNull($report->seo);
        self::assertSame(90, $report->seo->value);
        self::assertSame(Rating::Good, $report->seo->rating);
    }

    public function testAbsentCategoryScoreIsNull(): void
    {
        $report = self::report([
            'lighthouseResult' => ['categories' => [
                'performance' => LighthouseCategoryResultFactory::createData(['id' => 'performance', 'score' => 0.9]),
            ]],
        ]);

        self::assertNull($report->accessibility);
        self::assertNull($report->bestPractices);
    }

    public function testMetricsCarryValueUnitAndRating(): void
    {
        $report = self::report([
            'loadingExperience' => ['metrics' => [
                'LARGEST_CONTENTFUL_PAINT_MS' => ['category' => 'FAST', 'distributions' => [], 'percentile' => 2300],
                'CUMULATIVE_LAYOUT_SHIFT_SCORE' => ['category' => 'AVERAGE', 'distributions' => [], 'percentile' => 10],
            ]],
        ]);

        self::assertNotNull($report->lcp);
        self::assertSame('lcp', $report->lcp->name);
        self::assertSame(2300, $report->lcp->value);
        self::assertSame('ms', $report->lcp->unit);
        self::assertSame(Bucket::Fast, $report->lcp->rating);

        self::assertNotNull($report->cls);
        self::assertSame(10, $report->cls->value);
        self::assertSame('', $report->cls->unit);
        self::assertSame(Bucket::Average, $report->cls->rating);
    }

    public function testOnlyKnownCruxKeysAreMapped(): void
    {
        // The default fixture supplies lowercase keys (e.g. first_contentful_paint);
        // only the real ALL_CAPS CrUX keys map, so fcp stays null here.
        $report = self::report();

        self::assertNull($report->fcp);
        self::assertNull($report->ttfb);
    }

    public function testUnknownMetricRatingIsNull(): void
    {
        $report = self::report([
            'loadingExperience' => ['metrics' => [
                'INTERACTION_TO_NEXT_PAINT' => ['category' => 'NONE', 'distributions' => [], 'percentile' => 200],
            ]],
        ]);

        self::assertNotNull($report->inp);
        self::assertSame(200, $report->inp->value);
        self::assertNull($report->inp->rating);
    }

    public function testNoFieldDataYieldsNullMetrics(): void
    {
        $report = self::report(['loadingExperience' => null]);

        self::assertNull($report->lcp);
        self::assertNull($report->cls);
        self::assertNull($report->inp);
        self::assertNull($report->fcp);
        self::assertNull($report->fid);
        self::assertNull($report->ttfb);
    }

    public function testToArrayShape(): void
    {
        $report = self::report([
            'lighthouseResult' => ['categories' => [
                'performance' => LighthouseCategoryResultFactory::createData(['id' => 'performance', 'score' => 0.9]),
            ]],
            'loadingExperience' => ['metrics' => [
                'LARGEST_CONTENTFUL_PAINT_MS' => ['category' => 'FAST', 'distributions' => [], 'percentile' => 2300],
            ]],
        ]);

        $array = $report->toArray();

        self::assertSame(['category' => 'performance', 'value' => 90, 'rating' => 'good'], $array['scores']['performance']);
        self::assertNull($array['scores']['seo']);
        self::assertSame(['name' => 'lcp', 'value' => 2300, 'unit' => 'ms', 'rating' => 'FAST'], $array['metrics']['lcp']);
        self::assertNull($array['metrics']['ttfb']);
    }

    public function testJsonEncodesViaToArray(): void
    {
        $report = self::report([
            'loadingExperience' => ['metrics' => [
                'LARGEST_CONTENTFUL_PAINT_MS' => ['category' => 'FAST', 'distributions' => [], 'percentile' => 2300],
            ]],
        ]);

        self::assertSame(json_encode($report->toArray()), json_encode($report));
    }
}
