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

/**
 * Lighthouse category score rating, following the PageSpeed thresholds.
 */
enum Rating: string
{
    case Poor = 'poor';
    case NeedsImprovement = 'needs-improvement';
    case Good = 'good';

    public static function fromScore(int $value): self
    {
        return match (true) {
            $value >= 90 => self::Good,
            $value >= 50 => self::NeedsImprovement,
            default => self::Poor,
        };
    }
}
