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

final readonly class CategoryGroup
{
    public function __construct(
        public string $id,
        public string $title,
        public ?string $description,
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

        $values['description'] ??= null;
        Assert::keyExists($values, 'description');
        Assert::nullOrString($values['description']);

        return new self(
            $values['id'],
            $values['title'],
            $values['description'],
        );
    }
}
