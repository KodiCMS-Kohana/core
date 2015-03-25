<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Задача создания файлов субмодулей
 * @package		KodiCMS/Core
 * @category	Task
 * @author		butschster <butschster@gmail.com>
 */

/**
 * It can accept the following options:
 *  - type: Cache type for clear (default - all) (types - file, routes, profiler)
 */
class Task_Git_Submodules extends Minion_Task
{
	protected function _execute(array $params)
	{
		$source = CMS_MODPATH;

		if (!is_dir($source))
		{
			Minion_CLI::write('============ No Submodules ==========');
			return;
		}

		$iterator = new \DirectoryIterator($source);
		foreach ($iterator as $item)
		{
			if (!$item->isDir() OR $item->isDot())
			{
				continue;
			}
			
			$file = CMS_MODPATH . $item->getBasename() . DIRECTORY_SEPARATOR . '.git';
			if (file_exists($file))
			{
				continue;
			}

			$content = "gitdir: ../../../.git/modules/vendor/kodicms/{$item->getBasename()}";
			$fp = fopen($file, "wb");
			fwrite($fp, $content);
			fclose($fp);

			Minion_CLI::write('Create .git file for submodule ' . $item->getBasename());
		}
	}
}