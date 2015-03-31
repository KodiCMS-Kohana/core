<?php namespace KodiCMS\Core\HTTP;

use KodiCMS\Core\Config;
use KodiCMS\Core\Request;
use Kohana\Core\Response;

/**
 * @package		KodiCMS
 * @category	Exception
 * @author		butschster <butschster@gmail.com>
 * @link		http://kodicms.ru
 * @copyright	(c) 2012-2014 butschster
 * @license		http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt
 */
class Exception extends \Kohana\Core\HTTP\Exception {
	
	/**
     * Generate a Response for all Exceptions without a more specific override
     * 
     * The user should see a nice error page, however, if we are in development
     * mode we should show the normal Kohana error page.
     * 
     * @return Response
     */
    public function get_response()
    {
		// Lets log the Exception, Just in case it's important!
		\KodiCMS\Core\Exception::log($this);

		if (Config::get('site', 'debug') == Config::YES)
		{
			// Show the normal Kohana error page.
			return parent::get_response();
		}
		else
		{
			$params = [
				'code' => 500,
				'message' => rawurlencode($this->getMessage())
			];

			if ($this instanceof Exception)
			{
				$params['code'] = $this->getCode();
			}

			try
			{
				$request = Request::factory(Route::get('error')->uri($params), [], FALSE)
					->execute()
					->send_headers(TRUE)
					->body();

				return Response::factory()
					->status($this->getCode())
					->body($request);
			}
			catch (\Exception $e)
			{
				return parent::get_response();
			}
		}
	}
}