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

use PageSpeed\Api\Analysis\Strategy;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Strategy::class)]
class StrategyTest extends TestCase
{
    public function testValues(): void
    {
        $values = Strategy::values();
        $this->assertIsArray($values);
        $this->assertContains('desktop', $values);
        $this->assertContains('mobile', $values);
    }

    public function testValuesCount(): void
    {
        $values = Strategy::values();
        $this->assertCount(2, $values);
    }
}
