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

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PageSpeed\Api\Analysis\CategoryGroup;

#[CoversClass(CategoryGroup::class)]
final class CategoryGroupTest extends TestCase
{
    public function testGroupCanBeCreatedFromValues(): void
    {
        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
            'description' => 'test-description',
        ];

        $categoryGroup = CategoryGroup::create($values);

        self::assertSame($values['id'], $categoryGroup->id);
        self::assertSame($values['title'], $categoryGroup->title);
        self::assertSame($values['description'], $categoryGroup->description);
    }

    public function testGroupCanBeCreatedWithNullDescription(): void
    {
        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
        ];

        $categoryGroup = CategoryGroup::create($values);

        self::assertSame($values['id'], $categoryGroup->id);
        self::assertSame($values['title'], $categoryGroup->title);
        self::assertNull($categoryGroup->description);
    }

    public function testGroupCreationFailsWithMissingValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 'test-id',
        ];

        CategoryGroup::create($values);
    }

    public function testGroupCreationFailsWithInvalidValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 123,
            'title' => 'test-title',
            'description' => 'test-description',
        ];

        CategoryGroup::create($values);
    }
}
