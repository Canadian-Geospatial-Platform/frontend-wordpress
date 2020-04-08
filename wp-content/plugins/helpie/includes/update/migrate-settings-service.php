<?php

namespace Helpie\Includes\Update;

if (! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

// Class to handle updates from version less than 1.1.0

if (!class_exists('\Helpie\Includes\Update\Migrate_Settings_Service')) {
    class Migrate_Settings_Service
    {
        public function get_new_value($rule)
        {
            $option_name = $rule['from'][0];
            $option_value = get_option($option_name);
            $property_name = $rule['from'][1];
            $property_value = $option_value[$property_name];

            if (!isset($rule['old_values'])) {
                return $property_value;
            } else {
                $old_values = $rule['old_values'];
                $new_value = '';

                for ($ii = 0; $ii < sizeOf($rule['old_values']); $ii++) {
                    if ($property_value == $rule['old_values'][$ii]) {
                        $new_value = $rule['new_values'][$ii];
                        break;
                    }
                }

                return $new_value;
            }
        } // end of get_new_value

        public function copy_option_properties($options_to_copy)
        {
            foreach ($options_to_copy as $key => $value) {
                $option_name = $value['from'][0];
                $option_value = get_option($option_name);
                $property_name = $value['from'][1];
                // echo "<script> console.log('update_options: ".$property_name. "');</script>";
                if (isset($option_value[$property_name])) {
                    $property_value = $option_value[$property_name];


                    $new_option_name = $value['to'][0];
                    $new_property_name = $value['to'][1];
                    $new_option_value = get_option($new_option_name);

                    if (!isset($new_option_value)) {
                        $new_option_value = array(
                            $new_property_name => $property_value
                        );
                    } else {
                        $new_option_value[$new_property_name] = $this->get_new_value($value);
                    }

                    update_option($new_option_name, $new_option_value);
                }
            } // end of foreach
        } // end of copy_option_properties
    }
}
