# PageSeed Api

Google PageSpeed Insights API wrapper for PHP.

---
<a href="https://github.com/smnandre/pagespeed-api/actions"><img alt="javscript-action status" src="https://github.com/smnandre/pagespeed-api/actions/workflows/CI.yaml/badge.svg"></a>
<a href="https://img.shields.io/github/v/release/smnandre/pagespeed-api"><img alt="release" src="https://img.shields.io/github/v/release/smnandre/pagespeed-api"></a>
<a href="https://img.shields.io/github/license/smnandre/pagespeed-api"><img alt="license" src="https://img.shields.io/github/license/smnandre/pagespeed-api"></a>


## Installation

```bash
composer require smnandre/pagespeed-api
```

## Usage

### Run an analysis

```php
use PageSpeed\Api\PageSpeedApi;

$api = new PageSpeedApi('YOUR_API');

$analysis = $api->analyse('https://www.example.com');
```

### Get the results

```php

// LightHouse scores
$analysis->getAuditScores();
// 'performance' => 100,
// 'accessibility' => 88,
// 'best-practices' => 100,
// 'seo' => 90

$analysis->getLoadingMetrics();

$analysis->getOriginalLoadingMetrics();
```

### Parameters

#### Strategy	

```php
// Mobile strategy (default)
$analysis = $api->analyse('https://example.com/', 'mobile');

// Desktop strategy
$analysis = $api->analyse('https://example.com/', 'desktop');
```

#### Locale

```php
$analysis = $api->analyse('https://example.com/', 'mobile', 'fr');
```

