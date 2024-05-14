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

namespace PageSpeed\Api\Tests\Fixtures;

class AnalysisFactory
{
    /**
     * @param array<string, mixed> $parameters
     * @return array<string, mixed>
     */
    public static function createData(array $parameters): array
    {
        $data = [
            'id' => 'test-id',
            'analysisUTCTimestamp' => '2022-01-01T00:00:00Z',
            'loadingExperience' => LoadingExperienceFactory::createData([]),
            'originLoadingExperience' => LoadingExperienceFactory::createData([]),
            'lighthouseResult' => LighthouseResultFactory::createData([]),
        ];

        return array_replace_recursive($data, $parameters);
    }
}
