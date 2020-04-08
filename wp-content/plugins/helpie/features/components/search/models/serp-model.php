<?php

namespace Helpie\Features\Components\Search\Models;

if (!class_exists('\Helpie\Features\Components\Search\Models\SERP_Model')) {
    class SERP_Model
    {
    	public function get_title_based_point($input_query, $resultOfQuery)
        {
            foreach ($resultOfQuery as $key => $value) {
                $title = $resultOfQuery[$key]['title'];
                $pattern = '/'.$input_query.'/i';

                if (!isset($resultOfQuery[$key]['serp_score'])) {
                    $resultOfQuery[$key]['serp_score'] = 0;
                }

                if (preg_match($pattern, $title)) {
                    $resultOfQuery[$key]['serp_score'] += 15;
                }
            }

            if (!empty($resultOfQuery)) {
                usort($resultOfQuery, function ($a, $b) {
                    return $b["serp_score"] - $a["serp_score"];
                });
            }

            return  $resultOfQuery;
        }

        public function get_content_based_point($input_query, $resultOfQuery)
        {
            if (isset($resultOfQuery) && !empty($resultOfQuery)) {
                foreach ($resultOfQuery as $key => $value) {
                    $content = $resultOfQuery[$key]['content'];
                    $matches = array();
                    $pattern = '/'.$input_query.'/i';

                    if (!isset($resultOfQuery[$key]['serp_score'])) {
                        $resultOfQuery[$key]['serp_score'] = 0;
                    }
                    if (preg_match_all($pattern, $content, $matches)) {

                        // Is matched more than one
                        if (1 < count($matches[0])) {
                            $resultOfQuery[$key]['serp_score'] += 10;

                        } // Is matched one
                        elseif (1 == count($matches[0])) {
                            $resultOfQuery[$key]['serp_score'] += 5;
                        }
                    }
                }
            }
            if (!empty($resultOfQuery)) {
                usort($resultOfQuery, function ($a, $b) {
                    return $b["serp_score"] - $a["serp_score"];
                });
            }

            return  $resultOfQuery;
        }
        public function get_category_based_point($input_query, $resultOfQuery)
        {
            foreach ($resultOfQuery as $key => $value) {
                $category = $resultOfQuery[$key]['category'];
                $pattern = '/'.$input_query.'/i';

                if (!isset($resultOfQuery[$key]['serp_score'])) {
                    $resultOfQuery[$key]['serp_score'] = 0;
                }

                if (preg_match($pattern, $category)) {
                    $resultOfQuery[$key]['serp_score'] += 4;
                }
            }

            if (!empty($resultOfQuery)) {
                usort($resultOfQuery, function ($a, $b) {
                    return $b["serp_score"] - $a["serp_score"];
                });
            }

            return  $resultOfQuery;
        }
        public function get_tags_based_point($input_query, $resultOfQuery)
        {
            if (isset($resultOfQuery) && !empty($resultOfQuery)) {
                foreach ($resultOfQuery as $key => $value) {
                    $tags = $resultOfQuery[$key]['tags'];
                    $tags = implode(', ', $tags);

                    $pattern = '/'.$input_query.'/i';

                    if (!isset($resultOfQuery[$key]['serp_score'])) {
                        $resultOfQuery[$key]['serp_score'] = 0;
                    }
                    if (preg_match($pattern, $tags)) {
                        $resultOfQuery[$key]['serp_score'] += 6;
                    }
                }
            }
            if (!empty($resultOfQuery)) {
                usort($resultOfQuery, function ($a, $b) {
                    return $b["serp_score"] - $a["serp_score"];
                });
            }

            return  $resultOfQuery;
        }// End of function
    }// End of class
}// End of if statement