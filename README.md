# PageSeed Api

This library provides a simple way to interact with the Google PageSpeed Insights API.

```php
use PageSpeed\Api\Analysis\Category;use PageSpeed\Api\PageSpeedApi;

$api = new PageSpeedApi('YOUR_API');

$analysis = $api->analyse('https://www.example.com');

// LightHouse scores
echo $audit->getPerformancesScore(); // 100
echo $audit->getAccessibilityScore(); // 88
echo $audit->getBestPracticesScore(); // 100
echo $audit->getSeoScore(); // 90

// Loading Experience metrics
echo $audit->getLargestContentfulPaint(); // 
echo $audit->getInteractiveToNextPaint(); // 
echo $audit->getCumulativeLayoutShift(); // 
echo $audit->getFirstContentfulPaint(); // 
echo $audit->getFirstInputDelay(); // 
echo $audit->getTimeToFirstByte(); // 
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

### Parameters

#### Audit Strategy	

```php
// Mobile strategy (default)
$audit = $api->analyse('https://example.com/', 'mobile');

// Desktop strategy
$audit = $api->analyse('https://example.com/', 'desktop');
```

#### Analysis Categories


### Response 

#### Analysis


#### Loading Experience


#### Original Loading Experience

.. 

#### Lighthouse

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
