<?php


namespace MoOauthClient\Enterprise;

use MoOauthClient\Enterprise\UserAnalyticsDBOps;
class UserAnalytics
{
    private $db_ops;
    public function __construct()
    {
        $this->db_ops = new UserAnalyticsDBOps();
    }
    public function render_ui()
    {
        ?>
		<div class="mo_table_layout">
			<div class="mo_wpns_small_layout">
				<form action="" id="manualblockipform" method="post">
					<input type="hidden" name="option" value="mo_wpns_manual_clear" />
					<?php 
        wp_nonce_field("\155\157\137\x77\160\156\163\137\x6d\141\156\165\x61\154\137\143\154\x65\141\162", "\x6d\157\x5f\167\x70\156\x73\137\155\x61\156\x75\141\154\137\143\154\x65\x61\162\137\156\157\156\143\x65");
        ?>
					<table>
						<tr>
							<td style="width: 100%"><h2>User Transactions Report</h2></td>
							<td>
								<input type="button" class="button button-primary button-large" value="Refresh" onClick="window.location.reload()">
							</td>
							<td>
								<input type="submit" class="button button-primary button-large" value="Clear Reports">
							</td>
						</tr>
					</table>
				</form>
				<table id="reports_table" class="display mo_oauth_client_user_analytics" cellspacing="0" width="100%" border="1px">
					<thead>
						<tr>
							<td><strong>Username</strong></td>
							<td><strong>Status</strong></td>
							<td><strong>Application</strong></td>
							<td><strong>Created Date</strong></td>
							<td><strong>Email</strong></td>
							<td><strong>Client IP</strong></td>
							<td><strong>Navigation URL</strong></td>
						</tr>
					</thead>
					<tbody>
						<?php 
        $this->populate_analytics_table();
        ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php 
    }
    private function populate_analytics_table()
    {
        $lj = $this->db_ops->get_entries(true);
        $Ug = array("\x73\x70\x61\x6e" => array("\x73\164\171\x6c\x65" => array()));
        foreach ($lj as $Z1) {
            $Ud = $this->get_status_html($Z1->status);
            ?>
			<tr>
				<td><?php 
            echo wp_kses($Z1->username, \get_valid_html());
            ?>
</td>
				<td><?php 
            echo wp_kses($Ud, \get_valid_html($Ug));
            ?>
</td>
				<td><?php 
            echo wp_kses($Z1->appname, \get_valid_html());
            ?>
</td>
				<td><?php 
            echo wp_kses(date("\115\x20\152\x2c\40\x59\x2c\40\x67\72\151\x3a\163\40\x61", strtotime($Z1->created_timestamp)), \get_valid_html());
            ?>
</td>
				<td><?php 
            echo wp_kses($Z1->email, \get_valid_html());
            ?>
</td>
				<td><?php 
            echo wp_kses($Z1->clientip, \get_valid_html());
            ?>
</td>
				<td><?php 
            echo wp_kses($Z1->navigationurl, \get_valid_html());
            ?>
</td>
			</tr>
			<?php 
            j_:
        }
        f1:
    }
    private function get_status_html($Nr = '')
    {
        if (!('' === $Nr)) {
            goto Ux;
        }
        return '';
        Ux:
        if (strpos(\strtolower($Nr), \strtolower("\x46\x41\x49\114\105\x44")) !== false) {
            goto Cp;
        }
        return "\74\163\160\141\156\x20\163\x74\x79\154\145\75\x22\x63\x6f\x6c\157\x72\x3a\x67\162\x65\145\156\42\76" . $Nr . "\74\x2f\163\160\x61\156\76";
        goto pa;
        Cp:
        return "\x3c\163\x70\x61\x6e\x20\163\x74\x79\x6c\x65\x3d\x22\x63\157\x6c\157\162\72\162\145\144\x22\x3e" . $Nr . "\74\57\x73\160\141\x6e\76";
        pa:
    }
}
