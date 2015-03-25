<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Задача копирования конфигов в CMS
 * @package		KodiCMS/Core
 * @category	Task
 * @author		butschster <butschster@gmail.com>
 */

/**
 * It can accept the following options:
 *  - type: Cache type for clear (default - all) (types - file, routes, profiler)
 */
class Task_Vendor_Publish extends Minion_Task
{
	protected function _execute(array $params)
	{
		$source = CMS_MODPATH . 'core' . DIRECTORY_SEPARATOR . 'config';
		$dest = CMSPATH . 'application' . DIRECTORY_SEPARATOR . 'config';
		
		if (!is_dir($dest))
		{
			mkdir($dest, 0755);
		}

		$iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST);
		foreach ($iterator as $item)
		{
			$file = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
			if (file_exists($file))
			{
				continue;
			}

			copy($item, $file);
		}
		
		Minion_CLI::write('============ Config files published ==========');
	}
}