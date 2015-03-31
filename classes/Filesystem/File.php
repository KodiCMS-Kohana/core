<?php namespace KodiCMS\Core\FileSystem;

use KodiCMS\Core\FileSystem;
use Kohana\Core\Exception;

/**
 * @package		KodiCMS/FileSystem
 * @author		butschster <butschster@gmail.com>
 * @link		http://kodicms.ru
 * @copyright	(c) 2012-2014 butschster
 * @license		http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class File extends \SplFileInfo {

	/**
	 * 
	 * @param string $content
	 * @return int The function returns the number of bytes that were written to the file, or
	 * <b>FALSE</b> on failure.
	 */
	public function setContent($content)
	{
		return file_put_contents($this->getRealPath(), $content);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getContent()
	{
		return file_get_contents($this->getRealPath());
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getMime()
	{
		return \Kohana\Core\File::mime($this->getRealPath());
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function delete()
	{
		chmod($this->getRealPath(), 0777);
		return unlink($this->getRealPath());
	}
	
	/**
	 * 
	 * @return FileSystem
	 */
	public function getParent()
	{
		return FileSystem::factory($this->getPathInfo());
	}
	
	/**
	 * 
	 * @return boolean
	 */
	public function isImage()
	{
		try
		{
			// Get the image information
			return getimagesize($this->getRealPath());
		}
		catch (Exception $e)
		{
			return FALSE;
		}
	}
}