<?php global $product; ?>
<li class="clearfix">
    <div class="product-thumbnail">
    	<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
    		<?php echo $product->get_image(); ?>
    		<span class="product-title"><?php echo $product->get_title(); ?></span>
    	</a>
    </div>
    <div class="product-information">
    	<?php if ( ! empty( $show_rating ) ) echo $product->get_rating_html(); ?>
    	<?php echo $product->get_price_html(); ?>
    </div>
</li>