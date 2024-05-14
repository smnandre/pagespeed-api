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

use Webmozart\Assert\Assert;

final readonly class AuditRef
{
    /**
     * @param list<string>|null $relevantAudits
     */
    public function __construct(
        public string $id,
        public int|float $weight,
        public ?string $group = null,
        public ?string $acronym = null,
        public ?array $relevantAudits = null,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function create(array $values): self
    {
        Assert::keyExists($values, 'id');
        Assert::string($values['id']);

        Assert::keyExists($values, 'weight');
        Assert::numeric($values['weight']);

        $values['group'] ??= null;
        Assert::nullOrString($values['group']);

        $values['acronym'] ??= null;
        Assert::nullOrString($values['acronym']);

        $values['relevantAudits'] ??= null;
        Assert::nullOrIsArray($values['relevantAudits']);

        return new self(
            $values['id'],
            (int) $values['weight'],
            $values['group'],
            $values['acronym'],
            $values['relevantAudits'],
        );
    }
}
