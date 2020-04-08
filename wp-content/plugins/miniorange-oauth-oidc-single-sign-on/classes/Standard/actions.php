<?php


function mo_oauth_client_auto_redirect_external_after_logout()
{
    $xW = new \MoOauthClient\Standard\MOUtils();
    $BX = $xW->get_plugin_config();
    if (empty($BX->get_config("\141\146\164\145\162\x5f\x6c\157\147\157\165\164\137\x75\162\x6c"))) {
        goto YGd;
    }
    $dk = $BX->get_config("\x61\146\164\145\x72\137\x6c\157\147\157\165\164\137\165\x72\154");
    $bI = get_current_user_id();
    $co = get_user_meta($bI, "\155\157\x5f\x6f\141\x75\x74\150\x5f\143\154\x69\x65\156\x74\x5f\154\141\x73\164\137\x69\144\x5f\164\x6f\153\145\156", true);
    $dk = str_replace("\x23\43\151\x64\137\164\157\153\145\x6e\x23\43", $co, $dk);
    wp_redirect($dk);
    die;
    YGd:
}
add_action("\167\160\x5f\154\157\147\x6f\165\x74", "\155\157\x5f\x6f\x61\x75\x74\x68\x5f\143\x6c\x69\x65\156\x74\x5f\141\x75\164\157\137\x72\x65\144\151\x72\x65\x63\164\137\145\170\164\145\x72\156\141\x6c\137\x61\146\x74\145\162\137\154\x6f\147\157\165\x74");
