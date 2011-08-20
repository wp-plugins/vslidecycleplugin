<?php
$modo = addslashes($_REQUEST["modo"]);
switch ($modo) {
    case "register_mode":
        $vheight = $_POST["vheight"];
        $vwidth = $_POST["vwidth"];
        $effect = $_POST["effect"];
        $button = $_POST["vbutton"];
        $force = $_POST["vforce"];
        $arrows = $_POST['arrow_style'];
        $wpdb->query("truncate table {$wpdb->prefix}vslideCyclePluginconf");
        $wpdb->query("insert into {$wpdb->prefix}vslideCyclePluginconf(id,vheight,vwidth,effect,button,force_size,arrow_style)values(null,'{$vheight}','{$vwidth}','{$effect}','{$button}','{$force}','{$arrows}')");
        ?>
        <script>
            window.location = "<?php plugins_url('config.php', __FILE__); ?>";
        </script>
        <?
        break;
    default:
        ?>
        <form action="" method="post"><br /><hr />
            <input type="hidden" name="modo" value="register_mode" />
            <h2>Configure vslideCyclePlugin: </h2>
            <b>Width: </b><input id="vwidth" type="text" size="10" name="vwidth" value="" />px<br />
            <b>Height: </b><input id="vheight" type="text" size="10" name="vheight" value="" />px<br />
            <b>Effect: </b><select name="effect" id="effect">
                <option >blindX</option>
                <option >blindY</option>
                <option >blindZ</option>
                <option >cover</option>
                <option >curtainX</option>
                <option >curtainY</option>
                <option >fade</option>
                <option >fadeZoom</option>
                <option >growX</option>
                <option >growY</option>
                <option >scrollUp</option>
                <option >scrollDown</option>
                <option >scrollLeft</option>
                <option >scrollRight</option>
                <option >scrollHorz</option>
                <option >scrollVert</option>
                <option >shuffle</option>
                <option >slideX</option>
                <option >slideY</option>
                <option >toss</option>
                <option >turnUp</option>
                <option >turnDown</option>
                <option >turnLeft</option>
                <option >turnRight</option>
                <option >uncover</option>
                <option >wipe</option>
                <option >zoom</option>
            </select><br />
            <input id="vbutton" type="checkbox" size="10" name="vbutton" value="1" onclick="(this.checked == true?document.getElementById('arrow_style').style.display='block':document.getElementById('arrow_style').style.display='none');" /><b>Activate Arrows(Next/Prev)</b><br />
            <select name="arrow_style" id="arrow_style" style="display:none;">
                <option value="">default
                <option value="black">Number 1
                <option value="blue">Number 2
                <option value="bothgreen">Number 3
                <option value="forblue">Number 4
                <option value="forward">Number 5
                <option value="graydark">Number 6
                <option value="greenarrow">Number 7
                <option value="greenforward">Number 8
                <option value="green">Number 9
                <option value="grey">Number 10
                <option value="lightgreen">Number 11
                <option value="media">Number 12
                <option value="orange">Number 13
                <option value="play">Number 14
            </select>
            <input id="vforce" type="checkbox" size="10" name="vforce" value="1" /><b>Force the image size</b><br />
            <input type="submit" value="Configure" />
        </form>
        <hr />
        <?php
        echo "<h2>Configuration of slide: </h2> <br />";
        $conf = $wpdb->get_row("SELECT * from {$wpdb->prefix}vslideCyclePluginconf");
        echo "<b>Width </b>: " . ($conf->vwidth != null ? $conf->vwidth . "px" : "auto") . "<br />";
        echo "<b>Height </b>: " . ($conf->vheight != null ? $conf->vheight . "px" : "auto") . "<br />";
        echo "<b>Effect: </b>" . $conf->effect . "<br />";
        echo "<b>Enable Next/Prev: </b>" . ($conf->button ? "Yes" : "No") . "<br />";
        echo "<b>Force Image Size? </b>" . ($conf->force_size ? "Yes" : "No") . "<br />";
        if ($conf->button)
            echo "<b>Arrows: </b><img src='" . plugins_url('img/arrow/prev_' . $conf->arrow_style . '.png', __FILE__) . "'>&nbsp;&nbsp;<img src='" . plugins_url('img/arrow/next_' . $conf->arrow_style . '.png', __FILE__) . "'>";
        ?>
        <hr />
        <h2>Arrows</h2>
        <img src="<?php echo plugins_url('img/arrow/next_.png', __FILE__); ?>"> - Default<br />
        <img src="<?php echo plugins_url('img/arrow/next_black.png', __FILE__); ?>"> - Number 1<br />
        <img src="<?php echo plugins_url('img/arrow/next_blue.png', __FILE__); ?>"> - Number 2<br />
        <img src="<?php echo plugins_url('img/arrow/next_bothgreen.png', __FILE__); ?>"> - Number 3<br />
        <img src="<?php echo plugins_url('img/arrow/next_forblue.png', __FILE__); ?>"> - Number 4<br />
        <img src="<?php echo plugins_url('img/arrow/next_forward.png', __FILE__); ?>"> - Number 5<br />
        <img src="<?php echo plugins_url('img/arrow/next_graydark.png', __FILE__); ?>"> - Number 6<br />
        <img src="<?php echo plugins_url('img/arrow/next_greenarrow.png', __FILE__); ?>"> - Number 7<br />
        <img src="<?php echo plugins_url('img/arrow/next_greenforward.png', __FILE__); ?>"> - Number 8<br />
        <img src="<?php echo plugins_url('img/arrow/next_green.png', __FILE__); ?>"> - Number 9<br />
        <img src="<?php echo plugins_url('img/arrow/next_grey.png', __FILE__); ?>"> - Number 10<br />
        <img src="<?php echo plugins_url('img/arrow/next_lightgreen.png', __FILE__); ?>"> - Number 11<br />
        <img src="<?php echo plugins_url('img/arrow/next_media.png', __FILE__); ?>"> - Number 12<br />
        <img src="<?php echo plugins_url('img/arrow/next_orange.png', __FILE__); ?>"> - Number 13<br />
        <img src="<?php echo plugins_url('img/arrow/next_play.png', __FILE__); ?>"> - Number 14<br />
    <?
}
?>
