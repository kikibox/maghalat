<?php
if(!defined('ABSPATH'))exit;
function navar_return_policy_url($lang=''){
    $lang=$lang?:navar_lang();
    $paths=array('fa'=>'قوانین','iraq'=>'iraq-rules','tj'=>'tj-rules','en'=>'en-rules','ru'=>'ru-rules');
    $p=get_page_by_path(isset($paths[$lang])?$paths[$lang]:'قوانین');
    if(!$p)$p=get_page_by_path('قوانین');
    return $p?get_permalink($p):home_url('/');
}
add_filter('woocommerce_structured_data_product',function($m,$p){if(!$p instanceof WC_Product)return $m;$m['brand']=array('@type'=>'Brand','name'=>'AFP');if($p->get_sku())$m['sku']=$p->get_sku();$count=(int)$p->get_review_count();$avg=(float)$p->get_average_rating();if($count&&$avg)$m['aggregateRating']=array('@type'=>'AggregateRating','ratingValue'=>(string)$avg,'reviewCount'=>(string)$count,'bestRating'=>'5','worstRating'=>'1');else unset($m['aggregateRating']);return $m;},20,2);
add_action('woocommerce_product_meta_end',function(){if(!is_product())return;$lang=navar_lang();$shipping='fa'===$lang?'باربری، حضوری یا راننده به سراسر کشور':navar_ui_text('shipping_details');printf('<div class="navar-shipping-info"><p><strong>%s:</strong> %s</p><p><strong>%s:</strong> <a href="%s" rel="nofollow">%s</a></p><p>%s</p><p>%s</p><p>%s</p></div>',esc_html(navar_ui_text('shipping')),esc_html($shipping),esc_html(navar_ui_text('returns')),esc_url(navar_localize_url(navar_return_policy_url($lang),$lang)),esc_html(navar_ui_text('view_rules')),esc_html(navar_ui_text('online_purchase')),esc_html(navar_ui_text('price_note')),esc_html(navar_ui_text('contact_note')));});

/** Keep WooCommerce product archives in the active content language. */
function navar_filter_woocommerce_products_by_language( $query ) {
    if ( is_admin() || ! $query instanceof WP_Query || ! function_exists('navar_language_product_query_args') ) return;
    $filter = navar_language_product_query_args();
    foreach ( array('meta_query','tax_query') as $query_key ) {
        if ( empty($filter[$query_key]) ) continue;
        $existing = $query->get($query_key);
        $query->set($query_key, $existing
            ? array('relation'=>'AND', $existing, $filter[$query_key])
            : $filter[$query_key]
        );
    }
}
add_action('woocommerce_product_query','navar_filter_woocommerce_products_by_language',30);
add_filter('woocommerce_product_tabs',function($t){if(isset($t['description']))$t['description']['title']=navar_ui_text('description');if(isset($t['additional_information']))$t['additional_information']['title']=navar_ui_text('additional_info');if(isset($t['reviews']))$t['reviews']['title']=navar_ui_text('reviews');return $t;},98);

/**
 * Cart recommendation grids use BlocksWpQuery, not woocommerce_product_query.
 * Apply the same authoritative catalog-language clauses to this scoped query.
 * This legacy Woo class checks its transient before pre_get_posts, so bypass
 * only cart-page product-grid transients; cart contents and page cache are untouched.
 */
function navar_filter_cart_block_products_by_language( $query ) {
    if ( is_admin() || ! function_exists('is_cart') || ! is_cart() ) return;
    if ( ! $query instanceof \Automattic\WooCommerce\Blocks\Utils\BlocksWpQuery ) return;
    if ( 'product' !== $query->get('post_type') || $query->get('navar_cart_language_filtered') ) return;
    navar_filter_woocommerce_products_by_language($query);
    $query->set('navar_cart_language_filtered', true);
}
add_action('pre_get_posts', 'navar_filter_cart_block_products_by_language', 30);

function navar_cart_product_grid_is_cacheable( $cacheable, $query_args ) {
    if ( ! is_admin() && function_exists('is_cart') && is_cart()
        && isset($query_args['post_type']) && 'product' === $query_args['post_type'] ) {
        return false;
    }
    return $cacheable;
}
add_filter('woocommerce_blocks_product_grid_is_cacheable', 'navar_cart_product_grid_is_cacheable', 30, 2);
