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

use PageSpeed\Api\Analysis\Metric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Metric::class)]
class MetricTest extends TestCase
{
    public function testCanBeCreatedFromValues(): void
    {
        $values = [
            'id' => 'test-id',
            'percentile' => 90,
            'distributions' => ['dist1', 'dist2'],
            'category' => 'test-category',
        ];

        $metric = Metric::create($values);

        $this->assertSame($values['id'], $metric->id);
        $this->assertSame($values['percentile'], $metric->percentile);
        $this->assertSame($values['distributions'], $metric->distributions);
        $this->assertSame($values['category'], $metric->category);
    }

    public function testCreationFailsWithMissingValues(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 'test-id',
            'percentile' => 90,
            'category' => 'test-category',
        ];

        Metric::create($values);
    }

    public function testCreationFailsWithInvalidValues(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 123,
            'percentile' => 'invalid',
            'distributions' => 'invalid',
            'category' => 'test-category',
        ];

        Metric::create($values);
    }
}
