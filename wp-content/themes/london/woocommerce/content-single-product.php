<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class('product-detail-wrapper'); ?>>
    
    <div class="product-detail-content">
        <div class="row product-detail-inner">
            <div class="<?php echo apply_filters('woocommerce_single_product_thumb_area', 'col-xs-12 col-sm-5 col-md-5'); ?>">
                <div class="product-detail-thumbarea">
                	<?php
                		/**
                		 * woocommerce_before_single_product_summary hook
                		 *
                		 * @hooked woocommerce_show_product_sale_flash - 10
                		 * @hooked woocommerce_show_product_images - 20
                		 */
                		do_action( 'woocommerce_before_single_product_summary' );
                	?>
                </div>
            </div>
            <div class="<?php echo apply_filters('woocommerce_single_product_summary_area', 'col-xs-12 col-sm-7 col-md-7'); ?>">
            	<div class="summary entry-summary">
            		<?php
            			/**
            			 * woocommerce_single_product_summary hook
            			 *
            			 * @hooked woocommerce_template_single_title - 5
            			 * @hooked woocommerce_template_single_rating - 10
            			 * @hooked woocommerce_template_single_price - 10
            			 * @hooked woocommerce_template_single_excerpt - 20
            			 * @hooked woocommerce_template_single_add_to_cart - 30
            			 * @hooked woocommerce_template_single_meta - 40
            			 * @hooked woocommerce_template_single_sharing - 50
            			 */
            			do_action( 'woocommerce_single_product_summary' );
            		?>
            
            	</div><!-- .summary -->
             </div>
        </div><!--.row-->
        
        <?php
    		/**
    		 * woocommerce_after_single_product_content hook
    		 *
    		 * @hooked woocommerce_output_product_data_tabs - 10
    		 */
    		do_action( 'woocommerce_after_single_product_content' );
    	?>
        
    </div><!-- .product-detail-content -->
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_upsell_display - 15
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
