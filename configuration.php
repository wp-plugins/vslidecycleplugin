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
        <?
        break;
    default:
        print $vslidecycle->getForm();
}
?>
