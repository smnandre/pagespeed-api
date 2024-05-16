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
            'overall_category' => 'good',
            'metrics' => [
                'cumulative_layout_shift' => [
                    'category' => 'good',
                    'distributions' => [
                    ],
                    'percentile' => 4,
                ],
                'first_contentful_paint' => [
                    'category' => 'good',
                    'distributions' => [
                    ],
                    'percentile' => 4,
                ],
                'first_input_delay' => [
                    'category' => 'good',
                    'distributions' => [
                    ],
                    'percentile' => 4,
                ],
                'largest_contentful_paint' => [
                    'category' => 'good',
                    'distributions' => [
                    ],
                    'percentile' => 4,
                ],
            ],
            'origin_fallback' => true,
        ];

        return array_replace_recursive($data, $parameters);
    }
}
