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

final readonly class Audit
{
    /**
     * @param ?array<string, mixed> $details
     * @param ?array<string, mixed> $warnings
     */
    public function __construct(
        public string $id,
        public string $title,
        public string $description,
        public int|float|null $score,
        public string $scoreDisplayMode,
        public ?string $displayValue,
        public ?array $details,
        public int|float|null $numericValue,
        public ?string $numericUnit,
        public ?array $warnings,
    ) {
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

        Assert::keyExists($values, 'description');
        Assert::string($values['description']);

        $values['score'] ??= null;
        Assert::nullOrNumeric($values['score']);

        Assert::keyExists($values, 'scoreDisplayMode');
        Assert::string($values['scoreDisplayMode']);

        $values['details'] ??= null;
        Assert::nullOrIsArray($values['details']);

        $values['displayValue'] ??= null;
        Assert::nullOrString($values['displayValue']);

        $values['numericValue'] ??= null;
        Assert::nullOrNumeric($values['numericValue']);

        $values['numericUnit'] ??= null;
        Assert::nullOrString($values['numericUnit']);

        $values['warnings'] ??= null;
        Assert::nullOrIsArray($values['warnings']);

        return new self(
            $values['id'],
            $values['title'],
            $values['description'],
            $values['score'] ? (float) $values['score'] : null,
            $values['scoreDisplayMode'],
            $values['displayValue'],
            $values['details'],
            $values['numericValue'] ? (float) $values['numericValue'] : null,
            $values['numericUnit'],
            $values['warnings'],
        );
    }
}
