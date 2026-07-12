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

/**
 * A single Core Web Vitals metric with its field value, unit and rating.
 */
final readonly class MetricValue implements \JsonSerializable
{
    public function __construct(
        public string $name,
        public int $value,
        public string $unit,
        public ?Bucket $rating,
    ) {
    }

    /**
     * @return array{name: string, value: int, unit: string, rating: string|null}
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'unit' => $this->unit,
            'rating' => $this->rating?->value,
        ];
    }

    /**
     * @return array{name: string, value: int, unit: string, rating: string|null}
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
