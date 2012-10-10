<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 *  get_locale()
 */

/**
 * Description of class
 *
 * @author vinicius
 */
Class vslideCycle {

    public $arr_effect = array("blindX", "blindY", "blindZ", "cover", "curtainX", "curtainY", "fade", "fadeZoom", "growX", "growY", "scrollUp", "scrollDown", "scrollLeft", "scrollRight", "scrollHorz", "scrollVert", "shuffle", "slideX", "slideY", "toss", "turnUp", "turnDown", "turnLeft", "turnRight", "uncover", "wipe", "zoom",);
    public $arr_arrow = array("", "black", "blue", "bothgreen", "forblue", "forward", "graydark", "greenarrow", "greenforward", "green", "grey", "lightgreen", "media", "orange", "play");
    public $conf;
    public $lang_data = array();

    function __construct() {
        $this->conf = $this->getConfiguration();
        $this->lang_data['manage_slides_lang'] = "Manage Slides";
        $this->lang_data['configuration_lang'] = "Configuration";
        $this->lang_data['current_configuration_lang'] = "Current configuration";
        $this->lang_data['configure_lang'] = "Configure";
        $this->lang_data['width_lang'] = "Width";
        $this->lang_data['height_lang'] = "Height";
        $this->lang_data['effect_lang'] = "Effect";
        $this->lang_data['enable_next_prev_lang'] = "Enable Next/Prev";
        $this->lang_data['force_image_size_lang'] = "Force Image Size?";
        $this->lang_data['arrows_lang'] = "Arrows";
        $this->lang_data['close_window'] = "Close Window";
        $this->lang_data['remove_this_slide_lang'] = "Remove This Slide";
        $this->lang_data['upload_image_lang'] = "Upload image";
        $this->lang_data['add_lang'] = "Insert into the slide list";
        
    }

    function getConfiguration() {
        global $wpdb;
        $conf = $wpdb->get_row("SELECT * from {$wpdb->prefix}vslideCyclePluginconf");
        return $conf;
    }

    static function vslideCyclePlugin_activate() {
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

     function DeleteImage($del) {
      global $wpdb;
      $result = $wpdb->query($wpdb->prepare("DELETE FROM " . $wpdb->prefix . "vslideCyclePlugin WHERE id_slide= '{$del}'"));
      return $result;
      } 

    function RegisterMode($vheight, $vwidth, $effect, $button, $force, $arrows) {
        global $wpdb;
        $wpdb->query("truncate table {$wpdb->prefix}vslideCyclePluginconf");
        $wpdb->query("insert into {$wpdb->prefix}vslideCyclePluginconf(id,vheight,vwidth,effect,button,force_size,arrow_style)values(null,'{$vheight}','{$vwidth}','{$effect}','{$button}','{$force}','{$arrows}')");
    }

    
    function vslideCyclePlugin_desactivate() {
        global $wpdb;
        $wpdb->query("DROP database {$wpdb->prefix}vslideCyclePlugin");
        $wpdb->query("DROP database {$wpdb->prefix}vslideCyclePluginconf");
    }

    function vslideCyclePlugin_menu() {
        global $wpdb;
        if (function_exists("add_menu_page")) {
            add_menu_page($this->lang_data['manage_slides_lang'], " vslideCycle", 10, basename(dirname(__FILE__)) . "/manage.php");
        }
        if (function_exists("add_submenu_page")) {
            add_submenu_page(basename(dirname(__FILE__)) . "/manage.php", $this->lang_data['manage_slides_lang'], $this->lang_data['manage_slides_lang'], 7, basename(dirname(__FILE__)) . "/manage.php");
        }
        if (function_exists("add_submenu_page")) {
            add_submenu_page(basename(dirname(__FILE__)) . "/manage.php", $this->lang_data['configuration_lang'], $this->lang_data['configure_lang'], 7, basename(dirname(__FILE__)) . "/configuration.php");
        }
    }

    function vslideCyclePlugin() {
        global $wpdb;
        if (isset($this) && is_object($this) && is_a($this, __CLASS__)) {
            $conf = $this->getConfiguration();
        }
        $res = $wpdb->get_results("SELECT * from {$wpdb->prefix}vslideCyclePlugin order by id_slide ASC");
        wp_enqueue_style("cycle_css", plugins_url('css/cycle.css.php', __FILE__), false, "1.01");

        if ($conf->button)
            print "<div id=\"vslidecyclebar\" style=\"width:" . ($conf->vwidth ? ($conf->vwidth) . "px" : "100%") . ";\">
            <div style=\"width:" . ($conf->vwidth ? ($conf->vwidth / 2) . "px" : "50%") . ";text-align:left;float:left;\">
                <a href=\"#\">
                   <span class=\"vslidecyclenav\" id=\"prev\">
                       <img src='" . plugins_url('/img/arrow/prev_' . $conf->arrow_style . '.png', __FILE__) . "'>
                   </span>
                </a>
            </div>
            <div  style=\"width:" . ($conf->vwidth ? ($conf->vwidth / 2) . "px" : "50%") . ";text-align:right;float:left;\" >
                <a href=\"#\">
                   <span class=\"vslidecyclenav\" id=\"next\">
                         <img src='" . plugins_url('/img/arrow/next_' . $conf->arrow_style . '.png', __FILE__) . "'>
                   </span>
                </a>
            </div>
          </div>";
        print "<div id=\"vslidecyclecontainer\" class=\"vslideCyclePlugin\">";
        foreach ($res as $r) {
            print "<img src=" . $r->url_image . ">";
        }
        print "</div>";
        print "<script type=\"text/javascript\">
              jQuery('.vslideCyclePlugin').cycle({
                  fx: '" . ($conf->effect != null ? $conf->effect : 'blindX') . "',
                  timeout:3000,
                  pager:'#vslidecyclenav',
                  prev: '#prev',
                  next: '#next',
                  pagerEvent: 'click',
                  //fastOnEvent: true
                  }); " .
        ($conf->button ? ' jQuery(\'#vslidecyclebar\').width( jQuery(\'#vslidecyclecontainer\').width()+1);' : '') .
        "</script>";
    }

    function run() {
        add_shortcode("vslidecycleplugin", array($this, 'vslideCyclePlugin'));
        register_activation_hook(__FILE__, array($this, 'vslideCyclePlugin_activate'));
        register_deactivation_hook(__FILE__, array($this, 'vslideCyclePlugin_desactivate'));
        add_action("admin_menu", array($this, 'vslideCyclePlugin_menu'));
        add_action('admin_print_scripts', array($this, 'adminScripts'));
        add_action('admin_print_styles', array($this, 'adminStyles'));
        add_action('wp_head', array($this, 'frontScripts'));
    }
static function adminScripts() {
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_register_script('my-upload', WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__)) . 'js/slide.adm.js', array('jquery', 'media-upload', 'thickbox'));
        wp_enqueue_script('my-upload');
    }

    public function adminStyles() {
        wp_enqueue_style('thickbox');
        wp_register_style('custom_wp_admin_css', plugins_url('css/manage.css', __FILE__), false, '1.0.0');
        wp_enqueue_style('custom_wp_admin_css');
    }

    function frontScripts() {
        wp_register_script("jquery.chili-1.7", plugins_url('js/chili-1.7.pack.js', __FILE__), null, null);
        wp_enqueue_script('jquery.chili-1.7');
        wp_register_script("jquery.cycle.all", plugins_url('js/jquery.cycle.all.js', __FILE__), null, null);
        print '<script src=' . plugins_url('js/jquery.cycle.all.js', __FILE__) . '></script>';
    }

    function loadcss() {
        add_action('admin_enqueue_scripts', array($this->adminStyles()));
        // add_action('admin_print_styles', array($this->admin_styles()));
    }

    function form($conf) {
        print '<form action="" method="post"><br /><hr />
            <input type="hidden" name="modo" value="register_mode" />
            <h2>' . $this->lang_data['configuration_lang'] .': </h2>
            <b>' . $this->lang_data['width_lang'] . ': </b><input id="vwidth" type="text" size="10" name="vwidth" value="" />px<br />
            <b>' . $this->lang_data['height_lang'] . ': </b><input id="vheight" type="text" size="10" name="vheight" value="" />px<br />
            <b>' . $this->lang_data['effect_lang'] . ': </b><select name="effect" id="effect">';

        foreach ($this->arr_effect as $efeito) {
            print "<option>" . $efeito . "</option>";
        }
        ?>
        </select><br />
        <input id="vbutton" type="checkbox" size="10" name="vbutton" value="1" onclick="(this.checked == true?document.getElementById('arrow_style').style.display='block':document.getElementById('arrow_style').style.display='none');" /><b>Activate Arrows(Next/Prev)</b><br />
        <div id="arrow_style" style="display:none;">
            <?php
            $loopvar = 0;
            foreach ($this->arr_arrow as $arrow) {
                $arrow_path = 'img/arrow/next_' . $arrow . '.png';
                ?>
                <input type="radio" name="arrow_style" value="<?php print $arrow; ?>"><img style="margin-right:10px" src="<?php print plugins_url($arrow_path, __FILE__); ?>">
            <?php
            $loopvar++;
            if($loopvar==5){
                print "<br />";
                $loopvar =0;
            }
                
            
            } ?> 
        </div>
        <input id="vforce" type="checkbox" size="10" name="vforce" value="1" /><b><?php print $this->lang_data['force_image_size_lang']; ?></b><br />
        <input type="submit" value=<?php print $this->lang_data['configure_lang']; ?> />
        </form>
        <hr />
        <?php
        print "<div class=current>";
        print "<h2>" . $this->lang_data['current_configuration_lang'] . ": </h2> <br />";
        print "<b>" . $this->lang_data['width_lang'] . " </b>: " . ($conf->vwidth != null ? $conf->vwidth . "px" : "auto") . "<br />";
        print "<b>" . $this->lang_data['height_lang'] . " </b>: " . ($conf->vheight != null ? $conf->vheight . "px" : "auto") . "<br />";
        print "<b>" . $this->lang_data['effect_lang'] . " </b>: " . $conf->effect . "<br />";
        print "<b>" . $this->lang_data['enable_next_prev_lang'] . " </b>: " . ($conf->button ? "Yes" : "No") . "<br />";
        print "<b>" . $this->lang_data['force_image_size_lang'] . " </b>: " . ($conf->force_size ? "Yes" : "No") . "<br />";
        if ($conf->button)
            print "<b>" . $this->lang_data['arrows_lang'] . " </b>: <br /><img src='" . plugins_url('img/arrow/prev_' . $conf->arrow_style . '.png', __FILE__) . "'>&nbsp;&nbsp;<img src='" . plugins_url('img/arrow/next_' . $conf->arrow_style . '.png', __FILE__) . "'>";
        print "</div>";
        ?>

        <?php
    }

    function getForm() {
        return $this->form($this->conf);
    }

    function getRowsSlideManaged() {
        global $wpdb;
        $res = $wpdb->get_results("SELECT id_slide,url_image from {$wpdb->prefix}vslideCyclePlugin order by id_slide desc");
        $i = 0;
        foreach ($res as $r) {
            if ($i == 5) {
                $class = " over";
            }else{
                $class = "";
            }
            $i++;
            print "
<div class=\"thumbSlide" . $class . "\">
        <form method='post' id=\"" . $r->id_slide . "\" action=''>
              <input type='hidden' name='del' value='" . $r->id_slide . "' />

              <a class=\"imgth\"  onclick = \"document.getElementById('layer-" . $r->id_slide . "').style.display='block';document.getElementById('layerBlack').style.display='block'\" href=\"javascript:void(0)\">
                    <img class=\"imag\"  src='" . $r->url_image . "'>
              </a>
             <a class='postar' href='javascript:void(0);' onclick=\"if(confirm('delete this slide?'))submitDel('" . $r->id_slide . "');\" title= '" . $this->lang_data['remove_this_slide_lang'] . "' >
                 <img src='" . WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__)) . "img/Delete.png'>
             </a>
        </form>
        <div id=\"layer-" . $r->id_slide . "\" class=\"white_content\">
              <div class=\"layer_popup\">
                   <a href =\"javascript:void(0)\" onclick = \"document.getElementById('layer-" . $r->id_slide . "').style.display='none';document.getElementById('layerBlack').style.display='none'\">
                          <img title=\"" . $this->lang_data['close_window'] . "\" src=" . plugins_url('img/close.png', __FILE__) . ">
                   </a>
              </div>
              <div class=\"content_prev\">
                   <img src=\"" . $r->url_image . "\" >
              </div>
               <div class=\"layer_popup-down\">
                   <a href =\"javascript:void(0)\" onclick = \"document.getElementById('layer-" . $r->id_slide . "').style.display='none';document.getElementById('layerBlack').style.display='none'\">
                         " . $this->lang_data['close_window'] . "
                   </a>
              </div>
        </div>
 </div>";
            
        }
       
        
    }

}
?>
