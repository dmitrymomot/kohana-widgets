<?php defined('SYSPATH') OR die('No direct script access.');


Route::set('widgets-default', 'widget/<directory>/<controller>(/<action>(/<id>))')
	->filter(function($route, $params, $request)
	{
		if ($request->is_external() AND ! $request->is_ajax())
		{
			return FALSE;
		}
	})
	->defaults(array(
		'directory'	=> 'widget',
		'action'	=> 'index',
	));
