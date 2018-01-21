# Locale

[![Build Status](https://scrutinizer-ci.com/g/miBadger/miBadger.Locale/badges/build.png?b=master)](https://scrutinizer-ci.com/g/miBadger/miBadger.Locale/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/miBadger/miBadger.Locale/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/miBadger/miBadger.Locale/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/miBadger/miBadger.Locale/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/miBadger/miBadger.Locale/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/d411363f-dbf8-4168-980a-6ce96a66aa54/mini.png)](https://insight.sensiolabs.com/projects/d411363f-dbf8-4168-980a-6ce96a66aa54)

The Locale Component.

## Example

```php
<?php

use miBadger\Locale;

/**
 * Initialize the locales.
 * This uses the directory 'locale' to look for the translation files, and the 'messages' text domain.
 * Make sure the correct folders and MO files are created! See below for more information.
 */
Locale::init(__DIR__ . '/locale', 'messages');

/**
 * Add the different available locales.
 */
Locale::add('nl', 'nl_NL.UTF-8');
Locale::add('de', 'de_DE.UTF-8');

/**
 * Choose what locale you want to use.
 */
Locale::set('nl');

/**
 * Now you can use gettext, which should return the translated strings (if present in the MO files).
 * It is also possible to call another set() function to chance locale.
 */
```


## Translation files
Given the example above, the following files should be present:
```
locale/
	nl_NL/
		LC_MESSAGES/
			messages.mo
	de_DE/
		LC_MESSAGES/
			messages.mo
```
The `locale` directory is set in the `Locale::init` function.
The second parameter is the text domain (for our purposes, the name of the MO files).
