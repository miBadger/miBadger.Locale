<?php

/**
 * This file is part of the miBadger package.
 *
 * @author Michael Webbers <michael@webbers.io>
 * @license http://opensource.org/licenses/Apache-2.0 Apache v2 License
 * @version 1.0.0
 */

namespace miBadger\Locale;

/**
 * The locale test.
 *
 * @since 1.0.0
 */
class LocaleTest extends \PHPUnit_Framework_TestCase
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
 	 * @expectedException \RuntimeException
 	 * @expectedExceptionMessage Locale 'test' was not found
	 */
	public function testSetException()
	{
		$this->assertNull(Locale::set('test'));
	}

	/**
	 * @runInSeparateProcess
 	 * @expectedException \RuntimeException
 	 * @expectedExceptionMessage No locale set
	 */
	public function testGetException()
	{
		$this->assertNull(Locale::get());
	}

	/**
	 * @runInSeparateProcess
 	 * @expectedException \RuntimeException
 	 * @expectedExceptionMessage No locale set
	 */
	public function testPathException()
	{
		$this->assertNull(Locale::path());
	}

	/**
	 * @runInSeparateProcess
	 */
	public function testInit()
	{
		Locale::init(__DIR__ . '/locale', 'messages');
	}

	/**
	 * @depends testInit
	 */
	public function testAdd()
	{
		Locale::add('nl', 'nl_NL.UTF-8');
		Locale::add('en', 'en_GB.UTF-8');
	}

	/**
	 * @depends testAdd
	 */
	public function testSet()
	{
		Locale::init(__DIR__ . '/locale', 'messages');

		Locale::add('nl', 'nl_NL.UTF-8');
		Locale::add('en', 'en_GB.UTF-8');

		Locale::set('nl');

		$this->assertEquals(Locale::get(), 'nl');
	}

	/**
	 * @depends testInit
	 */
	public function testGetIterator()
	{
		Locale::add('nl', 'nl_NL.UTF-8');
		Locale::add('en', 'en_GB.UTF-8');

		$this->assertEquals(new \ArrayIterator(['nl' => 'nl_NL.UTF-8', 'en' => 'en_GB.UTF-8']), Locale::getInstance()->getIterator());
	}

	/**
	 * @depends testInit
	 * @depends testSet
	 */
	public function testPath()
	{
		Locale::init(__DIR__ . '/locale', 'messages');
		Locale::add('nl', 'nl_NL.UTF-8');
		Locale::set('nl');

		$this->assertEquals(Locale::path(), __DIR__ . '/locale/nl_NL/');
	}

	/**
	 * @depends testPath
	 * @depends testSet
	 */
	public function testBindings()
	{
		Locale::init(__DIR__ . '/locale', 'messages');

		Locale::add('nl', 'nl_NL.UTF-8');
		Locale::add('en', 'en_GB.UTF-8');

		Locale::set('nl');

		$this->assertEquals( gettext('first'), 'Eerste test string nl_NL');
		$this->assertEquals( gettext('second'), 'Tweede test string nl_NL');

		Locale::set('en');

		$this->assertEquals( gettext('first'), 'First test string en_GB');
		$this->assertEquals( gettext('second'), 'Second test string en_GB');
	}
}
