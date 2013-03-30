<?php
/**
 * @copyright	Copyright 2006-2013, Miles Johnson - http://milesj.me
 * @license		http://opensource.org/licenses/mit-license.php - Licensed under the MIT License
 * @link		http://milesj.me/code/php/decoda
 */

namespace Decoda\Hook;

use Decoda\Decoda;
use Decoda\Filter\ImageFilter;
use Decoda\Hook\EmoticonHook;
use Decoda\Test\TestCase;

class EmoticonHookTest extends TestCase {

	/**
	 * Set up Decoda.
	 */
	protected function setUp() {
		parent::setUp();

		$decoda = new Decoda();
		$decoda->addFilter(new ImageFilter());

		$this->object = new EmoticonHook();
		$this->object->setParser($decoda);
		$this->object->startup();
	}

	/**
	 * Test that smiley faces are converted to emoticon images.
	 */
	public function testConversion() {
		$this->assertEquals('<img src="/images/happy.png" alt="">', $this->object->beforeParse(':)'));
		$this->assertEquals('<img src="/images/sad.png" alt="">', $this->object->beforeParse(':('));
		$this->assertEquals('<img src="/images/kiss.png" alt="">', $this->object->beforeParse(':3'));
		$this->assertEquals('<img src="/images/meh.png" alt="">', $this->object->beforeParse('&lt;_&lt;'));
		$this->assertEquals('<img src="/images/heart.png" alt="">', $this->object->beforeParse(':heart:'));
		$this->assertEquals('<img src="/images/wink.png" alt="">', $this->object->beforeParse(';D'));

		// positioning
		$this->assertEquals('<img src="/images/hm.png" alt=""> at the beginning', $this->object->beforeParse(':/ at the beginning'));
		$this->assertEquals('Smiley at the end <img src="/images/gah.png" alt="">', $this->object->beforeParse('Smiley at the end :O'));
		$this->assertEquals('Smiley in the middle <img src="/images/tongue.png" alt=""> of a string', $this->object->beforeParse('Smiley in the middle :P of a string'));
	}

}