<?php namespace KodiCMS\Core;

/**
 * @package		KodiCMS
 * @author		butschster <butschster@gmail.com>
 * @link		http://kodicms.ru
 * @copyright	(c) 2012-2014 butschster
 * @license		http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class Form extends \Kohana\Core\Form {

	/**
	 * Add .form-inline for left-aligned labels and inline-block controls 
	 * for a compact layout.
	 */
	const INLINE = 'form-inline';

	/**
	 * Right align labels and float them to the left to make them appear on 
	 * the same line as controls. Requires the most markup changes 
	 * from a default form:
	 */
	const HORIZONTAL = 'form-horizontal';

	/**
	 * @return array
	 */
	public static function choices()
	{
		return [
			\Config::NO => __('No'),
			\Config::YES => __('Yes')
		];
	}
	
	/**
	 * @param string $name
	 * @return string
	 */
	public static function token($name = 'csrf')
	{
		return self::hidden($name, \Security::token());
	}
}