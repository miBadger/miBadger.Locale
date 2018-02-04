# Locale

The locale class.

## Example(s)

```php
<?php

use miBadger/Locale;

/**
 * Initialize the locale with the given path and domain.
 */
Locale::init(string $path, string $domain = self::DEFAULT_DOMAIN);

/**
 * Bind the locale.
 */
Locale::bind($locale);

/**
 * {@inheritdoc}
 */
Locale::getInstance()->getIterator();

/**
 * Returns the number of locales in this set.
 */
Locale::count();

/**
 * Returns true if this set contains no elements.
 */
Locale::isEmpty();

/**
 * Returns true if this set contains the specified element.
 */
Locale::contains($locale);

/**
 * Adds the specified locale to this set if it is not already present.
 */
Locale::add($locale);

/**
 * Removes the specified element from this set if it is present.
 */
Locale::remove($locale);

/**
 * Removes all of the elements from this set.
 */
Locale::clear();

/**
 * Returns the locale.
 */
Locale::getLocale();

/**
 * Returns the languge.
 */
Locale::getLanguage();

/**
 * Returns the territory.
 */
Locale::getTerritory();

/**
 * Returns the codeset.
 */
Locale::getCodeset();

/**
 * Returns the modifier.
 */
Locale::getModifier();

/**
 * Returns the path.
 */
Locale::getPath();

/**
 * Returns the domain.
 */
Locale::getDomain();
```
