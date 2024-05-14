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

namespace PageSpeed\Api\Tests\Unit\Audit;

use PageSpeed\Api\Analysis\Metric;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Metric::class)]
class MetricTest extends TestCase
{
    public function testValues(): void
    {
        $values = Metric::values();
        $this->assertIsArray($values);
        $this->assertContains('first-contentful-paint', $values);
    }

    public function testValuesCount(): void
    {
        $values = Metric::values();
        $this->assertCount(7, $values);
    }
}
