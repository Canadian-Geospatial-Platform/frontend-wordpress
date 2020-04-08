<?php
/**
 * Checks Envato WordPress plugins' updates and download its if any update available
 *
 * @author Eray Alakese <erayalakese@gmail.com>
 * @version 1.3.2
 * @license GPL v2
 */
namespace erayalakese;

class Envato_Update_Checker
{

	private $plugin_name;
	private $plugin_slug;
	private $recent_version;
	private $purchase_code;
	private $envato_update_checker_json;
    private $envato_download_request;

	/**
	 * Workflow
	 *
	 * 1) Check if user registered any purchase code for {plugin slug}
	 * 2) If yes, check envato-update-checker.json file, else go to step 4
	 * 3) If there is a new version, show admin_notices, else do nothing
	 * 4) Ask user to save purchase code.
	 */

	function __construct($plugin_name, $plugin_slug, $recent_version, $envato_update_checker_json, $personal_token)
	{
		$this->plugin_name = $plugin_name;
		$this->plugin_slug = $plugin_slug;
		$this->recent_version = $recent_version;
		$this->envato_update_checker_json = $envato_update_checker_json;
		$this->personal_token = $personal_token;

        $this->envato_download_request = 'https://api.envato.com/v3/market/buyer/download?purchase_code=876c7b85-c580-45e1-a10b-dff86c3ddbbd';
        // $this->envato_download_request = 'https://api.envato.com/v1/market/item-prices:18882940.json';
		$this->api = new \erayalakese\Envato_Market_API($this->personal_token);

		add_action('admin_init', array($this, 'init'));
		add_action('admin_init', array($this, 'http_requests'));
	}

	function init()
	{
		$this->purchase_code = get_option('euc_'.$this->plugin_slug.'_pc');
		if($this->purchase_code === FALSE)
		{
			add_action('admin_notices', array($this, 'ask_for_pc'));
		}
		else
		{
			$pause_time = get_option('euc_'.$this->plugin_slug.'_pausetime');
			if(!$pause_time || ($pause_time && time() > $pause_time+(60*60*24) ))
				add_action('admin_notices', array($this, 'update_check'));
		}
	}

	function ask_for_pc()
	{
		?>
		<div class="error"><p>
			<strong>You need to type your purchase code to get notifications about updates.</strong>
			<form action="" method="GET"><input type="text" name="euc_input_pc"><input type="submit"></form>
		</p></div>
		<?php
	}

	function http_requests()
	{
		if(isset($_GET["euc_input_pc"]))
		{
			$r = update_option('euc_'.$this->plugin_slug.'_pc', $_GET["euc_input_pc"]);
			wp_safe_redirect(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'wp-admin/index.php');
			exit;
		}
		elseif(isset($_GET["euc_action"]) && $_GET["euc_action"] == 'download')
		{
			$this->api->download_item($this->purchase_code);
		}
		elseif(isset($_GET["euc_remind_later"]))
		{
			$this->remind_later();
			wp_safe_redirect(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'wp-admin/index.php');
			exit;
		}
		elseif(isset($_GET["euc_dont_remind"]) && is_numeric($_GET["euc_dont_remind"]))
		{
			$this->dont_remind($_GET["euc_dont_remind"]);
			wp_safe_redirect(isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'wp-admin/index.php');
			exit;
		}
	}

    function get_download_info(){
        if($_GET['access_token']){

        $ch = curl_init();
        $params =array(
            'header' => "Authorization: Bearer ".$_GET['access_token'],
        );

        echo "access_token: " . $_GET['access_token'];

        $authorization = "Authorization: Bearer ".$_GET['access_token'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        $query = http_build_query($params);
        curl_setopt($ch, CURLOPT_URL,$this->envato_download_request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);

        print_r($server_output);

        global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once( ABSPATH . '/wp-admin/includes/file.php' );
		WP_Filesystem();
	}
        $server_output = json_decode($server_output, true);
        $download_file = download_url( $server_output['wordpress_plugin'] );



        global $helpie_env;
        echo "helpie_env: ".$helpie_env;
        if($helpie_env == 'dev'){
            $upgrade_folder = $wp_filesystem->wp_content_dir() . "/plugins/testlocation";
        }else{
            $upgrade_folder = $wp_filesystem->wp_content_dir() . "/plugins";
        }

        $result = unzip_file( $download_file, $upgrade_folder );

        echo "result: ";
        print_r($result);
        }
    }

