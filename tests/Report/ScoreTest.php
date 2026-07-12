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

use PageSpeed\Api\Analysis\Category;
use PageSpeed\Api\Report\Rating;
use PageSpeed\Api\Report\Score;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Score::class)]
final class ScoreTest extends TestCase
{
    public function testExposesCategoryAndValue(): void
    {
        $score = new Score(Category::Performance, 88);

        self::assertSame(Category::Performance, $score->category);
        self::assertSame(88, $score->value);
    }

    public function testDerivesRatingFromValue(): void
    {
        self::assertSame(Rating::NeedsImprovement, (new Score(Category::Seo, 88))->rating);
        self::assertSame(Rating::Good, (new Score(Category::Seo, 90))->rating);
        self::assertSame(Rating::Poor, (new Score(Category::Seo, 10))->rating);
    }

    public function testToArray(): void
    {
        self::assertSame(
            ['category' => 'performance', 'value' => 88, 'rating' => 'needs-improvement'],
            (new Score(Category::Performance, 88))->toArray(),
        );
    }

    public function testJsonSerializes(): void
    {
        self::assertSame(
            '{"category":"performance","value":88,"rating":"needs-improvement"}',
            json_encode(new Score(Category::Performance, 88)),
        );
    }
}
