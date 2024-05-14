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

use PageSpeed\Api\Analysis\Category;
use PageSpeed\Api\Analysis\Strategy;

interface PageSpeedApiInterface
{
    /**
     * @param list<Category> $category
     */
    public function analyse(string $url, ?Strategy $strategy = null, ?string $locale = null, array $category = []): Analysis;
}
