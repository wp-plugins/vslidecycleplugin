<?php

header("Content-Type: text/js");
require('../../../../wp-load.php');
require_once('../class.vslidecycle.php');
$vslidecycle = new vslideCycle;
$effect = $vslidecycle->conf->effect;
$button = $vslidecycle->conf->button;

print "jQuery('.vslideCyclePlugin').cycle({
                  fx: '" . ($effect != null ? $effect : 'blindX') . "',
                  timeout:3000,
                  pager:'#vslidecyclenav',
                  prev: '#prev',
                  next: '#next',
                  pagerEvent: 'click',
                  //fastOnEvent: true
                  }); " .
        ($button ? ' jQuery(\'#vslidecyclebar\').width( jQuery(\'#vslidecyclecontainer\').width()+1);' : '');
?>