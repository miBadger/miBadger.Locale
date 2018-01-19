# Locale

The locale class.

## Example(s)

```php
<?php

use miBadger/Locale;

/**
 * Initialize the locale with the translation file directory and text domain.
 */
Locale::init(__DIR__ . '/locale', 'messages');

/**
 * {@inheritdoc}
 */
Locale::getIterator();

/**
 * Add a locale entry to the possible locales.
 */
Locale::add('nl', 'nl_NL');

/**
 * Use a previously-added locale.
 */
Locale::set('nl');

/**
 * Retrieves the currently set locale.
 */
Locale::get();

/**
 * Returns the path of the current locale.
 */
Locale::path();

/**
 * Get an iterator with each locale added.
 */
Locale::getIterator();
```
