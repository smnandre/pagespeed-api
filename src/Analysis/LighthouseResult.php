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
     * @param array<string, CategoryGroup> $categoryGroups
     * @param array<string, Audit> $audits
     * @param array<string, CategoryResult> $categories
     */
    public function __construct(
        public string $requestedUrl,
        public string $finalUrl,
        public string $lighthouseVersion,
        public array $categoryGroups,
        public array $categories,
        public array $audits,
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

        Assert::keyExists($values, 'audits');
        Assert::isArray($values['audits']);

        Assert::keyExists($values, 'environment');
        Assert::isArray($values['environment']);

        Assert::keyExists($values, 'configSettings');
        Assert::isArray($values['configSettings']);

        $categoryGroups = [];
        foreach ($values['categoryGroups'] as $id => $group) {
            Assert::isArray($group);
            $categoryGroups[$id] = ['id' => $id, ...$group];
        }

        return new self(
            $values['requestedUrl'],
            $values['finalUrl'],
            $values['lighthouseVersion'],
            array_map(CategoryGroup::create(...), $categoryGroups),
            array_map(CategoryResult::create(...), $values['categories']),
            array_map(Audit::create(...), $values['audits']),
            Environment::create($values['environment']),
            ConfigSettings::create($values['configSettings']),
        );
    }

    /**
     * @return array<string, int>
     */
    public function getScores(): array
    {
        return array_map(fn (CategoryResult $res) => (int)(100 * $res->score), $this->categories);
    }
}
