<?php

namespace Helpie\Templates\Views\Main_Page;

if (!defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

global $pauple_helpie_options;

echo "<div class='helpie-single-page-module'>";

/* Top Area Template */
// include_once HELPIE_PLUGIN_PATH.'features/partials/helpie-top-area.php';
$ple_top_area = new \Helpie\Features\Components\Partials\Helpie_Top_Area();
$ple_top_area->render('archive_template');

$builder = new \Helpie\Templates\Views\Main_Page\Main_Page_Builder();
$builder->render();
echo "</div>";

echo "<div style='clear:both;'></div>";