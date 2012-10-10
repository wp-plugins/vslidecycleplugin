<?php

/*
  Plugin Name: vslideCyclePlugin
  Plugin URI: http://viniwp.wordpress.com
  Description: Simple Plugin With Jquery Cycle To Insert a SlideShow in Your Blog Wordpress
  Version: 1
  Author: Vinícius Gomes
  Author URI: http://viniwp.wordpress.com
 */
require_once('class.vslidecycle.php');
ini_set('display_errors', '0');
ini_set('error_reporting', ~E_ALL);
$vslidecycle = new vslideCycle;
$vslidecycle->run();
?>
