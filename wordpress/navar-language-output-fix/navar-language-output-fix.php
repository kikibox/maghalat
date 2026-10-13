<?php
/**
 * Plugin Name: Navar Language Output Fix
 * Description: Localizes the current article's featured-image alt and removes redundant language parameters from verified translated menu destinations. Does not change robots or canonical rules.
 * Version: 1.0.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Author: Navar
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

final class Navar_Language_Output_Fix {
    public static function init() {
        add_filter( 'post_thumbnail_html', array( __CLASS__, 'featured_alt' ), 100, 5 );
        add_filter( 'wp_nav_menu_objects', array( __CLASS__, 'clean_menu' ), 100, 2 );
    }

    private static function language( $raw ) {
        $map = array(
            'fa'=>'fa', 'fa-ir'=>'fa', 'iran'=>'fa',
            'iraq'=>'ar', 'iq'=>'ar', 'ar'=>'ar', 'ar-iq'=>'ar',
            'tj'=>'tg', 'tg'=>'tg', 'tg-tj'=>'tg', 'tajik'=>'tg',
            'en'=>'en', 'en-us'=>'en', 'english'=>'en',
            'ru'=>'ru', 'ru-ru'=>'ru', 'russian'=>'ru',
        );
        if ( ! is_scalar( $raw ) ) { return ''; }
        $key = strtolower( trim( (string) $raw ) );
        return isset( $map[ $key ] ) ? $map[ $key ] : '';
    }

    public static function featured_alt( $markup, $post_id, $thumbnail_id, $size, $attr ) {
        if ( is_admin() || ! is_singular( 'post' ) || (int) $post_id !== (int) get_queried_object_id() ) {
            return $markup;
        }
        if ( ! class_exists( 'WP_HTML_Tag_Processor' ) || ! is_string( $markup ) || '' === $markup ) {
            return $markup;
        }
        $lang = self::language( get_post_meta( $post_id, '_navar_translation_language', true ) );
        $labels = array( 'ar'=>'نظرة عامة', 'tg'=>'Намуди умумӣ', 'en'=>'Overview', 'ru'=>'Общий вид' );
        if ( ! isset( $labels[ $lang ] ) ) { return $markup; }
        $title = trim( wp_strip_all_tags( get_the_title( $post_id ) ) );
        if ( '' === $title ) { return $markup; }
        $processor = new WP_HTML_Tag_Processor( $markup );
        if ( ! $processor->next_tag( array( 'tag_name'=>'IMG' ) ) ) { return $markup; }
        $processor->set_attribute( 'alt', $title . ' - ' . $labels[ $lang ] );
        return $processor->get_updated_html();
    }

    public static function clean_menu( $items, $args ) {
        if ( is_admin() || ! is_array( $items ) ) { return $items; }
        $home_host = strtolower( (string) wp_parse_url( home_url( '/' ), PHP_URL_HOST ) );
        foreach ( $items as $item ) {
            if ( ! is_object( $item ) || empty( $item->url ) || ! is_string( $item->url ) ) { continue; }
            $parts = wp_parse_url( $item->url );
            if ( ! is_array( $parts ) || empty( $parts['query'] ) ) { continue; }
            if ( isset( $parts['scheme'] ) && ! in_array( strtolower( $parts['scheme'] ), array( 'http', 'https' ), true ) ) { continue; }
            if ( ! empty( $parts['host'] ) && strtolower( $parts['host'] ) !== $home_host ) { continue; }
            $params = array();
            parse_str( $parts['query'], $params );
            if ( ! isset( $params['navar_lang'] ) || isset( $params['lang'] ) ) { continue; }
            $requested = self::language( $params['navar_lang'] );
            if ( '' === $requested ) { continue; }
            $clean = remove_query_arg( 'navar_lang', $item->url );
            // Resolve only a clean local URL; never alter shared shop/cart/account destinations.
            $lookup = remove_query_arg( array_keys( $params ), $item->url );
            $lookup = preg_replace( '/#.*$/', '', $lookup );
            if ( empty( $parts['host'] ) ) {
                if ( 0 !== strpos( $lookup, '/' ) ) { continue; }
                $lookup = home_url( $lookup );
            }
            $post_id = (int) url_to_postid( $lookup );
            if ( ! $post_id || 'publish' !== get_post_status( $post_id ) ) { continue; }
            $own = self::language( get_post_meta( $post_id, '_navar_translation_language', true ) );
            if ( '' !== $own && $own === $requested ) {
                $item->url = $clean;
            }
        }
        return $items;
    }
}
Navar_Language_Output_Fix::init();
