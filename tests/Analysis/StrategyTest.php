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
        self::assertIsArray($values);
        self::assertContains('desktop', $values);
        self::assertContains('mobile', $values);
    }

    public function testValuesCount(): void
    {
        $values = Strategy::values();
        self::assertCount(2, $values);
    }
}
