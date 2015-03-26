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
		
		$exclude = ['auth', 'behaviors', 'breadcrumbs', 'cache', 'database', 'icons', 'permissions', 'somilar', 'sitemap'];
		
		$exclude = array_map(function($elm) {
			return $elm . EXT;			
		}, $exclude);
		
		if (!is_dir($dest))
		{
			mkdir($dest, 0755);
		}

		$iterator = new \DirectoryIterator($source);
		foreach ($iterator as $item)
		{
			if ($item->isDir() OR $item->isDot() OR in_array($item->getBasename(), $exclude))
			{
				continue;
			}

			$file = $dest . DIRECTORY_SEPARATOR . $item->getBasename();
			if (file_exists($file))
			{
				continue;
			}

			copy($source . DIRECTORY_SEPARATOR . $item->getBasename(), $file);
			Minion_CLI::write(__('Config files :name published', [':name' => $item->getBasename()]));
		}
	}
}