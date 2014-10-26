<?php

class Base_Controller extends Controller {

	public function __construct() {
		Asset::add('style', 'css/style.css');
		Asset::add('glyphicons', 'css/glyphicons.css');
		Asset::add('jqueryui', 'css/jquery-ui.min.css');
		Asset::add('jqueryui_structure', 'css/jquery-ui.structure.min.css');
		Asset::add('jqueryui_theme', 'css/jquery-ui.theme.min.css');
		Asset::add('jquery', 'js/jquery.min.js');
		Asset::add('jquery_ui', 'js/jquery-ui.min.js');
		Asset::add('jshelper', 'js/jshelper.js');
		parent::__construct();
	}
	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Response::error('404');
	}

}