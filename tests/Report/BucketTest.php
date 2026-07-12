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

namespace PageSpeed\Api\Tests\Report;

use PageSpeed\Api\Report\Bucket;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Bucket::class)]
final class BucketTest extends TestCase
{
    public function testBackingValuesMirrorCruxCategories(): void
    {
        self::assertSame('FAST', Bucket::Fast->value);
        self::assertSame('AVERAGE', Bucket::Average->value);
        self::assertSame('SLOW', Bucket::Slow->value);
    }

    public function testMapsFromCruxCategory(): void
    {
        self::assertSame(Bucket::Fast, Bucket::tryFrom('FAST'));
        self::assertSame(Bucket::Slow, Bucket::tryFrom('SLOW'));
    }
}
