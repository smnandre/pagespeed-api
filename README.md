# 🚀 PageSpeed PHP API Client


<a href="https://github.com/smnandre/pagespeed-api/actions"><img alt="javscript-action status" src="https://github.com/smnandre/pagespeed-api/actions/workflows/CI.yaml/badge.svg"></a>
<a href="https://img.shields.io/github/v/release/smnandre/pagespeed-api"><img alt="release" src="https://img.shields.io/github/v/release/smnandre/pagespeed-api"></a>
<a href="https://img.shields.io/github/license/smnandre/pagespeed-api"><img alt="license" src="https://img.shields.io/github/license/smnandre/pagespeed-api?color=cc67ff"></a>
<a href="https://codecov.io/gh/smnandre/pagespeed-api" ><img src="https://codecov.io/gh/smnandre/pagespeed-api/graph/badge.svg?token=RC8Z6F4SPC"/></a>

This PHP library offers an effortless way to leverage Google's PageSpeed Insights API. 

Analyze your web pages for performance metrics, get detailed reports, and optimize your site with ease. 🚀

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


## Analysis

### Audit categories

| # | Category           | Description                                                                                  |
|------|--------------------|----------------------------------------------------------------------------------------------|
| ⚡   | **Performance**    | Measures how quickly the content on your page loads and becomes interactive.                 |
| 🌍   | **Accessibility**  | Evaluates how accessible your page is to users, including those with disabilities.           |
| 🏆   | **Best Practices** | Assesses your page against established web development best practices.                       |
| ⚓   | **SEO**            | Analyzes your page's search engine optimization, ensuring it follows SEO guidelines.         |
| 📱   | **PWA**            | Checks if your page meets the criteria for a Progressive Web App, providing a native-like experience. |

### Main Metrics

| # | Abbr | Metric                        | Description                                                                                      |
|------|--------------|-------------------------------|--------------------------------------------------------------------------------------------------|
| 🖼️   | **FCP**      | **First Contentful Paint**    | Time taken for the first piece of content to appear on the screen.                                |
| ⏱️   | **TTI**      | **Time to Interactive**       | Time taken for the page to become fully interactive.                                              |
| 📏   | **SI**       | **Speed Index**               | How quickly the contents of a page are visibly populated.                                         |
| 📊   | **CLS**      | **Cumulative Layout Shift**   | Measure of visual stability; the sum of all individual layout shift scores.                        |
| ⏳   | **LCP**      | **Largest Contentful Paint**  | Time taken for the largest content element to appear.                                             |
| ⛔   | **TBT**      | **Total Blocking Time**       | Total time that the main thread was blocked, preventing user interaction.                          |


## Contributing

Contributions are welcome! If you would like to contribute, please fork the repository and submit a pull request. For major changes, please open an issue to discuss what you would like to change.

## License

This project is licensed under the MIT License. See the LICENSE file for more information.
