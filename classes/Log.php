<?php namespace KodiCMS\Core;

use Kohana\Core\Arr;

class Log extends \Kohana\Core\Log {

	/**
	 *
	 * @var array 
	 */
	protected static $_log_levels = [
		LOG_EMERG		=> 'EMERGENCY',
		LOG_ALERT		=> 'ALERT',
		LOG_CRIT		=> 'CRITICAL',
		LOG_ERR			=> 'ERROR',
		LOG_WARNING		=> 'WARNING',
		LOG_NOTICE		=> 'NOTICE',
		LOG_INFO		=> 'INFO',
		LOG_DEBUG		=> 'DEBUG',
	];
	
	/**
	 * 
	 * @return array
	 */
	public static function levels()
	{
		return static::$_log_levels;
	}

	/**
	 * 
	 * @param integer $level
	 * @return string
	 */
	public static function level($level)
	{		
		return Arr::get(static::levels(), $level, 'INFO');
	}
}