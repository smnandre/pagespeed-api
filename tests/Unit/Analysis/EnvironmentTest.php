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

namespace PageSpeed\Api\Tests\Unit\Audit;

use PageSpeed\Api\Analysis\Environment;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Environment::class)]
class EnvironmentTest extends TestCase
{
    public function testCanBeCreatedFromValues(): void
    {
        $values = [
            'networkUserAgent' => 'Mozilla/5.0 (X11; Linux x86_64)..',
            'hostUserAgent' => 'Mozilla/6.0 (X11; Linux x86_64)...',
            'benchmarkIndex' => 0.5,
        ];

        $environment = Environment::create($values);

        self::assertSame($values['networkUserAgent'], $environment->networkUserAgent);
        self::assertSame($values['hostUserAgent'], $environment->hostUserAgent);
        self::assertSame($values['benchmarkIndex'], $environment->benchmarkIndex);
    }

    public function testCreationFailsWithMissingValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'hostUserAgent' => 'Mozilla/6.0 (X11; Linux x86_64)...',
            'benchmarkIndex' => 0.5,
        ];

        Environment::create($values);
    }

    public function testCreationFailsWithInvalidValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'networkUserAgent' => 'Mozilla/5.0 (X11; Linux x86_64)..',
            'hostUserAgent' => 'Mozilla/6.0 (X11; Linux x86_64)...',
            'benchmarkIndex' => 'foo',
        ];

        Environment::create($values);
    }
}
