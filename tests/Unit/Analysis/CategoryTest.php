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

use PageSpeed\Api\Analysis\Category;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Category::class)]
class CategoryTest extends TestCase
{
    public function testValues(): void
    {
        $values = Category::values();
        $this->assertIsArray($values);
        $this->assertContains('accessibility', $values);
        $this->assertContains('best-practices', $values);
        $this->assertContains('performance', $values);
        $this->assertContains('seo', $values);
    }

    public function testValuesCount(): void
    {
        $values = Category::values();
        $this->assertCount(4, $values);
    }
}
