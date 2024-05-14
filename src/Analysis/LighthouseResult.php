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

final readonly class LighthouseResult
{
    /**
     * @param array<string, mixed> $categoryGroups
     * @param array<string, LighthouseCategoryResult> $categories
     */
    public function __construct(
        public string $requestedUrl,
        public string $finalUrl,
        public string $lighthouseVersion,
        public array $categoryGroups,
        public array $categories,
        public Environment $environment,
        public ConfigSettings $configSettings,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function create(array $values): self
    {
        Assert::keyExists($values, 'requestedUrl');
        Assert::string($values['requestedUrl']);

        Assert::keyExists($values, 'finalUrl');
        Assert::string($values['finalUrl']);

        Assert::keyExists($values, 'lighthouseVersion');
        Assert::string($values['lighthouseVersion']);

        Assert::keyExists($values, 'categoryGroups');
        Assert::isArray($values['categoryGroups']);

        Assert::keyExists($values, 'categories');
        Assert::isArray($values['categories']);

        Assert::keyExists($values, 'environment');
        Assert::isArray($values['environment']);

        Assert::keyExists($values, 'configSettings');
        Assert::isArray($values['configSettings']);

        return new self(
            $values['requestedUrl'],
            $values['finalUrl'],
            $values['lighthouseVersion'],
            $values['categoryGroups'],
            array_map(LighthouseCategoryResult::create(...), $values['categories']),
            Environment::create($values['environment']),
            ConfigSettings::create($values['configSettings']),
        );
    }

    /**
     * @return array<string, int>
     */
    public function getScores(): array
    {
        return array_map(fn (LighthouseCategoryResult $res) => (int) (100 * $res->score), $this->categories);
    }
}
