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

class EnvironmentFactory
{
    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public static function createData(array $parameters): array
    {
        $data = [
            'networkUserAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36',
            'hostUserAgent' => 'Webkit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36',
            'benchmarkIndex' => 42,
        ];

        return array_replace_recursive($data, $parameters);
    }
}
