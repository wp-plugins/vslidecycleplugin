<?php
ini_set('display_errors', '0');
ini_set('error_reporting', ~E_ALL);
require_once('class.vslidecycle.php');
$vslidecycle = new vslideCycle;
$vslidecycle->loadcss();
?>
<div id="icon-tools" class="icon32"><br /></div><h1><?php print $vslidecycle->lang_data['title_manage_slides']; ?></h1>
<div class="thisSlide">
    <form action="" method="post">Insert the url of image or click 'Upload Image'<br />
        <input type="hidden" name="modo" value="register_mode" />
        <b>Image: </b><input id="upload_image" type="text" size="36" name="upload_image" value="" />
        <input id="upload_image_button" type="button" value="<?php print $vslidecycle->lang_data['upload_image_lang']; ?>" /><br />
        <b>URL: </b><input id="url_link" type="text" size="36" name="url_link" value="" /><br />
        <input type="submit" class="button-primary" value="<?php print $vslidecycle->lang_data['save_data']; ?>" />
    </form>
</div>
<script src=<?php print plugins_url('js/jquery.MyFadeOverImage.js', __FILE__); ?>></script>
<script type='text/javascript'>
    function submitDel(id){
        document.getElementById(id).submit();
    }
    jQuery.noConflict();
    jQuery(document).ready(function() {
        jQuery(".thumbSlide .imag").MyFadeOverImage({
            normalAlpha:1,
            hoverAlpha: 0.5,
            normalToneColor:"#fff" 
        });
    });
    //pagination admin slides
    jQuery(document).ready(function(){ 
        var show_per_page = 5; 
        var number_of_items = jQuery('#slideBox').children().size(); 
        var number_of_pages = Math.ceil(number_of_items/show_per_page); 
        jQuery('#current_page').val(0); 
        jQuery('#show_per_page').val(show_per_page); 
        var navigation_html = ''; 
        var current_link = 0;
        while(number_of_pages > current_link){ 
            navigation_html += '<a class=\"page_link\" href=\"javascript:go_to_page(' + current_link +')\" longdesc=\"' + current_link +'\">'+ (current_link + 1) +'</a>'; 
            current_link++; 
        } 
        jQuery('#page_navigation').html(navigation_html);
        jQuery('#page_navigation_bottom').html(navigation_html);
        jQuery('#data_navigation').html('Total of Images ( ' + number_of_items + ' )<br />');
        jQuery('#data_navigation_top').html('Total of Images ( ' + number_of_items + ' )<br />');
        jQuery('#page_navigation .page_link:first').addClass('active_page'); 
        jQuery('#page_navigation_bottom .page_link:first').addClass('active_page'); 
        jQuery('#slideBox').children().css('display', 'none'); 
        jQuery('#slideBox').children().slice(0, show_per_page).css('display', 'block'); 
        jQuery('.imgth').mouseenter(function(){
            id = jQuery(this).attr('id').split('imgth-');
            id = id[1];
            jQuery('#thumb-' + id).css('display','block');
            jQuery('#thumb-' + id).css('position','absolute');
        });
        jQuery('.imgth').mouseout(function(){
            id = jQuery(this).attr('id').split('imgth-');
            id = id[1];
            jQuery('#thumb-' + id).css('display','none');
            jQuery('#thumb-' + id).css('position','absolute');
        });
        jQuery('.close').click(function(){
            id = jQuery(this).attr('id').split('close-');
            id = id[1];
            if(jQuery('#layer-' + id).css('display')=='none'){
                jQuery('#layer-' + id).css('display','block')
                jQuery('#layerBlack').css('display','block')
            }
            if(jQuery('#layer-' + id).css('display')=='block'){
                jQuery('#layer-' + id).css('display','none');
                jQuery('#layerBlack').css('display','none');
            }
        });
        jQuery('.imgth').click(function(){
            id = jQuery(this).attr('id').split('imgth-');
            id = id[1];
            jQuery('#layer-' + id).css('display','block')
            jQuery('#layerBlack').css('display','block')
        });
    }); 
    function go_to_page(page_num){ 
        var show_per_page = parseInt(jQuery('#show_per_page').val()); 
        start_from = page_num * show_per_page; 
        end_on = start_from + show_per_page; 
        jQuery('#slideBox').children().css('display', 'none').slice(start_from, end_on).css('display', 'block'); 
        jQuery('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page'); 
        jQuery('#current_page').val(page_num); 
    }
<?php
global $wpdb;
if (isset($_REQUEST["modo"])) {
    $modo = addslashes($_REQUEST["modo"]);
}
if ($modo == "register_mode") {
    $imagem = $_POST["upload_image"];
    $link = $_POST["url_link"];
    if (!empty($imagem))
        $wpdb->query("insert into {$wpdb->prefix}vslideCyclePlugin(id_slide,url_image, url_link)values(null,'{$imagem}','{$link}')");
    print "window.location.reload";
}
if (isset($_POST['del']) && is_numeric($_POST['del']) && !empty($_POST['del'])) {
    $vslidecycle->DeleteImage($_POST['del']);
    print "window.location.reload";
}
?>
</script>
<input type='hidden' id='current_page' /> 
<input type='hidden' id='show_per_page' /> 
<div id='data_navigation_top'></div>
<div id='page_navigation' class="wp-list-table widefat fixed tags"></div>
<div id="slideBox">
    <?php
    $vslidecycle->getRowsSlideManaged();
    ?>
</div>
<div id="layerBlack" class="layer_black"></div>
<div id='page_navigation_bottom' class="wp-list-table widefat fixed tags"></div>
<div id='data_navigation'></div>
