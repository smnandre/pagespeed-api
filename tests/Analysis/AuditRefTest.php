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

use PageSpeed\Api\Analysis\AuditRef;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuditRef::class)]
final class AuditRefTest extends TestCase
{
    public function testCanBeCreatedFromValues(): void
    {
        $values = [
            'id' => 'test-id',
            'weight' => 1,
            'group' => 'test-group',
            'acronym' => 'test-acronym',
            'relevantAudits' => ['test-audit'],
        ];

        $auditRef = AuditRef::create($values);

        self::assertSame($values['id'], $auditRef->id);
        self::assertSame($values['weight'], $auditRef->weight);
        self::assertSame($values['group'], $auditRef->group);
        self::assertSame($values['acronym'], $auditRef->acronym);
        self::assertSame($values['relevantAudits'], $auditRef->relevantAudits);
    }

    public function testCanBeCreatedWithDefaultValues(): void
    {
        $values = [
            'id' => 'test-id',
            'weight' => 1,
        ];

        $auditRef = AuditRef::create($values);

        self::assertSame($values['id'], $auditRef->id);
        self::assertSame($values['weight'], $auditRef->weight);
        self::assertNull($auditRef->group);
        self::assertNull($auditRef->acronym);
        self::assertNull($auditRef->relevantAudits);
    }

    public function testCreationFailsWithInvalidValues(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 123,
            'weight' => 'invalid',
        ];

        AuditRef::create($values);
    }
}
