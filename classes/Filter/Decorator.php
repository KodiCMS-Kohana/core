<?php namespace KodiCMS\Core\Filter;

abstract class Decorator {

	/**
	 * @param string $text
	 * @return string
	 */
	abstract public function apply($text);
}
