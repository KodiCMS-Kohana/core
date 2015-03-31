<?php namespace KodiCMS\Core;

use Kohana\Core\Arr;

/**
 * @package		KodiCMS
 * @category	Helper
 * @author		butschster <butschster@gmail.com>
 * @link		http://kodicms.ru
 * @copyright	(c) 2012-2014 butschster
 * @license		http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class Validation extends \Kohana\Core\Validation {
	
	public function offsetExists($offset)
	{
		$offset = str_replace('.*', '', $offset);
		return Arr::path($this->_data, $offset, '!isset') != '!isset';
	}

	public function offsetGet($offset)
	{
		return Arr::path($this->_data, $offset);
	}

}