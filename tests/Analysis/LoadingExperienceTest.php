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

namespace PageSpeed\Api\Tests\Analysis;

use PageSpeed\Api\Analysis\LoadingExperience;
use PageSpeed\Api\Analysis\Metric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LoadingExperience::class)]
class LoadingExperienceTest extends TestCase
{
    public function testCanBeCreatedFromValues(): void
    {
        $values = [
            'id' => 'test-id',
            'metrics' => ['first-contentful-paint' => [
                'percentile' => 12,
                'category' => 'good',
                'distributions' => [],
            ]],
            'overall_category' => 'fast',
            'initial_url' => 'https://example.com',
        ];

        $loadingExperience = LoadingExperience::create($values);

        self::assertSame($values['id'], $loadingExperience->id);
        self::assertSame($values['overall_category'], $loadingExperience->overallCategory);
        self::assertSame($values['initial_url'], $loadingExperience->initialUrl);
    }

    public function testCreationFailsWithMissingValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 'test-id',
            'metrics' => ['first-contentful-paint' => [
                'percentile' => 12,
                'category' => 'good',
                'distributions' => [],
            ]], 'overall_category' => 'fast',
        ];

        LoadingExperience::create($values);
    }

    public function testExperienceCreationFailsWithInvalidValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 123,
            'metrics' => ['first-contentful-paint' => [
                'percentile' => 12,
                'category' => 'good',
                'distributions' => [],
            ]], 'overall_category' => 'fast',
            'initial_url' => 'https://example.com',
        ];

        LoadingExperience::create($values);
    }

    public function testLoadingExperienceReturnsCorrectMetrics(): void
    {
        $metrics = [
            'first-contentful-paint' => Metric::create([
                'id' => 'first-contentful-paint',
                'category' => 'Performance',
                'percentile' => 1000,
                'distributions' => [],
            ]),
            'speed-index' => Metric::create([
                'id' => 'speed-index',
                'category' => 'Performance',
                'percentile' => 1200,
                'distributions' => [],
            ]),
        ];

        $loadingExperience = new LoadingExperience(
            'test-id',
            $metrics,
            'GOOD',
            'https://example.com/',
            false
        );

        $expectedMetrics = [
            'first-contentful-paint' => 'Performance',
            'speed-index' => 'Performance',
        ];

        self::assertSame($expectedMetrics, $loadingExperience->getMetrics());
    }
}
