<?php

namespace Helpie\Features\Components\Insights;


if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly


if (!class_exists('\Helpie\Features\Components\Insights\Insights')) {
class Insights
{
    /**
     * Holds the values to be used in the fields callbacks.
     */
    private $page_name = 'insights_model_page';

    private $options;
    private $opts_grp = 'pauple_insights_model';


    /**
     * Start up.
     */
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));

    }

    /**
     * Add options page.
     */
    public function add_plugin_page()
    {
        $insights = __('Insights', 'pauple-helpie');
        // This page will be under "Settings"
        add_submenu_page('edit.php?post_type=pauple_helpie', $insights, $insights,
            'manage_options', 'pauple-insights', array($this, 'create_admin_page')
        );
    }

    /**
     * Options page callback.
     */
    public function create_admin_page()
    {
      $insights_model = new \Helpie\Features\Components\Insights\Insights_Model();

        // Set class property
        $this->options = get_option('helpie_core_options_main'); ?>
        <div class="wrap">

            <div class='main-form'>
              <form method="post" action="options.php">
              <?php
                  // This prints out all hidden setting fields
                  settings_fields('pauple_helpie_options');

                echo "<div id='core-settings-section' class='ph-settings-section active'>";
                    do_settings_sections($this->page_name);
                echo '</div>';

                $this->user_happiness_section();
                echo $this->render_most_viewed_page();
                echo $this->render_keyword_insight();
                echo $this->render_key_users_section();
                echo $this->render_key_articles_section();
                echo $this->render_top_most_frequently_words();



?>
              </form>
            </div>
        </div>
        <?php

    }

    public function user_happiness_section(){

        $content  = "<div class='pauple-dashboard-widget'>";
        $content .= "<h3>".__('User Happiness Index', 'pauple-helpie')."</h3>";
        $content .= "<div class='custom-labels'>";
        $content .= "<ul>";
        $content .= "<li class='emotion'><span data-vote='heart' class='voting-icon heart selected'><i class='fa fa-heart-o' aria-hidden='true'></i></span></li>";
        $content .= "<li class='emotion'><span data-vote='smile' class='voting-icon smile selected'><i class='fa fa-smile-o' aria-hidden='true'></i></span></li>";
        $content .= "<li class='emotion'><span data-vote='meh' class='voting-icon meh selected'><i class='fa fa-meh-o' aria-hidden='true'></i></span></li>";
        $content .= "<li class='emotion'><span data-vote='frown' class='voting-icon frown selected'><i class='fa fa-frown-o' aria-hidden='true'></i></span></li>";
        $content .= "</ul>";
        $content .= "</div>";
        $content .= "<div class='canvas-container'>";
        $content .= "<canvas id='myChart' width='300' height='300'></canvas>";
        $content .= "</div>";
        $content .= "</div>";
        echo $content;

    }

    public function render_key_articles_section(){

        //$insights_model = new Insights_Model();
        $html  = "<div class='pauple-dashboard-widget'>";
        $html .= "<h3>".__("Key Articles", "pauple-helpie")."</h3>";
        $html .= "<ul class='key-posts-nav'>";
        $html .= "<li class='active'><a data-target='#best-article-section'>".__('Highest Rating', 'pauple-helpie')."</a></li>";
        $html .= "<li><a data-target='#worst-article-section'>".__('Lowest Rating', 'pauple-helpie')."</a></li>";
        $html .= "</ul>";
        echo $html;

          $this->article_state_section('best');
          $this->article_state_section('worst');

        // print_r($insights_model->get_articles_list());
        echo "</div>";

    }

    public function article_state_section($state){

        $insights_model = new Insights_Model();
        $emotions = array( 0 => 'heart', 1 => 'smile', 2 => 'meh', 3 => 'frown');
        if($state == 'best'){
            $div_id = 'best-article-section';
            $active = 'active';
            $article_insights_array = $insights_model->get_best_articles_list();
        }else{
            $div_id = 'worst-article-section';
            $active = '';
            $article_insights_array = $insights_model->get_worst_articles_list();
        }

        $html  = "<div id='".$div_id."' class='post-list-section ".$active."'>";
        $html .= "<div class='user-list'>";
        $html .= "<table>";
        $html .= "<tr>";
        $html .= "<th class='name'>".__('Name', 'pauple-helpie')."</th>";

        foreach($emotions as $key => $value){
            $html .= "<th class='emotion'><span data-vote='".$value."' class='voting-icon ".$value." selected'><i class='fa fa-".$value."-o' aria-hidden='true'></i></span></th>";
        }
        $html .=  "</tr>";
        echo $html;
        echo $this->article_insight_votes_value_section($article_insights_array, $emotions);

       }


    public function article_insight_votes_value_section($article_insights_array, $emotions){
        // print_r($article_insights_array);
        $html = '';
        $args = array('orderby' => 'registered', 'order' => 'ASC');

        if ($article_insights_array != "" && is_array($article_insights_array)) {
            foreach ($article_insights_array as $article_insight) {

                if($article_insight != "" && is_array($article_insight)){
                    $votes = array();
                    $votes = $article_insight['votes'];

                    $html .= "<tr>";

                    $html .= "<td class='name'>".$article_insight['title']."</td>";
                    foreach($emotions as $key => $value){
                        $html .= "<td class='emotion'>".(isset($votes[$value]) ? $votes[$value] : 0)."</td>";
                    }

                    $html .=  "</tr>";
                 }

            }
        }

         $html .=  "</table></div></div>";
         return $html;

    }

    public function render_key_users_section(){

        $html  = "<div class='pauple-dashboard-widget'>";
        $html .= "<h3>".__("Key Users", "pauple-helpie")."</h3>";
        $html .= "<ul class='key-users-nav'>";
        $html .= "<li class='active'><a data-target='#most-happy-section'>".__('Most Happy', 'pauple-helpie')."</a></li>";
        $html .= "<li><a data-target='#most-unhappy-section'>".__('Most Unhappy', 'pauple-helpie')."</a></li>";
        $html .= "</ul>";
        echo $html;

        echo $this->user_state_section('happy');
        echo $this->user_state_section('unhappy');

        echo "</div>";


    }

    public function user_state_section($state){

        $insights_model = new Insights_Model();
        $emotions = array( 0 => 'heart', 1 => 'smile', 2 => 'meh', 3 => 'frown');
        if($state == 'happy'){
            $div_id = 'most-happy-section';
            $active = 'active';
            $user_insight_array = $insights_model->get_happy_users_list();
        }else{
            $div_id = 'most-unhappy-section';
            $active = '';
            $user_insight_array = $insights_model->get_unhappy_users_list();
        }

        $html = "<div id='".$div_id."' class='user-list-section ".$active."'>
        <div class='user-list'>
          <table>
              <tr>
                <th class='dp-img'></th>
                <th class='name'>".__('Name', 'pauple-helpie')."</th>";
                foreach($emotions as $key => $value){
        $html .= "<th class='emotion'><span data-vote='".$value."' class='voting-icon ".$value." selected'><i class='fa fa-".$value."-o' aria-hidden='true'></i></span></th>";
                }
               $html .= "</tr>";

        echo $html;
        echo $this->user_insight_votes_value_section($user_insight_array, $emotions);

    }


    public function user_insight_votes_value_section($user_insight_array, $emotions){

        $html = '';

        $args = array('orderby' => 'registered', 'order' => 'ASC');

        if ($user_insight_array != "" && is_array($user_insight_array)) {
            foreach ($user_insight_array as $user_insight) {

                if($user_insight != "" && is_array($user_insight)){
                    $votes = array();
                    $votes = $user_insight['votes'];

                    $html .= "<tr>";
                    $html .= "<td class='dp-img'><img src='".get_avatar_url($user_insight['user_id'], 32)."'/></td>";
                    $html .= "<td class='name'>".$user_insight['display_name']."</td>";
                    foreach($emotions as $key => $value){
                        $html .= "<td class='emotion'>".(isset($votes[$value]) ? $votes[$value] : 0)."</td>";
                    }

                    $html .= "</tr>";
                }

            }
        }


        $html .= "</table></div></div>";
        return $html;


    }




    public function render_keyword_insight(){
        $html  = "<div class='pauple-dashboard-widget helpie-keyword-widget'>";
        $html .= "<h3>" . __('Most Searched Keywords', 'pauple-helpie') . "</h3>";
        $html .= "<div class='table-container'>";
        $html .= "<table cellspacing='0' cellpadding='0'>";
        $html .= "<tr>
                    <th>".__('Keyword', 'pauple-helpie')."</th>
                    <th>".__('Searches', 'pauple-helpie')."</th>
                  </tr>";

                $previous_searches = get_option('helpie_searches');

                if (isset($previous_searches) && is_array($previous_searches)) {
                arsort($previous_searches);
                $counter = 0;
                foreach ($previous_searches as $key => $value) {
                    if($counter > 19){
                    break;
                }
                if($key != ''){
        $html .= "<tr><td>".$key."</td> <td>".$value."</td> </tr>";
                    $counter++;
                }

            }
        }

        $html .= "</table></div></div>";

        return  $html;

    }



    public function render_top_most_frequently_words(){

        $html  = "<div class='pauple-dashboard-widget helpie-keyword-widget'>";
        $html .= "<h3>" . __('Frequently Repeated Keywords', 'pauple-helpie') . "</h3>";
        $html .= "<div class='table-container'>";
        $html .= "<table cellspacing='0' cellpadding='0'>";
        $html .= "<tr> <th>".__('words', 'pauple-helpie')."</th>
                       <th>".__('count', 'pauple-helpie')."</th>
                  </tr>";
                    $insights_model = new Insights_Model();
                    $most_frequent_words = $insights_model->get_most_frequent_words();
                    foreach($most_frequent_words as $key => $value) {
        $html .= "<tr> <td>".$key."</td> <td>".$value."</td> </tr>";
            }

        $html .= "</table></div></div>";
        return $html;
    }

    public function render_most_viewed_page(){

        $html  = "<div class='pauple-dashboard-widget helpie-keyword-widget'>";
        $html .= "<h3>" . __('Most Viewed Pages', 'pauple-helpie') . "</h3>";
        $html .= "<div class='table-container'>";
        $html .= "<table cellspacing='0' cellpadding='0'>";
        $html .= "<tr> <th>".__('words', 'pauple-helpie')."</th>
                       <th>".__('count', 'pauple-helpie')."</th>
                  </tr>";
        $insights_model = new Insights_Model();
        $most_viewed_page = $insights_model->get_most_viewed_pages();

        foreach($most_viewed_page as $key => $value) {
            $html .= "<tr> <td>".$value['post_title']."</td> <td>".$value['post_views']."</td> </tr>";
        }

        $html .= "</table></div></div>";
        return $html;
    }


    /**
     * Register and add settings.
     */
    public function page_init()
    {
        add_settings_section(
            'helpie_core_settings', // ID
            __('Helpie Insights', 'pauple-helpie'), // Title
            array($this, 'print_core_settings'), // Callback
            $this->page_name // Page
        );
    }


    public function print_core_settings()
    {
        echo "<span class='sub-title1'>".__('Insights to a better Knowledge base.', 'pauple-helpie')."</span>";
    }



} // END CLASS

}


// if (is_admin()) {
//     $pauple_helpie_settings_page = new Insights();
// }
