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

use PageSpeed\Api\Analysis;
use PageSpeed\Api\Analysis\Category;

/**
 * Display-ready view over an Analysis: category scores and Core Web Vitals,
 * reachable by property and serialisable to array/JSON.
 */
final readonly class Report implements \JsonSerializable
{
    /**
     * CrUX metric key => [short name, unit].
     *
     * @var array<string, array{string, string}>
     */
    private const array METRICS = [
        'LARGEST_CONTENTFUL_PAINT_MS' => ['lcp', 'ms'],
        'CUMULATIVE_LAYOUT_SHIFT_SCORE' => ['cls', ''],
        'INTERACTION_TO_NEXT_PAINT' => ['inp', 'ms'],
        'FIRST_CONTENTFUL_PAINT_MS' => ['fcp', 'ms'],
        'FIRST_INPUT_DELAY_MS' => ['fid', 'ms'],
        'EXPERIMENTAL_TIME_TO_FIRST_BYTE' => ['ttfb', 'ms'],
    ];

    public function __construct(
        public ?Score $performance,
        public ?Score $accessibility,
        public ?Score $bestPractices,
        public ?Score $seo,
        public ?MetricValue $lcp,
        public ?MetricValue $cls,
        public ?MetricValue $inp,
        public ?MetricValue $fcp,
        public ?MetricValue $fid,
        public ?MetricValue $ttfb,
    ) {
    }

    public static function fromAnalysis(Analysis $analysis): self
    {
        $scores = [];
        foreach ($analysis->getAuditScores() as $key => $value) {
            $category = Category::tryFrom($key);
            if (null !== $category) {
                $scores[$key] = new Score($category, $value);
            }
        }

        $metrics = [];
        foreach ($analysis->loadingExperience->metrics ?? [] as $key => $metric) {
            $definition = self::METRICS[$key] ?? null;
            if (null === $definition) {
                continue;
            }
            [$name, $unit] = $definition;
            $metrics[$name] = new MetricValue($name, $metric->percentile, $unit, Bucket::tryFrom($metric->category));
        }

        return new self(
            performance: $scores['performance'] ?? null,
            accessibility: $scores['accessibility'] ?? null,
            bestPractices: $scores['best-practices'] ?? null,
            seo: $scores['seo'] ?? null,
            lcp: $metrics['lcp'] ?? null,
            cls: $metrics['cls'] ?? null,
            inp: $metrics['inp'] ?? null,
            fcp: $metrics['fcp'] ?? null,
            fid: $metrics['fid'] ?? null,
            ttfb: $metrics['ttfb'] ?? null,
        );
    }

    /**
     * @return array{
     *     scores: array<string, array{category: string, value: int, rating: string}|null>,
     *     metrics: array<string, array{name: string, value: int, unit: string, rating: string|null}|null>,
     * }
     */
    public function toArray(): array
    {
        return [
            'scores' => [
                'performance' => $this->performance?->toArray(),
                'accessibility' => $this->accessibility?->toArray(),
                'best-practices' => $this->bestPractices?->toArray(),
                'seo' => $this->seo?->toArray(),
            ],
            'metrics' => [
                'lcp' => $this->lcp?->toArray(),
                'cls' => $this->cls?->toArray(),
                'inp' => $this->inp?->toArray(),
                'fcp' => $this->fcp?->toArray(),
                'fid' => $this->fid?->toArray(),
                'ttfb' => $this->ttfb?->toArray(),
            ],
        ];
    }

    /**
     * @return array{
     *     scores: array<string, array{category: string, value: int, rating: string}|null>,
     *     metrics: array<string, array{name: string, value: int, unit: string, rating: string|null}|null>,
     * }
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
