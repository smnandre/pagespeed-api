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

final readonly class LoadingExperience
{
    /**
     * @param array<string, mixed> $metrics
     */
    public function __construct(
        public string $id,
        public array $metrics,
        public string $overallCategory,
        public string $initialUrl,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function create(array $values): self
    {
        Assert::keyExists($values, 'id');
        Assert::string($values['id']);

        Assert::keyExists($values, 'metrics');
        Assert::isArray($values['metrics']);

        Assert::keyExists($values, 'overall_category');
        Assert::string($values['overall_category']);

        Assert::keyExists($values, 'initial_url');
        Assert::string($values['initial_url']);

        return new self(
            $values['id'],
            $values['metrics'],
            $values['overall_category'],
            $values['initial_url'],
        );
    }
}
