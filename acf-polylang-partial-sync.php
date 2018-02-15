<?php 
/*
 * Plugin Name: ACF-Polylang partial sync
 * Description: Partially synchronize ACF custom fields between languages with Polylang
 * Author: Filippo Vigani
 * Text Domain: acf-polylang-partial-sync
 */

if(!function_exists('partial_sync_init')):
function partial_sync_init(){
    /* Adds a field setting to choose whether to synchronize the field or not */
    $add_field_settings = function ($field) {
        acf_render_field_setting( $field, array(
            'label'         => __('Synchronize Field'),
            'instructions'  => __('Synchronizes the field between different languages when using Polylang'),
            'name'          => 'sync_field',
            'type'          => 'true_false',
            'ui'            => 1,
        ), true);  
    };
    add_action('acf/render_field_settings', $add_field_settings);

    /* Filter keys by the setting found in ACF field */
    $filter_keys = function ($keys) {
        foreach($keys as $index => $key) {
            $field = get_field_object($key);
            if (!$field) {
                continue;
            }
            $sync = isset($field['sync_field']) ? $field['sync_field'] : 0;
            if (!$sync) {
                unset($keys[$index]);
            }
        }
        return $keys;
    };
    add_filter('pll_copy_post_metas', $filter_keys);
}
endif;

add_action('init', 'partial_sync_init');


 





?>