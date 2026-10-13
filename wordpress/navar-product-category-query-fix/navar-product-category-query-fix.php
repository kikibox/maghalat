<?php
/**
 * Plugin Name: Navar Product Category Query Fix
 * Description: Avoids a redundant multi-category language clause on single translated product-category archives. Leaves Rank Math robots and canonical decisions untouched.
 * Version: 1.0.0
 * Requires PHP: 7.4
 * Author: Navar
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Navar_Product_Category_Query_Fix {
    public static function register() {
        if ( ! function_exists( 'navar_filter_woocommerce_products_by_language' ) ) { return; }
        $priority = has_action( 'woocommerce_product_query', 'navar_filter_woocommerce_products_by_language' );
        if ( false === $priority ) { return; }
        remove_action( 'woocommerce_product_query', 'navar_filter_woocommerce_products_by_language', $priority );
        add_action( 'woocommerce_product_query', array( __CLASS__, 'filter_query' ), $priority );
    }

    private static function redundant_language_clause( $query ) {
        if ( is_admin() || ! $query instanceof WP_Query || ! $query->is_main_query() || ! $query->is_tax( 'product_cat' ) ) { return false; }
        if ( ! function_exists( 'navar_lang' ) || ! function_exists( 'navar_product_catalog_language' ) || ! function_exists( 'navar_product_category_translation_blueprint' ) || ! function_exists( 'navar_language_product_query_args' ) ) { return false; }
        $term = $query->get_queried_object();
        if ( ! $term instanceof WP_Term || 'product_cat' !== $term->taxonomy ) { return false; }
        if ( empty( $query->tax_query ) || ! isset( $query->tax_query->queried_terms['product_cat']['terms'] ) || 1 !== count( $query->tax_query->queried_terms['product_cat']['terms'] ) ) { return false; }
        $lang = navar_product_catalog_language( navar_lang() );
        if ( ! in_array( $lang, array( 'iraq', 'tj', 'en', 'ru' ), true ) ) { return false; }
        $slugs = array();
        foreach ( (array) navar_product_category_translation_blueprint() as $translations ) {
            if ( ! empty( $translations[ $lang ]['slug'] ) ) { $slugs[] = (string) $translations[ $lang ]['slug']; }
        }
        $slugs = array_values( array_unique( $slugs ) );
        if ( ! in_array( (string) $term->slug, $slugs, true ) ) { return false; }
        // Do not broaden an archive whose category tree contains other-language terms.
        $children = get_term_children( $term->term_id, 'product_cat' );
        if ( is_wp_error( $children ) ) { return false; }
        foreach ( (array) $children as $id ) {
            $child = get_term( $id, 'product_cat' );
            if ( ! $child instanceof WP_Term || ! in_array( (string) $child->slug, $slugs, true ) ) { return false; }
        }
        // Only skip the known redundant clause; any new or additional filter is retained.
        $filter = navar_language_product_query_args( $lang );
        if ( ! is_array( $filter ) || array_diff( array_keys( $filter ), array( 'tax_query' ) ) || ! isset( $filter['tax_query'] ) || ! is_array( $filter['tax_query'] ) || 1 !== count( $filter['tax_query'] ) || ! isset( $filter['tax_query'][0] ) ) { return false; }
        $clause = $filter['tax_query'][0];
        if ( ! is_array( $clause ) || 'product_cat' !== ( $clause['taxonomy'] ?? '' ) || 'slug' !== ( $clause['field'] ?? '' ) || 'IN' !== strtoupper( (string) ( $clause['operator'] ?? 'IN' ) ) || empty( $clause['terms'] ) || ! is_array( $clause['terms'] ) ) { return false; }
        if ( array_diff( array_keys( $clause ), array( 'taxonomy', 'field', 'terms', 'operator', 'include_children' ) ) || isset( $clause['include_children'] ) && false === $clause['include_children'] ) { return false; }
        $actual = array_values( array_unique( $clause['terms'] ) );
        sort( $actual ); sort( $slugs );
        return $actual === $slugs;
    }

    public static function filter_query( $query ) {
        if ( self::redundant_language_clause( $query ) ) { return; }
        // The theme's original filtering is retained everywhere else.
        if ( function_exists( 'navar_filter_woocommerce_products_by_language' ) ) {
            navar_filter_woocommerce_products_by_language( $query );
        }
    }
}
add_action( 'after_setup_theme', array( 'Navar_Product_Category_Query_Fix', 'register' ), 100 );
