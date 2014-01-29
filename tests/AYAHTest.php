<?php

class AYAHTest extends PHPUnit_Framework_TestCase
{
	// These keys are just for testing...
	private $config = [
		'publisher_key' => '01f70454bada303692be5f36a8fd104eba8b00dd',
		'scoring_key'   => '80cc3f9c6e1da29369c238d55bd8528a968473ad',
	];

	private $ayah;

	public function setUp()
	{
		$this->ayah = new AYAH($this->config);
		$this->ayah->debug_mode(false);
	}

	public function testInstanceOf()
	{
		$this->assertInstanceOf('AYAH', $this->ayah);
	}

	public function testGetPublisherHTML()
	{
		$this->assertRegExp(
			'/<div id=\'AYAH\'><\/div><script src=\'https:\/\/ws.areyouahuman.com\/ws\/script\/[a-z0-9]{40}\/ip[a-zA-Z0-9]{43}\' type=\'text\/javascript\' language=\'JavaScript\'><\/script>/',
			$this->ayah->getPublisherHTML()
		);
	}

	// Unfortunately there's no way to test a true response (mock maybe?)
	public function testScoreResultFailure()
	{
		$this->assertFalse($this->ayah->scoreResult());
	}

	public function testRecordConversionMissingSessionSecret()
	{
		$this->assertFalse($this->ayah->recordConversion());
	}

	public function testDebugMode()
	{
		$this->expectOutputRegex('/Debug mode is now on./');
		$this->assertTrue($this->ayah->debug_mode(true));
	}
}

?>
