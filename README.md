# PageSeed Api

Google PageSpeed Insights API wrapper for PHP.

## Installation

```bash
composer require smnandre/pagespeed-api
```

## Usage

### Run an analysis

```php
use PageSpeed\Api\Analysis\Category;use PageSpeed\Api\PageSpeedApi;

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

// Loading Experience metrics
$analysis->getLoadingMetrics();

// Origin Loading Experience metrics
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

