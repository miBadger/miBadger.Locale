<?php

/**
 * This file is part of the miBadger package.
 *
 * @author Michael Webbers <michael@webbers.io>
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0.0
 */

namespace miBadger\Locale;

use miBadger\Singleton\SingletonTrait;

/**
 * The locale class
 *
 * @since 1.0.0
 */
class Locale implements \IteratorAggregate
{
	use SingletonTrait;

	/** @var array The available locales. */
	private $locales;
	/** @var string The name of the current locale. */
	private $current;
	/** @var int The locale path. */
	private $path;
	/** @var string The domain of the locale. */
	private $domain;

	/**
	 * Construct a Locale object.
	 */
	protected function __construct()
	{
		$this->locales = [];
		$this->current = null;
	}

	/**
	 * Initialize the locale.
	 *
	 * @param string $path The locale path, with no trailing slash.
	 * @param string $domain The text domain name.
	 */
	public static function init(string $path, string $domain = 'messages')
	{
		static::getInstance()->path = $path;
		static::getInstance()->domain = $domain;
	}

	/**
	 * Add a locale.
	 *
	 * @param string $name The name for this locale.
	 * @param string $locale The locale string.
	 */
	public static function add(string $name, string $locale)
	{
		static::getInstance()->locales[$name] = $locale;
	}

	/**
	 * Sets the current locale.
	 *
	 * @param array $name The name of the locale.
	 */
	public static function set(string $name)
	{
		if (!array_key_exists($name, static::getInstance()->locales)) {
			throw new \RuntimeException('Locale \'' . $name . '\' was not found');
		}

		static::getInstance()->current = $name;

		static::bind();
	}

	/**
	 * Gets the current locale name.
	 *
	 * @return string $name The name of the current locale.
	 */
	public static function get()
	{
		if (static::getInstance()->current === null) {
			throw new \RuntimeException('No locale set');
		}

		return static::getInstance()->current;
	}

	/**
	 * Binds the current locale.
	 */
	private static function bind()
	{
		$locale = static::getInstance()->locales[static::getInstance()->current];

		putenv('LANGUAGE=' . $locale);
		setlocale(LC_ALL, $locale);
		bindtextdomain(static::getInstance()->domain, static::getInstance()->path);
		bind_textdomain_codeset(static::getInstance()->domain, 'UTF-8');
		textdomain(static::getInstance()->domain);
	}

	/**
	 * Gets the locale path.
	 *
	 * @return string The location of the locale path.
	 */
	public static function path()
	{
		if (static::getInstance()->current === null) {
			throw new \RuntimeException('No locale set');
		}

		$localePath = str_replace('.UTF-8', '', static::getInstance()->locales[static::getInstance()->current]);

		return static::getInstance()->path . '/' . $localePath . '/';
	}

	/**
	 * {@inheritdoc}
	 */
	public function getIterator()
	{
		return new \ArrayIterator(static::getInstance()->locales);
	}

}
