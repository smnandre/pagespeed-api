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

namespace PageSpeed\Api\Tests\Fixtures;

class ConfigSettingsFactory
{
    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public static function createData(array $parameters): array
    {
        $data = [
            'onlyCategories' => [
                'seo',
                'pwa',
            ],
            'locale' => 'en',
            'formFactor' => 'desktop',
            'channel' => 'foo',
        ];

        return array_replace_recursive($data, $parameters);
    }
}
