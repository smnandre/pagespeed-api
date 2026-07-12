# 🚀 PageSpeed PHP API Client

[![PHP Version](https://img.shields.io/badge/%C2%A0php-%3E%3D%208.3-777BB4.svg?logo=php&logoColor=white)](https://github.com/smnandre/pagespeed-api/blob/main/composer.json)
[![CI](https://github.com/smnandre/pagespeed-api/actions/workflows/CI.yaml/badge.svg)](https://github.com/smnandre/pagespeed-api/actions)
[![Release](https://img.shields.io/github/v/release/smnandre/pagespeed-api)](https://github.com/smnandre/pagespeed-api/releases)
[![License](https://img.shields.io/github/license/smnandre/pagespeed-api?color=cc67ff)](https://github.com/smnandre/pagespeed-api/blob/main/LICENSE)
[![Codecov](https://codecov.io/gh/smnandre/pagespeed-api/graph/badge.svg?token=RC8Z6F4SPC)](https://codecov.io/gh/smnandre/pagespeed-api)

This PHP library offers an effortless way to leverage Google's [PageSpeed Insights](https://pagespeed.web.dev/) API. 

Analyze your web pages for performance metrics, get detailed reports, and optimize your site with ease. 🚀

## Installation

```shell
composer require smnandre/pagespeed-api
```

## Usage

### Initialize the API

```php
use PageSpeed\Api\PageSpeedApi;

$pageSpeedApi = new PageSpeedApi();

// or with API key (optional)
$pageSpeedApi = new PageSpeedApi('YOUR_API_KEY');
```

### Run analysis

```php
// Analyze a page
$analysis = $pageSpeedApi->analyse('https://example.com/');

// ...with a specific strategy (mobile or desktop)
$analysis = $pageSpeedApi->analyse('https://example.com/', 'mobile');

// ...with a specific locale (e.g., fr_FR)
$analysis = $pageSpeedApi->analyse('https://example.com/', locale: 'fr_FR');

// ...with a specific category (performance, accessibility, best-practices, seo)
$analysis = $pageSpeedApi->analyse('https://example.com/', categories: 'performance');
```

#### Parameters

| Parameter | Description                                                              | Default |
|-----------|--------------------------------------------------------------------------|---------|
| `url`     | The URL of the page to analyze.                                          | - |
| `strategy` | The analysis strategy to use. Possible values are `mobile` or `desktop`. | `mobile` |
| `locale` | The locale to use for the analysis.                                      | `en` |
| `categories` | The categories to analyze. If not specified, all categories will be analyzed. | - |

## Report

A display-ready view of an analysis: category scores and Core Web Vitals reached by
property, serialisable to array or JSON.

```php
use PageSpeed\Api\PageSpeedApi;

$pageSpeedApi = new PageSpeedApi();
$report = $pageSpeedApi->analyse('https://www.example.com')->report();

// Scores (null when the category was not analysed)
$report->performance->value;          // 88
$report->performance->rating;         // Rating::NeedsImprovement
$report->performance->rating->value;  // 'needs-improvement'
$report->seo->value;                  // 90

// Core Web Vitals (null when field data is unavailable)
$report->lcp->value;   // 2300
$report->lcp->unit;    // 'ms'
$report->lcp->rating;  // Bucket::Fast

// Serialise for a template, a CLI or an API
$report->toArray();
json_encode($report);
```

Scores (`performance`, `accessibility`, `bestPractices`, `seo`) expose `value` (0-100),
`rating` (a `Rating` following the [Score Evaluation](#score-evaluation) thresholds), and
`category` (`Category`). Metrics (`lcp`, `cls`, `inp`, `fcp`, `fid`, `ttfb`) expose `value`,
`unit`, and `rating` (a `Bucket`: `Fast`, `Average` or `Slow`). Any property is `null` when
the underlying data is absent.

## Audit Scores

![audit-scores.png](docs/audit-scores.png)

```php
use PageSpeed\Api\PageSpeedApi;

$pageSpeedApi = new PageSpeedApi();
$analysis = $pageSpeedApi->analyse('https://www.example.com');

$scores = $analysis->getAuditScores();

// array (
//   'performance' => 100,
//   'accessibility' => 88,
//   'best-practices' => 100,
//   'seo' => 90,
// )
```

### Audit categories

| #  | Category           | Description                                                                          |
|----|--------------------|--------------------------------------------------------------------------------------|
| ⚡  | **Performance**    | Measures how quickly the content on your page loads and becomes interactive.         |
| 🌍 | **Accessibility**  | Evaluates how accessible your page is to users, including those with disabilities.   |
| 🏆 | **Best Practices** | Assesses your page against established web development best practices.               |
| ⚓  | **SEO**            | Analyzes your page's search engine optimization, ensuring it follows SEO guidelines. |


### Score Evaluation

| Min | Max | ⬜️                     | Description       | 
|-----|-----|------------------------|-------------------|
| 0   | 49  | 🟥🟥🟥🟥🟥⬜️⬜️⬜️⬜️⬜️ | Poor              | 
| 50  | 89  | 🟧🟧🟧🟧🟧🟧🟧🟧🟧️⬜️️ | Needs improvement |
| 90  | 100 | 🟩🟩🟩🟩🟩🟩🟩🟩🟩🟩 | Good              |


## Core Web Vitals

![core-web-vitals.png](docs/core-web-vitals.png)

### Loading Metrics

```php
use PageSpeed\Api\PageSpeedApi;

$pageSpeedApi = new PageSpeedApi();
$analysis = $pageSpeedApi->analyse('https://www.example.com');

$metrics = $analysis->getLoadingMetrics();

// array (
//   'CUMULATIVE_LAYOUT_SHIFT_SCORE' => 'FAST',
//   'EXPERIMENTAL_TIME_TO_FIRST_BYTE' => 'AVERAGE',
//   'FIRST_CONTENTFUL_PAINT_MS' => 'FAST',
//   'FIRST_INPUT_DELAY_MS' => 'FAST',
//   'INTERACTION_TO_NEXT_PAINT' => 'FAST',
//   'LARGEST_CONTENTFUL_PAINT_MS' => 'FAST',
// )
```

### Main Metrics

| # | Abbr | Metric                        | Description                                                                                      |
|------|--------------|-------------------------------|--------------------------------------------------------------------------------------------------|
| 🖼️   | **FCP**      | **First Contentful Paint**    | Time taken for the first piece of content to appear on the screen.                                |
| 📏   | **SI**       | **Speed Index**               | How quickly the contents of a page are visibly populated.                                         |
| 📏   | **FID**       | **First Input Delay**               |      |
| 📊   | **CLS**      | **Cumulative Layout Shift**   | Measure of visual stability; the sum of all individual layout shift scores.                        |
| ⏳   | **LCP**      | **Largest Contentful Paint**  | Time taken for the largest content element to appear.                                             |
| ⏱️ | **INP** | Interaction to Next Paint | The time from when a user interacts with a page (e.g., clicks a button) to the next time the page visually updates in response to that interaction. |


## Contributing

Contributions are welcome! If you would like to contribute, please fork the repository and submit a pull request. 

## License

This project is licensed under the MIT License. See the LICENSE file for more information.
