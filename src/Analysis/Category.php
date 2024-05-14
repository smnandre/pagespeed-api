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

enum Category: string
{
    case Accessibility = 'accessibility';
    case BestPractices = 'best-practices';
    case Performance = 'performance';
    case Seo = 'seo';

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_map(static fn (self $category) => $category->value, self::cases());
    }
}
