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

namespace PageSpeed\Api\Analysis;

use Webmozart\Assert\Assert;

final readonly class Metric
{
    /**
     * @param array<string, mixed> $distributions
     */
    public function __construct(
        public string $id,
        public int $percentile,
        public array $distributions,
        public string $category,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function create(array $values): self
    {
        Assert::keyExists($values, 'id');
        Assert::string($values['id']);

        Assert::keyExists($values, 'percentile');
        Assert::integer($values['percentile']);

        Assert::keyExists($values, 'category');
        Assert::string($values['category']);

        Assert::keyExists($values, 'distributions');
        Assert::isArray($values['distributions']);

        return new self(
            $values['id'],
            $values['percentile'],
            $values['distributions'],
            $values['category'],
        );
    }
}
