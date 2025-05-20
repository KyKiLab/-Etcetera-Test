<?php

class Real_Estate_Query_Modifier {
    public function __construct() {
        add_filter('parse_query', [$this, 'modify_custom_real_estate_queries']);
    }

    public function modify_custom_real_estate_queries($query) {
        if (
            isset($query->query_vars['post_type']) &&
            $query->query_vars['post_type'] === 'real_estate'
        ) {
            $query->set('meta_key', 'eco_rating');
            $query->set('orderby', 'meta_value_num');
            $query->set('order', 'DESC');
        }

        return $query;
    }
}
