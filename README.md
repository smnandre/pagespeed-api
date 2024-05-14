# PageSeed Api

This library provides a simple way to interact with the Google PageSpeed Insights API.

```php
use PageSpeed\Api\PageSpeedApi;

$api = new PageSpeedApi('YOUR_API');

$audit = $api->audit('https://www.example.com');

echo $audit->getScore(); // 100
echo $audit->performanceScore(); // 100
echo $audit->getAccessibilityScore(); // 100
echo $audit->getBestPracticesScore(); // 100
```


## Installation

```bash
composer require smnandre/pagespeed-api
```

## Usage


### PageSpeed Api Key

```php
use PageSpeed\Api\PageSpeedApi;

$api = new PageSpeedApi('YOUR_API');
```

### Audit Strategy	

```php
// Mobile strategy (default)
$audit = $api->audit('https://example.com/', 'mobile');

// Desktop strategy
$audit = $api->audit('https://example.com/', 'desktop');
```

```php
use PageSpeed\Api\PageSpeedApi;

$api = new PageSpeedApi();

$audit = $api->audit('https://www.example.com');

echo $audit->getScore();
echo $audit->performanceScore();
echo $audit->getAccessibilityScore();
echo $audit->getBestPracticesScore();
echo $audit->getSeoScore();
```
