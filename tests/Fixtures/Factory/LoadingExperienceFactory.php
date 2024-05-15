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

namespace PageSpeed\Api\Tests\Fixtures\Factory;

class LoadingExperienceFactory
{
    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public static function createData(array $parameters): array
    {
        $data = [
            'id' => 'test-id',
            'initial_url' => 'https://example.com',
            'metrics' => [
                'overall_category' => 'good',
                'metrics' => [
                    'cumulative_layout_shift' => [
                        'category' => 'good',
                        'distribution' => [
                            'good' => 0.1,
                            'needs_improvement' => 0.2,
                            'poor' => 0.3,
                        ],
                        'percentile' => 0.1,
                    ],
                    'first_contentful_paint' => [
                        'category' => 'good',
                        'distribution' => [
                            'good' => 0.1,
                            'needs_improvement' => 0.2,
                            'poor' => 0.3,
                        ],
                        'percentile' => 0.1,
                    ],
                    'first_input_delay' => [
                        'category' => 'good',
                        'distribution' => [
                            'good' => 0.1,
                            'needs_improvement' => 0.2,
                            'poor' => 0.3,
                        ],
                        'percentile' => 0.1,
                    ],
                    'largest_contentful_paint' => [
                        'category' => 'good',
                        'distribution' => [
                            'good' => 0.1,
                            'needs_improvement' => 0.2,
                            'poor' => 0.3,
                        ],
                        'percentile' => 0.1,
                    ],
                    'performance_category' => 'good',
                ],
            ],
            'origin_fallback' => true,
            'overall_category' => 'good',
            'overall_category_rank' => 1,
            'overall_percentile' => 0.1,
            'overall_statistics' => [
                'percentile' => 0.1,
                'category' => 'good',
                'distributions' => [
                    'good' => 0.1,
                    'needs_improvement' => 0.2,
                    'poor' => 0.3,
                ],
            ],
            'url' => 'https://example.com',
        ];

        return array_replace_recursive($data, $parameters);
    }
}
