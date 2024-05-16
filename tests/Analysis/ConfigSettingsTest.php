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

use PageSpeed\Api\Analysis\ConfigSettings;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConfigSettings::class)]
class ConfigSettingsTest extends TestCase
{
    public function testCanBeCreatedFromValues(): void
    {
        $values = [
            'onlyCategories' => ['performance', 'accessibility'],
            'locale' => 'en-US',
            'channel' => 'desktop',
            'formFactor' => 'desktop',
        ];

        $configSettings = ConfigSettings::create($values);

        self::assertSame($values['onlyCategories'], $configSettings->onlyCategories);
        self::assertSame($values['locale'], $configSettings->locale);
        self::assertSame($values['channel'], $configSettings->channel);
        self::assertSame($values['formFactor'], $configSettings->formFactor);
    }

    public function testCreationFailsWithMissingValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'onlyCategories' => ['performance', 'accessibility'],
            'locale' => 'en-US',
            'channel' => 'desktop',
        ];

        ConfigSettings::create($values);
    }

    public function testCreationFailsWithInvalidValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'onlyCategories' => 'performance',
            'locale' => 'en-US',
            'channel' => 'desktop',
            'formFactor' => 'desktop',
        ];

        ConfigSettings::create($values);
    }
}
