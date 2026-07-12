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

use PageSpeed\Api\Report\Rating;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Rating::class)]
final class RatingTest extends TestCase
{
    public function testBackingValues(): void
    {
        self::assertSame('poor', Rating::Poor->value);
        self::assertSame('needs-improvement', Rating::NeedsImprovement->value);
        self::assertSame('good', Rating::Good->value);
    }

    #[DataProvider('scoreBoundaries')]
    public function testFromScore(int $score, Rating $expected): void
    {
        self::assertSame($expected, Rating::fromScore($score));
    }

    /**
     * @return iterable<string, array{int, Rating}>
     */
    public static function scoreBoundaries(): iterable
    {
        yield 'floor' => [0, Rating::Poor];
        yield 'poor upper bound' => [49, Rating::Poor];
        yield 'needs-improvement lower bound' => [50, Rating::NeedsImprovement];
        yield 'needs-improvement upper bound' => [89, Rating::NeedsImprovement];
        yield 'good lower bound' => [90, Rating::Good];
        yield 'ceiling' => [100, Rating::Good];
    }
}
