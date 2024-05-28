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

use PageSpeed\Api\Analysis\AuditRef;
use PageSpeed\Api\Analysis\CategoryResult;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CategoryResult::class)]
#[CoversClass(AuditRef::class)]
final class CategoryResultTest extends TestCase
{
    public function testCanBeCreatedFromValues(): void
    {
        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
            'score' => 0.9,
            'auditRefs' => [
                ['id' => 'audit1', 'weight' => 1],
            ],
            'description' => 'test-description',
            'manualDescription' => 'test-manual-description',
        ];

        $categoryResult = CategoryResult::create($values);

        self::assertSame($values['id'], $categoryResult->id);
        self::assertSame($values['title'], $categoryResult->title);
        self::assertSame($values['score'], $categoryResult->score);
        self::assertCount(1, $categoryResult->auditRefs);
        self::assertInstanceOf(AuditRef::class, $categoryResult->auditRefs[0]);
        self::assertSame($values['description'], $categoryResult->description);
        self::assertSame($values['manualDescription'], $categoryResult->manualDescription);
    }

    public function testCanBeCreatedWithDefaultValues(): void
    {
        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
            'score' => 0.9,
            'auditRefs' => [
                ['id' => 'audit1', 'weight' => 1],
            ],
        ];

        $categoryResult = CategoryResult::create($values);

        self::assertSame($values['id'], $categoryResult->id);
        self::assertSame($values['title'], $categoryResult->title);
        self::assertSame($values['score'], $categoryResult->score);
        self::assertCount(1, $categoryResult->auditRefs);
        self::assertInstanceOf(AuditRef::class, $categoryResult->auditRefs[0]);
        self::assertNull($categoryResult->description);
        self::assertNull($categoryResult->manualDescription);
    }

    public function testCreationFailsWithMissingValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
        ];

        CategoryResult::create($values);
    }

    public function testCreationFailsWithInvalidValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 123,
            'title' => 'test-title',
            'score' => 'invalid',
            'auditRefs' => 'invalid',
            'description' => 'test-description',
            'manualDescription' => 'test-manual-description',
        ];

        CategoryResult::create($values);
    }
}
