<?php defined('SYSPATH') OR die('No direct script access.');


Route::set('widgets-default', 'widget/<directory>/<controller>(/<action>(/<id>))')
	->filter(array('Widget', 'filter'))
	->defaults(array(
		'directory'	=> 'widget',
		'action'	=> 'index',
	));
