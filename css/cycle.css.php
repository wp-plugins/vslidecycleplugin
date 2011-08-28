<?php header("Content-Type: text/css"); 
$h = $_GET['h'];
$w = $_GET['w'];
$f = $_GET['f'];
?>
.vslideCyclePlugin { <?php echo ($h!=null?"height: ".$h."px !important;":""); ?><?php echo ($w!=null?"width: ".$w."px !important;":""); ?>padding:0; margin:0; overflow: hidden }
<?php 
if($f){
echo ".vslideCyclePlugin img { height:".($h!=null?($h)."px":"auto")." !important;width:".($w!=null?($w).'px':'auto')." !important; border: 1px solid #ccc; background-color: #eee; top:0; left:0 }";
} ?>
#vslidecyclebar{height:20px;position:absolute;z-index:9999;margin-top:15px;}
.vslidecyclenav{padding:0px 20px;}
