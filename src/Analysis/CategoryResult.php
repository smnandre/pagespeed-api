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

final readonly class CategoryResult
{
    /**
     * @param AuditRef[] $auditRefs
     */
    public function __construct(
        public string $id,
        public string $title,
        public float $score,
        public array $auditRefs = [],
        public ?string $description = null,
        public ?string $manualDescription = null,
    ) {
        Assert::allIsInstanceOf($auditRefs, AuditRef::class);
    }

    /**
     * @param array<string, mixed> $values
     */
    public static function create(array $values): self
    {
        Assert::keyExists($values, 'id');
        Assert::string($values['id']);

        Assert::keyExists($values, 'title');
        Assert::string($values['title']);

        Assert::keyExists($values, 'score');
        Assert::numeric($values['score']);

        Assert::keyExists($values, 'auditRefs');
        Assert::isArray($values['auditRefs']);
        Assert::allIsArray($values['auditRefs']);

        $values['description'] ??= null;
        Assert::nullOrString($values['description']);

        $values['manualDescription'] ??= null;
        Assert::nullOrString($values['manualDescription']);

        return new self(
            $values['id'],
            $values['title'],
            (float) $values['score'],
            array_map(AuditRef::create(...), $values['auditRefs']),
            $values['description'],
            $values['manualDescription'],
        );
    }
}
