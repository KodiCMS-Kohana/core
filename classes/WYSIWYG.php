<?php namespace KodiCMS\Core;
use Kohana\Core\Inflector;

/**
 * @package		KodiCMS
 * @category	Helper
 * @author		butschster <butschster@gmail.com>
 * @link		http://kodicms.ru
 * @copyright	(c) 2012-2014 butschster
 * @license		http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class WYSIWYG {
	
	const TYPE_HTML = 'html';
	const TYPE_CODE = 'code';

	/**
	 *
	 * @var array
	 */
	protected static $_editors = [];
	
	/**
	 *
	 * @var array 
	 */
	protected static $_loaded = [];

	/**
	 * 
	 * @param string $editor_id
	 * @param string $name
	 * @param string $filter
	 * @param string $package
	 * @param string $type
	 */
	public static function add($editor_id, $name = NULL, $filter = NULL, $package = NULL, $type = self::TYPE_HTML)
	{
		self::$_editors[$editor_id] = [
			'name' => $name === NULL ? Inflector::humanize($editor_id) : $name,
			'type' => $type == self::TYPE_HTML ? self::TYPE_HTML : self::TYPE_CODE,
			'filter' => empty($filter) ? $editor_id : $filter,
			'package' => $package === NULL ? $editor_id : $package
		];
	}

	/**
	 * Remove a editor
	 *
	 * @param $editor_id string
	 */
	public static function remove($editor_id)
	{
		if (isset(self::$_editors[$editor_id]))
		{
			unset(self::$_editors[$editor_id]);
		}
	}
	
	/**
	 * 
	 * @param string $type
	 */
	public static function load_all($type = NULL)
	{
		foreach (self::$_editors as $editor_id => $data)
		{
			if ($type !== NULL AND is_string($type))
			{
				if ($type != $data['type'])
				{
					continue;
				}
			}

			self::$_loaded[$editor_id] = $data;
			Assets\Core::package($data['package']);
		}
	}

	/**
	 * Get a instance of a filter
	 *
	 * @param $editor_id
	 *
	 * @return Filter_Decorator
	 */
	public static function get_filter($editor_id)
	{
		if (isset(self::$_editors[$editor_id]))
		{
			$data = self::$_editors[$editor_id];

			if (class_exists($data['filter']))
			{
				return new $data['filter'];
			}
		}

		return new Filter\Dummy();
	}

	/**
	 * 
	 * @param string $type
	 * @return array
	 */
	public static function html_select($type = NULL)
	{
		$editors = ['' => __('none')];

		foreach (self::$_editors as $editor_id => $data)
		{
			if ($type !== NULL AND is_string($type))
			{
				if ($type != $data['type'])
				{
					continue;
				}
			}
			
			$editors[$editor_id] = $data['name'];
		}

		return $editors;
	}
}