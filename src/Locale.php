<?php

/**
 * This file is part of the miBadger package.
 *
 * @author Michael Webbers <michael@webbers.io>
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 */

namespace miBadger\Locale;

use Locale as LocaleHelper;
use miBadger\Singleton\SingletonTrait;

/**
 * The locale class.
 *
 * language[_territory][.codeset][@modifier]
 *
 * @see https://en.wikipedia.org/wiki/ISO/IEC_15897 locale
 * @see https://en.wikipedia.org/wiki/ISO_639 language
 * @see https://en.wikipedia.org/wiki/ISO_3166 territory
 * @since 1.0.0
 */
class Locale implements \IteratorAggregate
{
	use SingletonTrait;

	const DEFAULT_DOMAIN = 'messages';

	/** @var array The locales. */
	private $locales;

	/** @var string|null The current locale. */
	private $locale;

	/** @var string|null The path. */
	private $path;

	/** @var string The domain. */
	private $domain;

	/**
	 * Construct a Locale object.
	 */
	protected function __construct()
	{
		$this->locales = [];
		$this->locale = null;
		$this->path = null;
		$this->domain = self::DEFAULT_DOMAIN;
	}

	/**
	 * Initialize the locale with the given path and domain.
	 *
	 * @param string $path
	 * @param string $domain = self::DEFAULT_DOMAIN
	 * @return null
	 */
	public static function init(string $path, string $domain = self::DEFAULT_DOMAIN)
	{
		static::getInstance()->path = $path;
		static::getInstance()->domain = $domain;
	}

	/**
	 * Bind the locale.
	 *
	 * @param string $locale
	 * @return null
	 * @throws \RuntimeException on failure.
	 */
	public static function bind($locale)
	{
		if (!static::contains($locale)) {
			throw new LocaleException('Locale doesn\'t exist.');
		}

		static::getInstance()->locale = $locale;

		/* Adds settings to the server environment. */
		putenv('LANGUAGE=' . static::getLocale());

		/* Set locale information. */
		setlocale(LC_ALL, static::getLocale());

		/* Bind domain to a path.  */
		bindtextdomain(static::getDomain(), static::getPath());

		/* Bind domain to a codeset */
		bind_textdomain_codeset(static::getDomain(), static::getCodeset());

		/* Set the text domain */
		textdomain(static::getDomain());
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return new \ArrayIterator(static::getInstance()->locales);
	}

	/**
	 * Returns the number of locales in this set.
	 *
	 * @return int the number of locales in this set.
	 */
	public static function count()
	{
		return count(static::getInstance()->locales);
	}

	/**
	 * Returns true if this set contains no elements.
	 *
	 * @return bool true if this set contains no elements
	 */
	public static function isEmpty()
	{
		return empty(static::getInstance()->locales);
	}

	/**
	 * Returns true if this set contains the specified element.
	 *
	 * @return bool true if this set contains the specified element.
	 */
	public static function contains($locale)
	{
		return in_array($locale, static::getInstance()->locales);
	}

	/**
	 * Adds the specified locale to this set if it is not already present.
	 *
	 * @param string $locale
	 * @return bool true on success and false on failure.
	 */
	public static function add($locale)
	{
		if (static::contains($locale)) {
			return false;
		}

		static::getInstance()->locales[] = $locale;

		return true;
	}

	/**
	 * Removes the specified element from this set if it is present.
	 *
	 * @param string $locale
	 * @return bool true on success and false on failure.
	 */
	public static function remove($locale)
	{
		foreach (static::getInstance()->locales as $key => $value) {
			if ($locale == $value) {
				unset(static::getInstance()->locales[$key]);

				return true;
			}
		}

		return false;
	}

	/**
	 * Removes all of the elements from this set.
	 *
	 * @return bool true on success and false on failure.
	 */
	public static function clear()
	{
		static::getInstance()->locales = [];

		return true;
	}

	/**
	 * Returns the locale.
	 *
	 * @return string the locale.
	 */
	public static function getLocale()
	{
		return static::getInstance()->locale;
	}

	/**
	 * Returns the languge.
	 *
	 * @return string the language.
	 */
	public static function getLanguage()
	{
		preg_match('/^(\S+?)(_|\.|@|\z)/', static::getInstance()->locale, $result);

		return $result[1] ?? null;
	}

	/**
	 * Returns the territory.
	 *
	 * @return string the territory.
	 */
	public static function getTerritory()
	{
		preg_match('/_(\S+?)(\.|@|\z)/', static::getInstance()->locale, $result);

		return $result[1] ?? null;
	}

	/**
	 * Returns the codeset.
	 *
	 * @return string the codeset.
	 */
	public static function getCodeset()
	{
		preg_match('/\.(\S+?)(@|\z)/', static::getInstance()->locale, $result);

		return $result[1] ?? null;
	}

	/**
	 * Returns the modifier.
	 *
	 * @return string the modifier.
	 */
	public static function getModifier()
	{
		preg_match('/@(\S+?)(\z)/', static::getInstance()->locale, $result);

		return $result[1] ?? null;
	}

	/**
	 * Returns the path.
	 *
	 * @return string the path.
	 */
	public static function getPath()
	{
		return static::getInstance()->path;
	}

	/**
	 * Returns the domain.
	 *
	 * @return string the domain.
	 */
	public static function getDomain()
	{
		return static::getInstance()->domain;
	}
}
