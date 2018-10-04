[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nystudio107/craft-templatecomments/badges/quality-score.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-templatecomments/?branch=v1) [![Code Coverage](https://scrutinizer-ci.com/g/nystudio107/craft-templatecomments/badges/coverage.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-templatecomments/?branch=v1) [![Build Status](https://scrutinizer-ci.com/g/nystudio107/craft-templatecomments/badges/build.png?b=v1)](https://scrutinizer-ci.com/g/nystudio107/craft-templatecomments/build-status/v1) [![Code Intelligence Status](https://scrutinizer-ci.com/g/nystudio107/craft-templatecomments/badges/code-intelligence.svg?b=v1)](https://scrutinizer-ci.com/code-intelligence)

# Template Comments plugin for Craft CMS 3.x

Adds a HTML comment with performance timings to demarcate `{% block %}`s and each Twig template that is included or extended.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require nystudio107/craft-templatecomments

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Template Comments.

You can also install Template Comments via the **Plugin Store** in the Craft AdminCP.

## Template Comments Overview

Template Comments is a debugging tool that wraps your Twig `{% block %}`s and templates that you `{% include %}` with HTML comments. By default, it does this only when `devMode` is on.

It also records performance data, so you know how much overhead each `{% block %}` or `{% include %}` is adding.

With more complicated "content builder" setups, this can help bring clarity to where the various HTML on your pages is coming from.

This can be especially handy when dealing with OPC (Other People's Code). It solves [this problem](https://craftcms.stackexchange.com/questions/27769/how-can-i-print-the-name-of-every-template-being-rendered-in-html-comments-when).

![Screenshot](resources/screenshots/templatecomments-example.png)

## Configuring Template Comments

All configuration is done via the `config.php`. For it to work, you'll need to copy it to your `craft/config/` directory, and rename it `templatecomments.php`

Here's what the default settings look like:

```php
return [
    /**
     * @var bool Whether comments should be generated for site templates
     */
    'siteTemplateComments' => true,

    /**
     * @var bool Whether comments should be generated for AdminCP templates
     */
    'cpTemplateComments' => false,

    /**
     * @var bool Whether to generate comments only when `devMode` is on
     */
    'onlyCommentsInDevMode' => true,

    /**
     * @var bool Whether or not to show comments for templates that are include'd
     */
    'templateCommentsEnabled' => true,

    /**
     * @var bool Whether or not to show comments for `{% block %}`s
     */
    'blockCommentsEnabled' => true,

    /**
     * @var array Template file suffixes that Template Comments should be enabled for
     */
    'allowedTemplateSuffixes' => [
        '',
        'twig',
        'htm',
        'html',
    ],
];
```

## Using Template Comments

Nothing much to say here; install the plugin, and it "just works". If `devMode` is off, it doesn't even install itself, so there should be zero effect in production.

The `<<< END <<<` comments all include performance data in milliseconds, e.g.:
```html
<!-- 22.34ms <<< TEMPLATE END <<< templatecomments/_layout.twig -->
```

## Template Comments Roadmap

Some things to do, and ideas for potential features:

* Support wrapping macros in comments

Brought to you by [nystudio107](https://nystudio107.com/)
