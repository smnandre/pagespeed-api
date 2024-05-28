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

use PageSpeed\Api\Analysis\Audit;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Audit::class)]
final class AuditTest extends TestCase
{
    public function testCanBeCreatedFromValues(): void
    {
        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
            'description' => 'test-description',
            'score' => 0.9,
            'scoreDisplayMode' => 'binary',
            'displayValue' => '1.0 s',
            'details' => ['detail1', 'detail2'],
            'numericValue' => 1.0,
            'numericUnit' => 'second',
            'warnings' => ['warning1', 'warning2'],
        ];

        $audit = Audit::create($values);

        self::assertSame($values['id'], $audit->id);
        self::assertSame($values['title'], $audit->title);
        self::assertSame($values['description'], $audit->description);
        self::assertSame($values['score'], $audit->score);
        self::assertSame($values['scoreDisplayMode'], $audit->scoreDisplayMode);
        self::assertSame($values['displayValue'], $audit->displayValue);
        self::assertSame($values['details'], $audit->details);
        self::assertSame($values['numericValue'], $audit->numericValue);
        self::assertSame($values['numericUnit'], $audit->numericUnit);
        self::assertSame($values['warnings'], $audit->warnings);
    }

    public function testCanBeCreatedWithDefaultValues(): void
    {
        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
            'description' => 'test-description',
            'scoreDisplayMode' => 'binary',
        ];

        $audit = Audit::create($values);

        self::assertSame($values['id'], $audit->id);
        self::assertSame($values['title'], $audit->title);
        self::assertSame($values['description'], $audit->description);
        self::assertNull($audit->score);
        self::assertSame($values['scoreDisplayMode'], $audit->scoreDisplayMode);
        self::assertNull($audit->displayValue);
        self::assertNull($audit->details);
        self::assertNull($audit->numericValue);
        self::assertNull($audit->numericUnit);
        self::assertNull($audit->warnings);
    }

    public function testFailsWithMissingValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
        ];

        Audit::create($values);
    }

    public function testFailsWithInvalidValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 123,
            'title' => 'test-title',
            'description' => 'test-description',
            'score' => 'invalid',
            'scoreDisplayMode' => 'binary',
            'displayValue' => '1.0 s',
            'details' => 'invalid',
            'numericValue' => 'invalid',
            'numericUnit' => 'second',
            'warnings' => 'invalid',
        ];

        Audit::create($values);
    }

    public function testCreationFailsWithMissingValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
        ];

        Audit::create($values);
    }

    public function testCreationFailsWithInvalidValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 123,
            'title' => 'test-title',
            'description' => 'test-description',
            'score' => 'invalid',
            'scoreDisplayMode' => 'binary',
            'displayValue' => '1.0 s',
            'details' => 'invalid',
            'numericValue' => 'invalid',
            'numericUnit' => 'second',
            'warnings' => 'invalid',
        ];

        Audit::create($values);
    }
}
