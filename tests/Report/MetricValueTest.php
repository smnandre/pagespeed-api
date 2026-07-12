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

use PageSpeed\Api\Report\Bucket;
use PageSpeed\Api\Report\MetricValue;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MetricValue::class)]
final class MetricValueTest extends TestCase
{
    public function testExposesNameValueUnitAndRating(): void
    {
        $metric = new MetricValue('lcp', 2300, 'ms', Bucket::Fast);

        self::assertSame('lcp', $metric->name);
        self::assertSame(2300, $metric->value);
        self::assertSame('ms', $metric->unit);
        self::assertSame(Bucket::Fast, $metric->rating);
    }

    public function testToArray(): void
    {
        self::assertSame(
            ['name' => 'lcp', 'value' => 2300, 'unit' => 'ms', 'rating' => 'FAST'],
            (new MetricValue('lcp', 2300, 'ms', Bucket::Fast))->toArray(),
        );
    }

    public function testToArrayWithUnknownRating(): void
    {
        self::assertSame(
            ['name' => 'cls', 'value' => 10, 'unit' => '', 'rating' => null],
            (new MetricValue('cls', 10, '', null))->toArray(),
        );
    }

    public function testJsonSerializes(): void
    {
        self::assertSame(
            '{"name":"lcp","value":2300,"unit":"ms","rating":"FAST"}',
            json_encode(new MetricValue('lcp', 2300, 'ms', Bucket::Fast)),
        );
    }
}
