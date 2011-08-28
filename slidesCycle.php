<?php

/*
  Plugin Name: vslideCyclePlugin
  Plugin URI: http://viniwp.wordpress.com
  Description: Simple Plugin With Jquery Cycle To Insert a SlideShow in Your Blog Wordpress
  Version: 1
  Author: Vinícius Gomes
  Author URI: http://viniwp.wordpress.com
 */
ini_set('display_errors', '0');
ini_set('error_reporting', ~E_ALL);

function vslideCyclePlugin_activate() {
    global $wpdb;
    if ($wpdb->get_var("SHOW TABLE LIKE {$wpdb->prefix}vslideCyclePlugin") != "{$wpdb->prefix}vslideCyclePlugin") {
        $wpdb->query("CREATE TABLE {$wpdb->prefix}vslideCyclePlugin(
id_slide int not null primary key auto_increment,
 url_image text)");
        $wpdb->query("CREATE TABLE {$wpdb->prefix}vslideCyclePluginconf(
id int not null primary key auto_increment,
vheight varchar(10),
vwidth varchar(10),
effect varchar(20),
button varchar(2),
force_size varchar(2),
arrow_style varchar(20))");
        ;
    }
}

function delete_image($id) {
    global $wpdb;
    $result = $wpdb->query($wpdb->prepare("DELETE FROM $wpdb->vslideCyclePlugin WHERE id_slide=" . $id));
    return $result;
}

if ($_POST['del']) {
    delete_image($_POST['del']);
}

function my_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('my-upload', WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__)) . 'js/slide.adm.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('my-upload');
}

function my_admin_styles() {
    wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'my_admin_scripts');
add_action('admin_print_styles', 'my_admin_styles');

function vslideCyclePlugin_desactivate() {
    global $wpdb;
    $wpdb->query("DROP database {$wpdb->prefix}vslideCyclePlugin");
    $wpdb->query("DROP database {$wpdb->prefix}vslideCyclePluginconf");
}

function vslideCyclePlugin_menu() {
    global $wpdb;
    if (function_exists("add_menu_page")) {
        add_menu_page("Manage Slides", "vSlideCycle", 10, "vslideCyclePlugin/manage.php");
    }
    if (function_exists("add_submenu_page")) {
        add_submenu_page("vslideCyclePlugin/manage.php", "Configuration", "Configure", 7, "vslideCyclePlugin/config.php");
    }
}

function vslideCyclePlugin() {

    global $wpdb;
    $conf = $wpdb->get_row("SELECT * from {$wpdb->prefix}vslideCyclePluginconf");
    $res = $wpdb->get_results("SELECT * from {$wpdb->prefix}vslideCyclePlugin order by id_slide ASC");
    echo '<link rel="stylesheet" href=' . plugins_url('css/cycle.css.php?h=' . $conf->vheight . '&w=' . $conf->vwidth . '&f=' . $conf->force_size, __FILE__) . ' type="text/css" />';
    echo '<script src=' . plugins_url('js/jquery.min.js', __FILE__) . '></script>';
    echo '<script src=' . plugins_url('js/chili-1.7.pack.js', __FILE__) . '></script>';
    echo '<script src=' . plugins_url('js/jquery.min.js', __FILE__) . '></script>';
    echo '<script src=' . plugins_url('js/jquery.cycle.all.js', __FILE__) . '></script>';
    if ($conf->button)
        echo "<div id=\"vslidecyclebar\" style=\"width:" . ($conf->vwidth ? ($conf->vwidth) . "px" : "100%") . ";\">
            <div style=\"width:" . ($conf->vwidth ? ($conf->vwidth / 2) . "px" : "50%") . ";text-align:left;float:left;\"><a href=\"#\"><span class=\"vslidecyclenav\" id=\"prev\"><img src='" . plugins_url('/img/arrow/prev_' . $conf->arrow_style . '.png', __FILE__) . "'></span></a></div>
            <div  style=\"width:" . ($conf->vwidth ? ($conf->vwidth / 2) . "px" : "50%") . ";text-align:right;float:left;\" ><a href=\"#\"><span class=\"vslidecyclenav\" id=\"next\"><img src='" . plugins_url('/img/arrow/next_' . $conf->arrow_style . '.png', __FILE__) . "'></span></a></div>
          </div>";
    echo "<div id=\"vslidecyclecontainer\" class=\"vslideCyclePlugin\">";
    foreach ($res as $r) {
        echo "<img src=" . $r->url_image . ">";
    }
    echo "</div>";

    echo "<script type=\"text/javascript\">
 jQuery('.vslideCyclePlugin').cycle({
 fx: '" . ($conf->effect != null ? $conf->effect : 'blindX') . "',
 timeout:3000,
 pager:'#vslidecyclenav',
 prev: '#prev',
 next: '#next',
 pagerEvent: 'click',
 fastOnEvent: true
 });
 " . ($conf->button ? ' jQuery(\'#vslidecyclebar\').width( jQuery(\'#vslidecyclecontainer\').width()+1);' : '') . "
</script>";
}

add_shortcode("vslidecycleplugin", "vslideCyclePlugin");
register_activation_hook(__FILE__, "vslideCyclePlugin_activate");
register_deactivation_hook(__FILE__, "vslideCyclePlugin_desactivate");
add_action("admin_menu", "vslideCyclePlugin_menu");
?>
