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

namespace PageSpeed\Api\Report;

use PageSpeed\Api\Analysis\Category;

/**
 * A single Lighthouse category score (0-100) with its rating.
 */
final readonly class Score implements \JsonSerializable
{
    public Rating $rating;

    public function __construct(
        public Category $category,
        public int $value,
    ) {
        $this->rating = Rating::fromScore($value);
    }

    /**
     * @return array{category: string, value: int, rating: string}
     */
    public function toArray(): array
    {
        return [
            'category' => $this->category->value,
            'value' => $this->value,
            'rating' => $this->rating->value,
        ];
    }

    /**
     * @return array{category: string, value: int, rating: string}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
