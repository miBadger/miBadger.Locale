<?php

/**
 * This file is part of the miBadger package.
 *
 * @author Michael Webbers <michael@webbers.io>
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 */

namespace miBadger\Locale;

use PHPUnit\Framework\TestCase;

/**
 * The locale test.
 *
 * @since 1.0.0
 */
class LocaleTest extends TestCase
{
	public function setUp()
	{
		$object = Locale::getInstance();
		$reflection = new \ReflectionClass(get_class($object));
		$method = $reflection->getMethod('__construct');
		$method->setAccessible(true);
		$method->invokeArgs($object, []);
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testInit()
	{
		$this->assertNull(Locale::init(__DIR__ . '/locale', 'messages'));
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testBind()
	{
		$this->assertNull(Locale::init(__DIR__ . '/locale', 'messages'));
		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertTrue(Locale::add('en_GB.UTF-8'));

		$this->assertNull(Locale::bind('nl_NL.UTF-8'));
		$this->assertEquals(gettext('first'), 'Eerste test string nl_NL');
		$this->assertEquals(gettext('second'), 'Tweede test string nl_NL');

		$this->assertNull(Locale::bind('en_GB.UTF-8'));
		$this->assertEquals(gettext('first'), 'First test string en_GB');
		$this->assertEquals(gettext('second'), 'Second test string en_GB');
	}

	/**
	 * @runInSeparateProcess
	 * @expectedException miBadger\Locale\LocaleException
	 * @expectedExceptionMessage Locale doesn't exist.
	 */
	public function testBindEception()
	{
		Locale::bind('nl_NL.UTF-8');
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testGetIterator()
	{
		Locale::add('nl_NL.UTF-8');
		Locale::add('en_GB.UTF-8');

		$this->assertEquals(new \ArrayIterator(['nl_NL.UTF-8', 'en_GB.UTF-8']), Locale::getInstance()->getIterator());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testCount()
	{
		$this->assertEquals(0, Locale::count());
		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertEquals(1, Locale::count());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testIsEmpty()
	{
		$this->assertTrue(Locale::isEmpty());
		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertFalse(Locale::isEmpty());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testAdd()
	{
		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertFalse(Locale::add('nl_NL.UTF-8'));
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testRemove()
	{
		$this->assertFalse(Locale::remove('nl_NL.UTF-8'));
		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertTrue(Locale::remove('nl_NL.UTF-8'));
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testClear()
	{
		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertFalse(Locale::isEmpty());
		$this->assertTrue(Locale::clear());
		$this->assertTrue(Locale::isEmpty());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testGetLocale()
	{
		$this->assertNull(Locale::getLocale());
		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertNull(Locale::bind('nl_NL.UTF-8'));
		$this->assertEquals('nl_NL.UTF-8', Locale::getLocale());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testGetLanguage()
	{
		$this->assertNull(Locale::getLanguage());

		$this->assertTrue(Locale::add('nl'));
		$this->assertNull(Locale::bind('nl'));
		$this->assertEquals('nl', Locale::getLanguage());

		$this->assertTrue(Locale::add('nl_NL'));
		$this->assertNull(Locale::bind('nl_NL'));
		$this->assertEquals('nl', Locale::getLanguage());

		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertNull(Locale::bind('nl_NL.UTF-8'));
		$this->assertEquals('nl', Locale::getLanguage());

		$this->assertTrue(Locale::add('nl_NL.UTF-8@test'));
		$this->assertNull(Locale::bind('nl_NL.UTF-8@test'));
		$this->assertEquals('nl', Locale::getLanguage());

		$this->assertTrue(Locale::add('nl_NL@test'));
		$this->assertNull(Locale::bind('nl_NL@test'));
		$this->assertEquals('nl', Locale::getLanguage());

		$this->assertTrue(Locale::add('nl.UTF-8'));
		$this->assertNull(Locale::bind('nl.UTF-8'));
		$this->assertEquals('nl', Locale::getLanguage());

		$this->assertTrue(Locale::add('nl.UTF-8@test'));
		$this->assertNull(Locale::bind('nl.UTF-8@test'));
		$this->assertEquals('nl', Locale::getLanguage());

		$this->assertTrue(Locale::add('nl@test'));
		$this->assertNull(Locale::bind('nl@test'));
		$this->assertEquals('nl', Locale::getLanguage());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testGetTerritory()
	{
		$this->assertNull(Locale::getTerritory());

		$this->assertTrue(Locale::add('nl'));
		$this->assertNull(Locale::bind('nl'));
		$this->assertNull(Locale::getTerritory());

		$this->assertTrue(Locale::add('nl_NL'));
		$this->assertNull(Locale::bind('nl_NL'));
		$this->assertEquals('NL', Locale::getTerritory());

		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertNull(Locale::bind('nl_NL.UTF-8'));
		$this->assertEquals('NL', Locale::getTerritory());

		$this->assertTrue(Locale::add('nl_NL.UTF-8@test'));
		$this->assertNull(Locale::bind('nl_NL.UTF-8@test'));
		$this->assertEquals('NL', Locale::getTerritory());

		$this->assertTrue(Locale::add('nl_NL@test'));
		$this->assertNull(Locale::bind('nl_NL@test'));
		$this->assertEquals('NL', Locale::getTerritory());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testGetCodeset()
	{
		$this->assertNull(Locale::getCodeset());

		$this->assertTrue(Locale::add('nl_NL'));
		$this->assertNull(Locale::bind('nl_NL'));
		$this->assertNull(Locale::getModifier());

		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertNull(Locale::bind('nl_NL.UTF-8'));
		$this->assertEquals('UTF-8', Locale::getCodeset());

		$this->assertTrue(Locale::add('nl_NL.UTF-8@test'));
		$this->assertNull(Locale::bind('nl_NL.UTF-8@test'));
		$this->assertEquals('UTF-8', Locale::getCodeset());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testGetModifier()
	{
		$this->assertNull(Locale::getModifier());

		$this->assertTrue(Locale::add('nl_NL.UTF-8'));
		$this->assertNull(Locale::bind('nl_NL.UTF-8'));
		$this->assertNull(Locale::getModifier());

		$this->assertTrue(Locale::add('nl_NL.UTF-8@test'));
		$this->assertNull(Locale::bind('nl_NL.UTF-8@test'));
		$this->assertEquals('test', Locale::getModifier());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testGetPath()
	{
		$this->assertNull(Locale::init(__DIR__ . '/locale', 'messages'));
		$this->assertEquals(__DIR__ . '/locale', Locale::getPath());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testGetDomain()
	{
		$this->assertNull(Locale::init(__DIR__ . '/locale', 'messages'));
		$this->assertEquals('messages', Locale::getDomain());
	}
}
