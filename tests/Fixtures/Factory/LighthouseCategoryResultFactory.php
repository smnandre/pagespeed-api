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

class LighthouseCategoryResultFactory
{
    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public static function createData(array $parameters): array
    {
        $data = [
            'id' => 'test-id',
            'auditRefs' => [
                [
                    'id' => 'first-contentful-paint',
                    'weight' => 1,
                    'group' => 'metrics',
                ],
                [
                    'id' => 'speed-index',
                    'weight' => 1,
                    'group' => 'metrics',
                ],
                [
                    'id' => 'largest-contentful-paint',
                    'weight' => 1,
                    'group' => 'metrics',
                ],
                [
                    'id' => 'interactive',
                    'weight' => 1,
                    'group' => 'metrics',
                ],
                [
                    'id' => 'total-blocking-time',
                    'weight' => 1,
                    'group' => 'metrics',
                ],
                [
                    'id' => 'cumulative-layout-shift',
                    'weight' => 1,
                    'group' => 'metrics',
                ],
            ],
            'category' => 'performance',
            'title' => 'Performance',
            'description' => 'Description',
            'score' => 0.9,
        ];

        return array_replace_recursive($data, $parameters);
    }
}
