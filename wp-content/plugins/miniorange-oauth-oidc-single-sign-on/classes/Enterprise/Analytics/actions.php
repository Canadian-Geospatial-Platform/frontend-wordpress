<?php


function emit_analytics_tab($Dn)
{
    global $xW;
    $BX = $xW->get_plugin_config()->get_current_config();
    if (!(!isset($BX["\141\143\164\x69\x76\141\164\145\x5f\x75\163\x65\162\137\141\156\141\x6c\x79\164\x69\x63\163"]) || !boolval($BX["\x61\143\x74\x69\166\141\164\x65\x5f\x75\163\145\x72\x5f\141\x6e\141\154\171\164\151\143\x73"]))) {
        goto N_;
    }
    return;
    N_:
    ?>
	<a class="nav-tab <?php 
    echo "\x61\x6e\141\154\171\164\x69\x63\163" === $Dn ? "\x6e\141\x76\55\x74\x61\x62\x2d\x61\143\x74\x69\x76\x65" : '';
    ?>
" href="admin.php?page=mo_oauth_settings&tab=analytics">User Analytics</a>
	<?php 
}
add_action("\x6d\x6f\x5f\x6f\x61\165\164\150\137\x63\x6c\x69\145\x6e\164\x5f\x61\144\x64\x5f\156\x61\166\x5f\164\x61\142\x73\137\x75\x69\137\151\156\x74\145\162\x6e\x61\x6c", "\145\x6d\x69\x74\x5f\141\156\141\154\x79\x74\x69\x63\163\x5f\x74\141\142", 10, 1);
