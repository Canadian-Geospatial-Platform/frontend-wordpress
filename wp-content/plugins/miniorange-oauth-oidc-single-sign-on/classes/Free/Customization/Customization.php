<?php


namespace MoOauthClient\Free;

use MoOauthClient\Free\CustomizationInterface;
class Customization implements CustomizationInterface
{
    private $versi;
    function __construct()
    {
        $this->versi = VERSION;
    }
    function render_free_ui()
    {
        global $xW;
        $zb = $xW->mo_oauth_client_get_option("\x6d\x6f\x5f\x6f\x61\x75\x74\x68\137\x69\143\x6f\x6e\x5f\x63\157\x6e\x66\x69\x67\x75\x72\145\137\143\163\x73");
        $zb = str_replace("\x7d", '', $zb);
        $zb = str_replace("\x2e\157\141\165\x74\x68\154\157\x67\x69\x6e\x62\165\164\164\157\x6e\173", '', $zb);
        $zb = str_replace("\56\157\x61\165\x74\150\x6c\x6f\147\x69\156\x62\165\x74\164\157\x6e\40\x7b", '', $zb);
        $g6 = $m2 = '';
        function format_custom_css_value($pl)
        {
            $ZY = explode("\73", $pl);
            $RF = '';
            $MC = 0;
            cw:
            if (!($MC < count($ZY))) {
                goto lc;
            }
            $RF .= str_replace("\xd\12", '', $ZY[$MC]);
            $RF .= empty($ZY[$MC]) ? '' : "\73" . "\15\xa";
            cD:
            $MC++;
            goto cw;
            lc:
            return $RF;
        }
        global $xW;
        ?>

	<?php 
        if (!(($xW->mo_oauth_hbca_xyake() || !$xW->mo_oauth_is_customer_registered()) && $this->versi === "\155\157\137\x66\162\145\145\x5f\x76\x65\x72\x73\x69\x6f\x6e")) {
            goto YS;
        }
        echo "\74\x64\151\166\x20\x63\154\141\x73\x73\x3d\x22\x6d\157\x5f\157\x61\x75\164\150\137\160\x72\145\x6d\151\165\x6d\137\x6f\x70\164\151\x6f\x6e\x5f\164\145\170\164\x22\x3e\x3c\x73\160\141\156\40\x73\x74\x79\154\x65\75\42\143\x6f\x6c\x6f\x72\x3a\162\145\144\73\42\76\52\x3c\x2f\163\x70\x61\x6e\76\x54\150\x69\163\x20\x69\163\40\141\40\163\x74\141\x6e\144\141\x72\144\40\x66\145\x61\x74\x75\162\145\56\12\x9\74\x61\40\150\x72\x65\146\75\42\141\x64\155\x69\x6e\x2e\x70\150\x70\77\160\141\147\x65\75\155\157\137\x6f\x61\x75\164\x68\x5f\163\x65\164\164\151\156\x67\x73\x26\164\x61\x62\x3d\154\151\143\145\x6e\163\151\156\147\42\76\x43\x6c\x69\x63\x6b\x20\110\145\x72\145\74\x2f\141\x3e\40\164\157\40\163\x65\x65\x20\157\x75\162\40\146\x75\154\x6c\x20\x6c\x69\x73\164\40\x6f\x66\40\123\x74\141\156\x64\141\x72\x64\40\x46\145\141\x74\165\x72\145\x73\x2e\x3c\x2f\144\x69\166\x3e";
        $g6 = "\x6d\x6f\137\x6f\141\165\164\x68\x5f\160\x72\145\x6d\151\165\155\137\157\x70\x74\151\x6f\156";
        $m2 = "\74\x73\143\162\151\160\x74\76\x6a\121\x75\x65\x72\x79\x28\x20\x64\157\143\x75\x6d\145\156\164\x20\51\x2e\162\145\x61\x64\x79\50\x66\165\x6e\143\164\151\157\x6e\50\51\x20\x7b\x20\x6a\x51\165\x65\x72\x79\x28\42\56\155\x6f\x5f\157\141\x75\x74\x68\x5f\160\x72\145\155\151\x75\x6d\137\x6f\160\164\x69\157\156\40\72\151\156\x70\165\164\42\51\x2e\x70\x72\x6f\x70\50\42\x64\x69\163\x61\x62\x6c\145\x64\x22\x2c\40\164\x72\x75\x65\x29\x3b\x7d\51\x3b\x20\x3c\57\163\x63\x72\x69\160\164\x3e";
        YS:
        ?>

	<div id="mo_oauth_customiztion" class="mo_table_layout mo_oauth_app_customization <?php 
        echo $g6;
        ?>
">
	<form id="form-common" name="form-common" method="post" action="admin.php?page=mo_oauth_settings&tab=customization">
		<input type="hidden" name="option" value="mo_oauth_app_customization" />
		<?php 
        wp_nonce_field("\x6d\157\137\157\x61\165\x74\x68\x5f\x61\x70\x70\137\x63\165\163\164\157\155\151\x7a\141\164\151\157\156", "\x6d\x6f\137\x6f\141\165\x74\150\x5f\141\160\x70\137\x63\x75\x73\164\157\x6d\x69\x7a\141\x74\x69\157\x6e\x5f\156\x6f\x6e\143\145");
        ?>
		<h2>Customize Icons</h2>
		<table class="mo_settings_table">
			<tr>
				<td><strong>Icon Width:</strong></td>
				<td><input type="text" id="mo_oauth_icon_width" name="mo_oauth_icon_width" value="<?php 
        echo $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\x61\165\x74\150\137\x69\x63\157\x6e\x5f\167\x69\144\164\150");
        ?>
"> e.g. 200px or 100%</td>
			</tr>
			<tr>
				<td><strong>Icon Height:</strong></td>
				<td><input  type="text" id="mo_oauth_icon_height" name="mo_oauth_icon_height" value="<?php 
        echo $xW->mo_oauth_client_get_option("\155\x6f\x5f\157\141\x75\x74\x68\137\x69\x63\157\x6e\x5f\150\x65\151\x67\150\x74");
        ?>
"> e.g. 50px or auto</td>
			</tr>
			<tr>
				<td><strong>Icon Margins:</strong></td>
				<td><input  type="text" id="mo_oauth_icon_margin" name="mo_oauth_icon_margin" value="<?php 
        echo $xW->mo_oauth_client_get_option("\x6d\157\x5f\x6f\x61\165\164\150\137\151\143\157\156\x5f\x6d\x61\162\147\x69\x6e");
        ?>
"> e.g. 2px 0px or auto</td>
			</tr>
			<tr>
				<td><strong>Custom CSS:</strong></td>
				<td><textarea type="text" id="mo_oauth_icon_configure_css" style="resize: vertical; width:400px; height:180px;  margin:5% auto;" rows="6" name="mo_oauth_icon_configure_css"><?php 
        echo rtrim(trim(format_custom_css_value($zb)), "\x3b");
        ?>
</textarea><br/><strong>Example CSS:</strong>
<pre>
	background: #7272dc;
	height:40px;
	padding:8px;
	text-align:center;
	color:#fff;
</pre>
			</td>
			</tr>
			<tr>
				<td><strong>Logout Button Text: </strong></td>
				<td><input  type="text" id="mo_oauth_custom_logout_text" name="mo_oauth_custom_logout_text" placeholder="Howdy, ##user##" value="<?php 
        echo $xW->mo_oauth_client_get_option("\x6d\x6f\137\157\141\x75\x74\150\x5f\143\165\163\164\x6f\x6d\x5f\x6c\x6f\x67\157\x75\x74\137\164\145\170\x74");
        ?>
"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" name="submit" value="Save settings"
					class="button button-primary button-large" /></td>
			</tr>
		</table>
	</form>
	</div>
	<?php 
        echo $m2;
        ?>

	<?php 
    }
}
?>
