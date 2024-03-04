<?php
/**
 * Plugin name: WooCommerce Easy Duplicate Product
 * Author: WPGem.com
 * Plugin URI: http://wpgem.com/woo-easy-duplicate
 * Description: An easy and convenient way for you to duplicate a product.
 * Version: 0.3.0.8
 * Author: WPGem.com
 * Author URI: http://WPGem.com
 * 
**/


function wedp_show_the_duplicate_link ($post){
	
	$url = '<a target="_blank" href="' . wp_nonce_url( admin_url( 'edit.php?post_type=product&action=duplicate_product&amp;post=' . $post->ID ), 'woocommerce-duplicate-product_' . $post->ID ) . '" aria-label="' . esc_attr__( 'Make a duplicate from this product', 'woocommerce' )
			. '" rel="permalink">' . __( 'Duplicate once', 'woocommerce' ) . '</a>';


	$multi_box = file_get_contents(WP_PLUGIN_DIR . '/woo-easy-duplicate-product/multi-box.php');
 
	$meta_box = $url . $multi_box;

	echo '<script>
		var wedp_product_id = '. $post->ID .';

		var wedp_wp_nonce = "'.wp_create_nonce( 'wedp-duplicate-product-nonce' ).'";

	</script>';
	echo $meta_box;
}

function wedp_scripts(){
	wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'wedp_scripts');

function wedp_add_the_metabox($_post){
	
	global $post;	

	$post_type = $post->post_type;

	if('product' != $post_type){
		return ;//$_post;
	}

	add_meta_box( 'woocommerce-easy-product-duplicate', __( 'Duplicate this product', 'woocommerce' ), 'wedp_show_the_duplicate_link', 'product', 'side', 'high' );

	return $_post;
}

add_action( 'add_meta_boxes', 'wedp_add_the_metabox', 30 );


function wedb_duplicate_product_bulk_action($bulk_actions)
{	
	$bulk_actions['wedp_duplicate_product'] = 'Duplicate product';

	return $bulk_actions;

}

add_filter('bulk_actions-edit-product', 'wedb_duplicate_product_bulk_action');
add_filter('handle_bulk_actions-edit-product', 'wedb_handle_duplicate_product_bulk_action',10, 3);

function wedb_handle_duplicate_product_bulk_action($redirect_to, $doaction, $post_ids)
{	

	if($doaction != 'wedp_duplicate_product'){
		return $redirect_to;
	} 

	$duplicated = [];
	
	$WC_Duplicate = new WC_Admin_Duplicate_Product;
	foreach ($post_ids as $product_id) {
		
		$product = wc_get_product( $product_id );

		if($product){
		
			$duplicate = $WC_Duplicate->product_duplicate( $product );
			do_action( 'woocommerce_product_duplicate', $duplicate, $product );

			$duplicated[] = $product;
		}
	}

	$total_updated = count($duplicated);

	$redirect_to .= '&wedp_duplicated='.$total_updated;


	return $redirect_to;

}


function wedp_custom_bulk_admin_notices() {

  if(isset($_GET['wedp_duplicated'])){
;
  	$total_updated = $_GET['wedp_duplicated'];
  	$total_updated = preg_replace('/[^0-9]/', '', $total_updated); //Let's sanitize this

		if(!is_numeric($total_updated)){
			return;
		}

  	$message = "{$total_updated} products duplicated.";

  	echo  '<div class="updated"><p>'. $message .'</p></div>';
  }
}

add_action('admin_notices', 'wedp_custom_bulk_admin_notices');

function wedp_duplicate_product_admin_bar_button($admin_bar){
	global $pagenow;	
	global $post;

	if(!$post){
		return;
	}

	$post_type = $post->post_type;
	$action = (isset($_GET['action'])) ? $_GET['action'] : '';
	if( 'product' != $post_type ){

		return;
	}

	if($pagenow == 'post.php' && 'product' != $post_type && $action != 'edit'){
		
		return ;
	}

	if($pagenow == 'edit.php'){
		
		return ;
	}

	if( 'product' == $post_type && !is_single() || !is_page()){
		//return; //@todo it's not clear why we have this here.
	}
	$_is_single = is_single();
	$_is_page = is_page();
	//print_r(get_defined_vars()); die();


	$duplicate_url = wp_nonce_url( admin_url( 'edit.php?post_type=product&action=duplicate_product&amp;post=' . $post->ID ), 'woocommerce-duplicate-product_' . $post->ID );

	$admin_bar_button_array = [

		'id' => 'wedp_admin_bar_button',
		'title' => 'Duplicate this product',
		'href' => $duplicate_url,
		'meta' => [
			
			'target' => '_blank',

		]
	];


	$speed_up_site_button_array =  [

		'id' => 'wpgem_speed_up_site_button',
		'title' => 'Want help?',
		'href' => 'https://bit.ly/jeanpaul-linkedin',
		'meta' => [

			'target' => '_blank'

		]

	];
	$admin_bar->add_menu($admin_bar_button_array);
	//$admin_bar->add_menu($speed_up_site_button_array);


}

add_action('admin_bar_menu', 'wedp_duplicate_product_admin_bar_button', 110);

function wpgem_useful_info_box(){
	include WP_PLUGIN_DIR . '/woo-easy-duplicate-product/info-box.php';
}

function wpgem_add_useful_info_box(){

	wp_add_dashboard_widget('wpgem-useful-info-box', 'Is your site too slow?', 'wpgem_useful_info_box', 'normal', 'high');

}

add_action('wp_dashboard_setup', 'wpgem_add_useful_info_box');

//Let's add admin-ajax to handle the multiple duplications.

add_action('wp_ajax_wedp_duplicate_product', 'wedp_duplicate_product_action');

function wedp_duplicate_product_action(){

	if(isset($_POST['wedp_multiple_product_duplicate'])){
		//Let's verify our nonce
		$nonce = $_REQUEST['_wp_nonce'];
		if(! wp_verify_nonce($nonce, 'wedp-duplicate-product-nonce')){
			die("Why oh why you dat? Why?");
		}
		$product_id = $_POST['product_id'];
		$multiple_products_number = $_POST['multiple_products_number'];

		for($i=0; $i<$multiple_products_number; $i++){

				// We will duplicate each product here.
			
		$WC_Duplicate = new WC_Admin_Duplicate_Product;
				
				$product = wc_get_product( $product_id ); 

				if($product){
					
					//Let's see if we can add some kind of identifier to the product name.


					$duplicate = $WC_Duplicate->product_duplicate( $product );
					do_action( 'woocommerce_product_duplicate', $duplicate, $product );

					$duplicated[] = $product;
		}
	

			$total_updated = count($duplicated);

		}

		if ($total_updated >= 2) {
			$status = 'success';
		} else {
			$status = 'error';
		}

		$message = [

			'status' => $status,
			'total_updated' => $total_updated

		];

		print_r(json_encode($message));


	} else {

		echo "Why you do me dat?";
	}

	die();
}
