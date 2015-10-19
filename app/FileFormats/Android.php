<?php

namespace Twine\FileFormats;

class Android extends AbstractXml implements FileFormatInterface
{
	protected $format = 'android';

	public function read($path) {

		parent::read($path);
		
		$this->makeSource();
		
		$strings = $this->parsed['value'];
		
		foreach ($strings as $string)
		{
			if ($string['name'] == '{}string')
			{
				$this->makeString($string['attributes']['name'], $string['attributes']['name'], $string['value']);
			}
			elseif ($string['name'] == '{}string-array')
			{
				$i = 0;
				foreach ($string['value'] as $value) {
					$this->makeString([$string['attributes']['name'], $i], $string['attributes']['name'], $value['value']);
					$i++;
				}
			}
			elseif ($string['name'] == '{}plurals')
			{
				foreach ($string['value'] as $value) {
					$this->makeString([$string['attributes']['name'], $value['attributes']['quantity']], $string['attributes']['name'], $value['value'], $value['attributes']['quantity']);
				}
			}
		}
		
		dd($this);
		

		
	}
	
	// public function write($file, $data) {
		
	// }
	
}