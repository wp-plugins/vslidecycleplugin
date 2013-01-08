<?php
header("Content-Type: text/css");
require('../../../../wp-load.php');
require_once('../class.vslidecycle.php');
$vslidecycle = new vslideCycle;
$h = $vslidecycle->conf->vheight;
$w = $vslidecycle->conf->vwidth;
$f = $vslidecycle->conf->force_size;
?>
.vslideCyclePlugin { <?php print ($h != null ? "height: " . $h . "px !important;" : ""); ?><?php print ($w != null ? "width: " . $w . "px !important;" : ""); ?>padding:0; margin:0; overflow: hidden; }
<?php
if ($f) {
    print ".vslideCyclePlugin img { height:" . ($h != null ? ($h) . "px" : "auto") . " !important;width:" . ($w != null ? ($w) . 'px' : 'auto') . " !important; border: 1px solid #ccc; background-color: #eee; top:0; left:0 }";
}
?>
#vslidecyclebar{height:20px;position:absolute;z-index:9999;margin-top:15px;}
.vslidecyclenav{padding:0px 20px;}
