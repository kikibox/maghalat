<?php
namespace Automattic\WooCommerce\Blocks\Utils {class BlocksWpQuery extends \WP_Query {}}
namespace {
define('ABSPATH',__DIR__);$admin=false;$cart=true;$filters=[];$actions=[];
class WP_Query {public $vars=[];function __construct($v=[]){$this->vars=$v;}function get($k){return $this->vars[$k]??null;}function set($k,$v){$this->vars[$k]=$v;}}
function is_admin(){return $GLOBALS['admin'];}function is_cart(){return $GLOBALS['cart'];}
function add_filter(...$a){$GLOBALS['filters'][]=$a;}function add_action(...$a){$GLOBALS['actions'][]=$a;}
function navar_language_product_query_args(){return ['meta_query'=>[['key'=>'language','value'=>'fa']],'tax_query'=>[['taxonomy'=>'product_cat','operator'=>'NOT IN','terms'=>['ru']]]];}
require __DIR__.'/patched/woocommerce.php';
function check($v,$label){if(!$v)throw new \Exception($label);echo "PASS $label\n";}
$q=new \Automattic\WooCommerce\Blocks\Utils\BlocksWpQuery(['post_type'=>'product','meta_query'=>[['key'=>'price','compare'=>'>']],'tax_query'=>[['taxonomy'=>'product_visibility','operator'=>'NOT IN']]]);navar_filter_cart_block_products_by_language($q);check($q->get('navar_cart_language_filtered'),'cart Blocks query filtered');check($q->get('meta_query')[0][0]['key']==='price','existing price constraint preserved');check($q->get('tax_query')[0][0]['taxonomy']==='product_visibility','existing visibility preserved');$old=$q->vars;navar_filter_cart_block_products_by_language($q);check($old===$q->vars,'repeat filter idempotent');check(false===navar_cart_product_grid_is_cacheable(true,['post_type'=>'product']),'cart grid stale transient bypassed');check(true===navar_cart_product_grid_is_cacheable(true,['post_type'=>'post']),'non-product cache untouched');
$cart=false;$q=new \Automattic\WooCommerce\Blocks\Utils\BlocksWpQuery(['post_type'=>'product']);navar_filter_cart_block_products_by_language($q);check(!$q->get('navar_cart_language_filtered'),'non-cart untouched');check(true===navar_cart_product_grid_is_cacheable(true,['post_type'=>'product']),'non-cart cache untouched');$cart=true;$admin=true;check(true===navar_cart_product_grid_is_cacheable(true,['post_type'=>'product']),'admin cache untouched');$admin=false;$q=new WP_Query(['post_type'=>'product']);navar_filter_cart_block_products_by_language($q);check(!$q->get('navar_cart_language_filtered'),'non-Blocks query untouched');
}
