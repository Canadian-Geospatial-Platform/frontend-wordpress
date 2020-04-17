<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.gcgeo.com/
 * @since      1.0.0
 *
 * @package    Cgp_Shortcodes
 * @subpackage Cgp_Shortcodes/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cgp_Shortcodes
 * @subpackage Cgp_Shortcodes/public
 * @author     gcgeo <vautour.pascal@gmail.com>
 */
class Cgp_Shortcodes_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Cgp_Shortcodes_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cgp_Shortcodes_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style('bootstrap-css', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), '4.3.1', 'all');

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cgp-shortcodes-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Cgp_Shortcodes_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cgp_Shortcodes_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('bootstrap-js', plugin_dir_url(__FILE__) . 'js/bootstrap.bundle.min.js', array('jquery'), '4.3.1', true);

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cgp-shortcodes-public.js', array('jquery'), $this->version, false);

    }

    public function hello_world_shortcode()
    {
        return <<<HTML
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Hello world!</h5>
				<h6 class="card-subtitle mb-2 text-muted">Up and running</h6>
				<p class="card-text">This is a confirmation that the cgp-shortcodes plugin is properly working</p>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<strong>Success!</strong> Dismiss this to test the javascript!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
			</div>
		</div>
HTML;
    }

    public function simple_search_shortcode()
    {
        return <<<HTML
		<div class="card">
			<div class="card-body">
				<h5 class="card-title">Search</h5>
				<div class="row">
					<div class="col">
						<form id="cgp-shortcodes-simple-search">
							<div class="input-group mb-3">
								<input id="cgp-filter-search-term" type="text"
									class="form-control cgp-shortcodes-form-control" placeholder="Search datasets"
									aria-label="Topic Category" aria-describedby="cgp-filter-search-term">
								<div class="input-group-append">
									<button class="btn btn-primary cgp-shortcodes-search-btn">+</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div id="cgp-shortcodes-search-pills">
				</div>
			</div>
		</div>
HTML;
    }

    public function redirect_search_shortcode($atts = [])
    {
        $ret .= <<<HTML
		<div class="row">
			<div class="col">
				<form id="cgp-shortcodes-redirect-search">
					<div class="input-group">
						<input type="text" class="cgp-shortcodes-form-control form-control " placeholder="Search datasets"
							aria-label="Search datasets" aria-describedby="cgp-shortcodes-redirect-search">
						<div class="input-group-append">
							<button class="btn btn-primary cgp-shortcodes-search-btn">Search</button>
						</div>
					</div>
				</form>
			</div>
        </div>
HTML;
        $ret .= "<script>var cgpShortcodesRedirectSearchPath = \"";
        $ret .= esc_url($atts['redirect_path']) . "\"</script>";
        return $ret;
    }

    public function full_search_results_shortcode()
    {
        return <<<HTML
		<div id="metadata-search-result" class="container-fluid">
			<div class="row">
				<div class="col">
					<div class="card">
						<h3>Your results will be displayed here.</h3>
					</div>
				</div>
			</div>
		</div>
HTML;
	}

	public function single_search_result_shortcode()
    {
        $processed = FALSE;
        $ERROR_MESSAGE = '';

        // ************* Call API:
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://zq7vthl3ye.execute-api.ca-central-1.amazonaws.com/sta/geo?select=[%22properties%22]&id=" . $_POST['id']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($ch);
        curl_close ($ch);

        $result = json_decode($json);

        if ($result->{'code'} == '1')
        {
          $processed = TRUE;
        }else{
          $ERROR_MESSAGE = $result->{'data'};
        }

        if (!$processed && $ERROR_MESSAGE != '') {
            echo $ERROR_MESSAGE;
        } else {
        $ret .= <<<HTML
            <div id="single-search-result" class="container-fluid">
                <div class="row">
                    <div class="col">
                        <div class="card p-4">
                        <div class="card-header mb-3">
                            <h4 class="card-title">
        HTML;
        $ret .= $result->Items[0]->properties->title->en; 
        $ret .= <<<HTML
                          </h4>
                          </div>
                          <br>
                          <h5>Description </h5>
                          <p class="card-text">
        HTML;
        $ret .= $result->Items[0]->properties->description->en;
        $ret .= <<<HTML
                          </p><div class="row"><div class="col">
                          <h5>Theme </h5>
                          <p class="card-text">
        HTML;
        $ret .= $result->Items[0]->properties->topiccategory;
        $ret .= "</p></div>";   
        $ret .= <<<HTML
        <div class="col">
        <h5>Country </h5>
        <p class="card-text"> 
        HTML;
        $ret .= $result->Items[0]->properties->country;    
        $ret .= "</p></div>";   
        $ret .= <<<HTML
        <div class="col">
        <h5>Time Period </h5>
        <p class="card-text">
        HTML;
        $ret .= "From: " . $result->Items[0]->properties->datestart . "<br> To: " . $result->Items[0]->properties->dateend;
        $ret .= "</p></div></div>";
        $ret .= '<h3>Resources </h3>';
        foreach ($result->Items[0]->properties->resources as $resource) {
            $ret .= <<<HTML
            <div class="row">
            <div class="col">
                <div class="card">
            HTML;
            $ret .= "<div class=\"row m-3\"><div class=\"col\"><h4>" . $resource->name->en . "</h4></div></div>";
            $ret .= "<div class=\"row m-3\"><div class=\"col\"><h5>Type </h5>" . $resource->format . $the_title;
            $ret .= "</div><div class=\"col\"><h5>Language </h5>" . $resource->description->en . "</div>";
            $ret .= "<div class=\"col\"><h5>Format </h5>" . $resource->format;
            $ret .= "</div><div class=\"col\"><h5></h5><a href=\"" . $resource->url . "\"><button class=\"btn btn-primary\">Download</button></div></div>";
            $ret .= <<<HTML
                            </a>
                        </div>
                    </div>
                </div>
            HTML;
        }                       
        $ret .= <<<HTML
                     </div>
                 </div>
             </div>
         </div>
        HTML;

        return $ret;
        }
    }
}