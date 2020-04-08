<?php

namespace Helpie\Features\Components\Onboarding;

if (!class_exists('\Helpie\Features\Components\Onboarding\View')) {
    class View
    {
        public function __construct($props)
        {
            $this->items = $props;
        }

        public function get()
        {
            $html = '<div class="ui helpie-element onboarding container raised padded segment">';
            $html .= '<div class="ui inverted dimmer"><div class="ui text loader">' . __("Importing", HELPIE_DOMAIN) . ' ...</div></div>';
            $html .= '<div class="sections">';
            $html .= $this->get_section();
            $html .= '</div>';
            $html .= $this->get_navigation();

            $html .= '</div>';

            return $html;
        }

        protected function get_section()
        {
            $html = '<div class="active section" data-tab="page_setup">';
            $html .= $this->get_header('Page Setup', 'rocket', 'Manage basic main page settings');
            $html .= $this->get_content();
            $html .= '</div>';

            $html .= '<div class="section" data-tab="demo_setup">';
            $html .= $this->get_header('Demo Content & Dummy Content', 'newspaper outline', 'Content to get started');
            $html .= $this->get_demo_content();
            $html .= '</div>';

            $html .= '<div class="section" data-tab="finish">';
            $html .= $this->get_header('Finish', 'green check', 'Successfully, Setup completed');
            $html .= '<div class="ui small finish_page"></div>';
            $html .= '</div>';

            return $html;
        }

        protected function get_header($title, $icon, $sub_title)
        {
            $html = '<h3 class="ui header">';
            $html .= '<i class="circular ' . $icon . ' icon"></i>';
            $html .= '<div class="content"> ';
            $html .= $title;
            $html .= '<div class="sub header">' . $sub_title . '</div>';
            $html .= '</div>';
            $html .= '</h3>';

            return $html;
        }

        protected function get_demo_content()
        {
            $html = '<div class="ui small demo_setup form">';
            $html .= '<div class="field"><label>Choose Demo Style</label>';
            $html .= $this->get_info_message();
            $html .= '</div>';
            $html .= '<div class="fields">';
            foreach ($this->items['demos'] as $demo) {
                $html .= $this->get_image_field($demo, 'startup');
            }

            $html .= '</div>';

            $html .= '<div class="field">';
            $html .= '<label>Select Categories to add</label>';
            $html .= '<div class="ui categories selection multiple dropdown">';
            $html .= '<input name="categories" type="hidden" multiple="" value="all">';
            $html .= '<i class="dropdown icon"></i>';
            $html .= '<div class="text">Select Category</div>';
            $html .= '<div class="menu">';
            $html .= '<div class="item" data-value="all">All</div>';

            foreach ($this->items['demos']['woostore']['categories'] as $catgory) {
                $html .= '<div class="item" data-value="' . $catgory['slug'] . '">' . $catgory['name'] . '</div>';
            }

            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '</div>';

            return $html;
        }

        protected function get_image_field($demo, $checked)
        {
            $checked = ($checked == $demo['name']) ? 'checked' : '';

            $html = '<div class="field">';
            $html .= '<div class="ui radio checkbox ' . $checked . '">';
            $html .= '<input type="radio" name="demo" value="' . $demo['name'] . '" ' . $checked . ' class="hidden" >';
            $html .= '<img class="ui image" src="' . $demo['preview'] . '">';
            $html .= '<label>' . $demo['name'] . '</label>';
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }

        protected function get_content()
        {
            $html = '<div class="ui small page_setup form">';

            $html .= '<div class="field">';
            $html .= '<label>What do you want to create</label>';
            $html .= '<select name="page_type" class="ui dropdown">';
            $html .= '<option value="">knowledge base</option>';
            $html .= '<option value="knowledge_base">Knowledge Base</option>';
            $html .= '<option value="wiki">Wiki</option>';
            $html .= '<option value="documentation">Documentation</option>';
            $html .= '</select>';
            $html .= '</div>';

            $html .= '<div class="field">';
            $html .= '<label>Name of your Knowledge Base</label>';
            $html .= '<input type="text" name="page_name" placeholder="Knowledge Base">';
            $html .= '</div>';

            $html .= '<div class="field">';
            $html .= '<label>Slug ( The last part of the URL you see in the browser )</label>';
            $html .= '<input type="text" name="page_slug" placeholder="knowledge_base">';
            $html .= '</div>';

            $html .= '</div>';

            return $html;
        }

        protected function get_info_message()
        {
            $html = '<div class="ui info message">';

            $html .= '<div class="header">';
            $html .= 'For the best reproduction of the demos, use:';
            $html .= '</div>';

            $html .= '<ul class="list">';
            $html .= $this->get_li_link(admin_url('plugin-install.php?s=elementor&tab=search&type=term'), 'Elementor Page Builder');
            $html .= $this->get_li_link(admin_url('theme-install.php?search=astra'), 'Astra Theme');
            $html .= $this->get_li_link(admin_url('plugin-install.php?s=helpie+faq&tab=search&type=term'), 'Helpie FAQ Plugin');
            $html .= '</ul>';

            $html .= '</div>';

            return $html;
        }

        protected function get_li_link($link, $text)
        {
            return '<li><a href="' . $link . '" target="_blank"> ' . $text . ' </a></li>';
        }

        protected function get_navigation()
        {
            $html = '<div class="ui centered row grid">';
            $html .= $this->get_buttons();
            $html .= $this->get_steps();
            $html .= '</div>';

            return $html;
        }

        protected function get_buttons()
        {
            $html = '<div class="row">';
            $html .= '<div class="ui mini buttons">';
            $html .= '<button class="ui previous button">Previous</button>';
            $html .= '<div class="or"></div>';
            $html .= '<button class="ui positive next button">Next</button>';
            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }

        protected function get_steps()
        {
            $html = '<div class="row">';
            $html .= '<div class="ui mini steps">';

            $html .= '<div class="active step" data-tab="page_setup">';
            $html .= '<i class="rocket icon"></i>';
            $html .= '<div class="content">';
            $html .= '<div class="title">Page Setup</div>';
            $html .= '<div class="description">Basic main page settings</div>';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '<div class="step" data-tab="demo_setup">';
            $html .= '<i class="newspaper outline icon"></i>';
            $html .= '<div class="content">';
            $html .= '<div class="title">Demo Content</div>';
            $html .= '<div class="description">Content to get started</div>';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '<div class="step" data-tab="finish">';
            $html .= '<i class="info circle icon"></i>';
            $html .= '<div class="content">';
            $html .= '<div class="title">Finish</div>';
            $html .= '<div class="description">Successfully, Setup completed</div>';
            $html .= '</div>';
            $html .= '</div>';

            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }
    }
}
