<?php
require_once('class.vslidecycle.php');
$vslidecycle = new vslideCycle;
$modo = addslashes($_REQUEST["modo"]);
switch ($modo) {
    case "register_mode":
        $vheight = $_POST["vheight"];
        $vwidth = $_POST["vwidth"];
        $effect = $_POST["effect"];
        $button = $_POST["vbutton"];
        $force = $_POST["vforce"];
        $arrows = $_POST['arrow_style'];
        $vslidecycle->RegisterMode($vheight, $vwidth, $effect, $button, $force, $arrows);
        ?>
        <script>
            window.location = "<?php plugins_url('configuration.php', __FILE__); ?>";
        </script>
        <?php
        break;
    default:
        print $vslidecycle->getForm();
}
?>
<hr />
<div id="icon-edit-comments" class="icon32"><br /></div><h1>Help</h1><br />
<b>ShortTag Posts: </b>[vslidecycleplugin]<br />
<b>Insert into Theme: </b>&lt;?php if(method_exists(vslideCycle,vslideCyclePlugin)){ vslideCycle::vslideCyclePlugin(); } ?&gt;
