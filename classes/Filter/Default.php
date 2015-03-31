<?php namespace KodiCMS\Core\Filter;

class Dummy extends Decorator {
	
	/**
	 * @param string $text
	 * @return string
	 */
	public function apply($text)
	{
		return $text;
	}
}