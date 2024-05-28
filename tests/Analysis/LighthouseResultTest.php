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

namespace PageSpeed\Api\Tests\Analysis;

use PageSpeed\Api\Analysis\Audit;
use PageSpeed\Api\Analysis\LighthouseResult;
use PageSpeed\Api\Tests\Fixtures\Factory\LighthouseCategoryResultFactory;
use PageSpeed\Api\Tests\Fixtures\Factory\LighthouseResultFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LighthouseResult::class)]
class LighthouseResultTest extends TestCase
{
    public function testCanBeCreatedFromValues(): void
    {
        $values = LighthouseResultFactory::createData([]);

        $lighthouseResult = LighthouseResult::create($values);

        self::assertSame($values['requestedUrl'], $lighthouseResult->requestedUrl);
        self::assertSame($values['finalUrl'], $lighthouseResult->finalUrl);
        self::assertSame($values['lighthouseVersion'], $lighthouseResult->lighthouseVersion);
    }
}
