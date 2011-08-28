<h1>vslideCyclePlugin Wordpress Plugin v.1.0</h1>
<?php
global $wpdb;
if (isset($_REQUEST["modo"])) {
    $modo = addslashes($_REQUEST["modo"]);
}
switch ($modo) {
    case "register_mode":
        $imagem = $_POST["upload_image"];
        if (!empty($imagem))
            $wpdb->query("insert into {$wpdb->prefix}vslideCyclePlugin(id_slide,url_image)values(null,'{$imagem}')");
        ?>
        <script>
            window.location = "<?php plugins_url('manage.php', __FILE__); ?>";
        </script>
        <?
        break;
    default:
        ?>
        <div class="thisSlide">
            <form action="" method="post">Insert the url of image or click 'Upload Image'<br />
                <input type="hidden" name="modo" value="register_mode" />
                <input id="upload_image" type="text" size="36" name="upload_image" value="" />
                <input id="upload_image_button" type="button" value="Upload Image" />
                <input type="submit" value="Configure" />
            </form>
        </div><br /><br />
    <?
}
?>
<style>
    .thisSlide{padding:10px;}
    .thumbSlide,.imag{height:100px;}
    .tongBg,.postar{float:left;}
    .layer_black{
        display: none;
        position: absolute;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: #000000;
        z-index:1111;
        -moz-opacity: 0.8;
        opacity:.80;
        filter: alpha(opacity=80);
    }
    .white_content {
        display: none;
        position: absolute;
        top: 25%;
        left: 25%;
        width:50%;
        height: auto;
        padding: 5px;
        border: 5px solid #C0C0C0;
        background-color: #FFFFFF;
        z-index:1112;
        overflow: auto;
    }
    .content_prev{
        width:100%;
        height: auto;
        text-align:center;
        padding: 0px;
        background-color: #FFFFFF;
        overflow: auto;
        margin:0px auto;
    }
    .layer_popup{
        width:auto;
        text-align:right;
        height:20px;
    }

</style>
<script>
    jQuery.noConflict();
    jQuery(document).ready(function() {
        jQuery(".thumbSlide .imag").MyFadeOverImage({
            normalAlpha:1,
            hoverAlpha: 0.5,
            normalToneColor:"#fff" 
        });
    });
</script>
<script src=<?php echo plugins_url('js/jquery.MyFadeOverImage.js', __FILE__); ?>></script>
<script type='text/javascript'>
    function submitDel(id){
        document.getElementById(id).submit();
    }
</script>
<div id="slideBox">
    <div id="layerBlack" class="layer_black"></div>

    <ul>
        <?php
        $res = $wpdb->get_results("SELECT id_slide,url_image from {$wpdb->prefix}vslideCyclePlugin order by id_slide desc");
        foreach ($res as $r) {
            echo "<li class=\"thumbSlide\"><form method='post' id=\"" . $r->id_slide . "\" action=''><input type='hidden' name='del' value='" . $r->id_slide . "' /><a class='postar' href='javascript:void(0);' onclick=\"if(confirm('delete this slide?'))submitDel('" . $r->id_slide . "');\" title='Remove This Slide' ><img src='" . WP_PLUGIN_URL . '/' . str_replace(basename(__FILE__), "", plugin_basename(__FILE__)) . "img/Delete.png' style='padding:10px;'></a><a class=\"imgth\"  onclick = \"document.getElementById('layer-" . $r->id_slide . "').style.display='block';document.getElementById('layerBlack').style.display='block'\" href=\"javascript:void(0)\"><img class=\"imag\"  src='" . $r->url_image . "'></a></form>
<div id=\"layer-" . $r->id_slide . "\" class=\"white_content\"><div class=\"layer_popup\"><a href =\"javascript:void(0)\" onclick = \"document.getElementById('layer-" . $r->id_slide . "').style.display='none';document.getElementById('layerBlack').style.display='none'\"><img title=\"Close Window\" src=" . plugins_url('img/close.png', __FILE__) . "></a></div><div class=\"content_prev\"><img src=\"" . $r->url_image . "\" ></div></div>

</li><br />";
        }
        ?>
    </ul>
</div>
<?php
global $wpdb;
if (!empty($_POST['del'])) {
    $wpdb->query("DELETE FROM " . $wpdb->prefix . "vslideCyclePlugin WHERE id_slide = '{$_POST['del']}';");
    ?>
    <script>
        window.location = "<?php plugins_url('manage.php', __FILE__); ?>";
    </script>
    <?php
}
?>