    function get_envato_login_url(){
        $client_id = 'helpie-p5s3qoyb';
        $redirect_uri= 'http://pauple.com/wordpress/wp-content/uploads/helpie/envato-helpie-app.php';
        $envato_app_login_url = "https://api.envato.com/authorization?response_type=code&client_id=".$client_id."&redirect_uri=".$redirect_uri;
        return $envato_app_login_url;
    }

    function get_download_info_new(){
        // Including class to your project
        require(dirname(dirname(dirname(__DIR__))).'/update/envato-api.php');
        // Setup Envato with your credentials

        $personal_token = 'woTA5EOvr6WpNFnjzEOPQeIAmgENrovT';
        $envato = new \Envato($personal_token);
        // Receive all purchases of the buyer
        // $purchases = $envato->call('/buyer/list-purchases');

        // Receive purchase data by submitting the purchase code
        $purchase_data = $envato->call('/buyer/download?purchase_code=876c7b85-c580-45e1-a10b-dff86c3ddbbd');
        echo "purchase_data: ";
        print_r($purchase_data);

    }

	function update_check()
	{
		$version = $this->recent_version;
	    $url = $this->envato_update_checker_json;
	    if(function_exists('curl_version')) :
	        $CURL = curl_init();
	        curl_setopt($CURL, CURLOPT_URL, $url);
	        curl_setopt($CURL, CURLOPT_HEADER, 0);
	        curl_setopt($CURL, CURLOPT_RETURNTRANSFER, 1);
	        $data = curl_exec($CURL);
	        curl_close($CURL);
	        $c = $data;
	    else :
	        $c = file_get_contents($url);
	    endif;
	    $json = json_decode($c);
	    $new_version = str_replace('.', '' , $json->{$this->plugin_slug});
	    $recent_version = str_replace('.', '' , $version);
	    $dont_remind = get_option('euc_'.$this->plugin_slug.'_dontremind');
        // $env_req_url = $this->envato_download_request;
        $this->get_download_info_new();


	    if($new_version > $recent_version && (!$dont_remind || ($dont_remind != (int)$new_version))) :
	        ?>
	        <div class="update-nag">
                <a href="<?php echo $this->get_envato_login_url()?>">Login</a>
	            New <strong><?=$this->plugin_name?> plugin</strong> update available. <a href="?euc_action=download">Click here</a> to download newest version of the plugin.
	        	<br /><br />
	        	<div style="float:right"><a href="?euc_remind_later" onclick="if(confirm('Are you sure?')) return true; else return false;">remind me later</a>&nbsp;<a href="?euc_dont_remind=<?=$new_version?>" onclick="if(confirm('Are you sure?')) return true; else return false;">don't warn me about this version again</a></div>
	        </div>
	    <?php
	    endif;
	}

	function remind_later()
	{
		update_option('euc_'.$this->plugin_slug.'_pausetime', time());
		add_action('admin_notices', array($this, 'remind_later_notice'));
	}

	function remind_later_notice()
	{
		?>
		<div class="update-nag">
            OK, we will remind you again 24 hours later.
        </div>
        <?php
	}

	function dont_remind($version)
	{
		update_option('euc_'.$this->plugin_slug.'_dontremind', $version);
		add_action('admin_notices', array($this, 'dont_remind_notice'));
	}

	function dont_remind_notice()
	{
		?>
		<div class="update-nag">
            OK, we won't warn you again for this version.
        </div>
        <?php
	}
}
