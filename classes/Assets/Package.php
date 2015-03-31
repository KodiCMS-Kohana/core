<?php namespace KodiCMS\Core\Assets;

use Kohana\Core\Arr;
use Kohana\Core\HTML;

/**
 * @package		KodiCMS/Assets
 * @author		butschster <butschster@gmail.com>
 * @link		http://kodicms.ru
 * @copyright  (c) 2012-2014 butschster
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class Package implements \Iterator {
	
	protected static $_list = [];

	/**
	 * Добавление пакета
	 *
	 * @param $name
	 * @return static
	 */
	public static function add($name)
	{
		return new static($name);
	}
	
	/**
	 * Загрузка пакета
	 * 
	 * @param string $name
	 * @return \Assets_Package|NULL
	 */
	public static function load($name)
	{
		return Arr::get(static::$_list, $name);
	}
	
	/**
	 * Получение списка всех пакетов
	 * 
	 * @return array
	 */
	public static function get_all()
	{
		return static::$_list;
	}
	
	/**
	 * 
	 * @param string,array $name
	 * @return array
	 */
	public static function get_scripts($names)
	{
		if (!is_array($names))
		{
			$names = [$names];
		}
		
		$scripts = [];
		
		foreach ($names as $name)
		{
			$package = static::load($name);

			if ($package === NULL)
			{
				continue;
			}

			foreach ($package as $item)
			{
				switch ($item['type'])
				{
					case 'js':
						$scripts[] = $item['src'];
						break;
				}
			}
		}
		
		return $scripts;
	}

	/**
	 * 
	 * @return array
	 */
	public static function select_choises()
	{
		$options = array_keys(static::$_list);
		return array_combine($options, $options);
	}

	/**
	 * 
	 * @var string 
	 */
	protected $_handle = NULL;


	/**
	 *
	 * @var array 
	 */
	protected $_data = [];
	
	/**
	 *
	 * @var integer 
	 */
	private $position = 0;

	/**
	 * @param $handle
	 */
	public function __construct($handle)
	{
		$this->_handle = $handle;
		static::$_list[$handle] = $this;
	}

	/**
	 * @param null $handle
	 * @param null $src
	 * @param null $deps
	 * @param null $attrs
	 * @return $this
	 */
	public function css($handle = NULL, $src = NULL, $deps = NULL, $attrs = NULL)
	{
		if ($handle === NULL)
		{	
			$handle = $this->_handle;
		}
		
		// Set default media attribute
		if ( ! isset($attrs['media']))
		{
			$attrs['media'] = 'all';
		}
		
		$this->_data[] = [
			'type'	=> 'css',
			'src'   => $src,
			'deps'  => (array) $deps,
			'attrs' => $attrs,
			'handle' => $handle,
			'type' => 'css'
		];
		
		return $this;
	}

	/**
	 * @param bool $handle
	 * @param null $src
	 * @param null $deps
	 * @param bool $footer
	 * @return $this
	 */
	public function js($handle = FALSE, $src = NULL, $deps = NULL, $footer = FALSE)
	{
		if ($handle === NULL)
		{
			$handle = $this->_handle;
		}
		
		$this->_data[] = [
			'type'	=> 'js',
			'src'    => $src,
			'deps'   => (array) $deps,
			'footer' => $footer,
			'handle' => $handle,
			'type' => 'js'
		];
		
		return $this;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		$string = '';

		foreach ($this->_data as $item)
		{
			switch($item['type'])
			{
				case 'css':
					$string .= HTML::style($item['src'], $item['attrs']);
					break;
				case 'js':
					$string .= HTML::script($item['src']);
					break;
			}
		}
		
		return $string;
	}
	
	function rewind()
	{
		$this->position = 0;
	}
	
	function current() 
	{
		return $this->_data[$this->position];
	}
	
	function key()
	{
		return $this->position;
	}
	
	function next() 
	{
		++$this->position;
	}
	
	function valid() 
	{
		return isset($this->_data[$this->position]);
	}
}