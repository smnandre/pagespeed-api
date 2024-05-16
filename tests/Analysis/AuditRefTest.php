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

        $this->assertSame($values['id'], $auditRef->id);
        $this->assertSame($values['weight'], $auditRef->weight);
        $this->assertSame($values['group'], $auditRef->group);
        $this->assertSame($values['acronym'], $auditRef->acronym);
        $this->assertSame($values['relevantAudits'], $auditRef->relevantAudits);
    }

    public function testCanBeCreatedWithDefaultValues(): void
    {
        $values = [
            'id' => 'test-id',
            'weight' => 1,
        ];

        $auditRef = AuditRef::create($values);

        $this->assertSame($values['id'], $auditRef->id);
        $this->assertSame($values['weight'], $auditRef->weight);
        $this->assertNull($auditRef->group);
        $this->assertNull($auditRef->acronym);
        $this->assertNull($auditRef->relevantAudits);
    }

    public function testCreationFailsWithInvalidValues(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $values = [
            'id' => 123,
            'weight' => 'invalid',
        ];

        AuditRef::create($values);
    }
}
