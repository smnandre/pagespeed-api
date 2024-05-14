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

final readonly class Environment
{
    public function __construct(
        public string $networkUserAgent,
        public string $hostUserAgent,
        public float $benchmarkIndex,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function create(array $values): self
    {
        Assert::keyExists($values, 'networkUserAgent');
        Assert::string($values['networkUserAgent']);

        Assert::keyExists($values, 'hostUserAgent');
        Assert::string($values['hostUserAgent']);

        Assert::keyExists($values, 'benchmarkIndex');
        Assert::numeric($values['benchmarkIndex']);

        return new self(
            $values['networkUserAgent'],
            $values['hostUserAgent'],
            (float) $values['benchmarkIndex'],
        );
    }
}
