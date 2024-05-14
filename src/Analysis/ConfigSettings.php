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

final readonly class ConfigSettings
{
    /**
     * @param list<string> $onlyCategories
     */
    public function __construct(
        public array $onlyCategories,
        public string $locale,
        public string $channel,
        public string $formFactor,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function create(array $values): self
    {
        Assert::keyExists($values, 'onlyCategories');
        Assert::isArray($values['onlyCategories']);
        Assert::allString($values['onlyCategories']);

        Assert::keyExists($values, 'locale');
        Assert::string($values['locale']);

        Assert::keyExists($values, 'channel');
        Assert::string($values['channel']);

        Assert::keyExists($values, 'formFactor');
        Assert::string($values['formFactor']);

        return new self(
            $values['onlyCategories'],
            $values['locale'],
            $values['channel'],
            $values['formFactor'],
        );
    }
}
