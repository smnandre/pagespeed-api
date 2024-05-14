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

namespace PageSpeed\Api;

use PageSpeed\Api\Analysis\LighthouseResult;
use PageSpeed\Api\Analysis\LoadingExperience;
use Webmozart\Assert\Assert;

final readonly class Analysis
{
    private function __construct(
        public string $id,
        public ?LoadingExperience $loadingExperience,
        public ?LoadingExperience $originLoadingExperience,
        public string $analysisUTCTimestamp,
        public LighthouseResult $lighthouseResult,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function create(array $values): self
    {
        Assert::keyExists($values, 'id');
        Assert::string($values['id']);

        $values['loadingExperience'] ??= null;
        if (is_array($values['loadingExperience'])) {
            if(array_key_exists('id', $values['loadingExperience'])) {
                $loadingExperience = LoadingExperience::create($values['loadingExperience']);
            }
        }

        $values['originLoadingExperience'] ??= null;
        if (is_array($values['originLoadingExperience'])) {
            if(array_key_exists('id', $values['originLoadingExperience'])) {
                $originLoadingExperience = LoadingExperience::create($values['originLoadingExperience']);
            }
        }

        Assert::keyExists($values, 'analysisUTCTimestamp');
        Assert::string($values['analysisUTCTimestamp']);

        Assert::keyExists($values, 'lighthouseResult');
        Assert::isArray($values['lighthouseResult']);

        return new self(
            $values['id'],
            $loadingExperience ?? null,
            $originLoadingExperience ?? null,
            $values['analysisUTCTimestamp'],
            LighthouseResult::create($values['lighthouseResult'])
        );
    }

    /**
     * @return array<string, int>
     */
    public function getAuditScores(): array
    {
        return $this->lighthouseResult->getScores();
    }
}
