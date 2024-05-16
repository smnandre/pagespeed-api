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
use PageSpeed\Api\Analysis\LighthouseResult;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LighthouseResult::class)]
class LighthouseResultTest extends TestCase
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

        $this->assertSame($values['id'], $audit->id);
        $this->assertSame($values['title'], $audit->title);
        $this->assertSame($values['description'], $audit->description);
        $this->assertSame($values['score'], $audit->score);
        $this->assertSame($values['scoreDisplayMode'], $audit->scoreDisplayMode);
        $this->assertSame($values['displayValue'], $audit->displayValue);
        $this->assertSame($values['details'], $audit->details);
        $this->assertSame($values['numericValue'], $audit->numericValue);
        $this->assertSame($values['numericUnit'], $audit->numericUnit);
        $this->assertSame($values['warnings'], $audit->warnings);
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

        $this->assertSame($values['id'], $audit->id);
        $this->assertSame($values['title'], $audit->title);
        $this->assertSame($values['description'], $audit->description);
        $this->assertNull($audit->score);
        $this->assertSame($values['scoreDisplayMode'], $audit->scoreDisplayMode);
        $this->assertNull($audit->displayValue);
        $this->assertNull($audit->details);
        $this->assertNull($audit->numericValue);
        $this->assertNull($audit->numericUnit);
        $this->assertNull($audit->warnings);
    }

    public function testCreationFailsWithMissingValues(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 'test-id',
            'title' => 'test-title',
        ];

        Audit::create($values);
    }

    public function testCreationFailsWithInvalidValues(): void
    {
        $this->expectException(\InvalidArgumentException::class);

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
