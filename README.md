Kohana Widgets
==============

How to use
---

1. Register your widget in ../config/widgets.php
<pre>
	....
	'widget_name' => array(
		'widget_title' 	=> 'Widget Name', // required field
		'directory' 	=> 'widget',
		'controller' 	=> 'test',
		'action' 		=> 'index',
	),
	....
</pre>


2. Getting of widget

Calling Controller/Widget/Test::action_index();
<pre>
Widget::get('test');
</pre>

Calling Controller/Widget/Test::action_test();
<pre>
Widget::get('test', array('action' => 'test'));
</pre>

Receiving multiple widgets
<pre>
Widget::arr(array('test', 'test2',...));
</pre>

------------
P.S. Excuse my english)
