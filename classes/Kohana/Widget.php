<?php defined('SYSPATH') OR die('No direct script access.');

class Kohana_Widget {

	protected static $_widgets = array();
	protected static $_widgets_static = array();
	protected static $_widgets_list = array();

	public static function get($widget_name, array $params = NULL)
	{
		return new static($widget_name, $params);
	}

	public static function get_static($widget_name, array $data = NULL)
	{
		return View::factory($widget_name, $data);
	}

	public static function get_list()
	{
		$widgets = Kohana::$config->load('widgets')->as_array();

		foreach ($widgets as $name => $val)
		{
			if ( ! is_array($val) OR ! array_key_exists('widget_title', $val))
			{
				unset($widgets[$name]);
			}
			else
			{
				$widgets[$name] = $val['widget_title'];
			}
		}

		return $widgets;
	}

	protected $_config;
	protected $_widget;
	protected $_widget_name;

	public function __construct($widget_name, array $params = NULL)
	{
		if ($widget_name == 'route_name')
		{
			throw HTTP_Exception::factory(500, __('Widget\'s name should not to be "route_name"'));
		}

		$this->_widget_name = $widget_name;
		$this->_config 		= Kohana::$config->load('widgets')->as_array();

		$route_name = Arr::get($this->_config, 'route_name', 'widgets-default');

		if (Route::get($route_name) AND array_key_exists($widget_name, static::get_list()))
		{
			$params = (is_array($params)) ? $params : array();
			$params = Arr::merge(Arr::get($this->_config, $widget_name, array()), $params);
			$url 	= Route::url($route_name, $params);

			$this->_widget = Request::factory($url);
		}
	}

	public function render()
	{
		if ( ! $this->_widget instanceof Request)
		{
			return __(Kohana::message('widgets', 404), array(':name' => $this->_widget_name));
		}

		$response = $this->_widget->execute();

		if ($response->status() != 200)
		{
			$response = __(Kohana::message('widgets', $response->status()), array(':name' => $this->_widget_name));
		}
		else
		{
			$response = $response->body();
		}

		return $response;
	}

	public function __toString()
	{
		return $this->render();
	}
}
