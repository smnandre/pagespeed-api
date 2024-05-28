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

use PageSpeed\Api\Analysis\Category;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Category::class)]
class CategoryTest extends TestCase
{
    public function testValues(): void
    {
        $values = Category::values();
        self::assertIsArray($values);
        self::assertContains('accessibility', $values);
        self::assertContains('best-practices', $values);
        self::assertContains('performance', $values);
        self::assertContains('seo', $values);
    }

    public function testValuesCount(): void
    {
        $values = Category::values();
        self::assertCount(4, $values);
    }
}
