<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage London
 * @since London 1.0
 */
?>
                <?php
            	/**
            	 * @hooked 
                 * 
            	 */
            	do_action( 'theme_content_bottom' ); ?>
        	</div><!-- #content -->
        </div>
        <?php if(kt_option('footer', true)){ ?>
            <?php
        	/**
        	 * @hooked 
             * theme_after_footer_addscroll 10
             * 
        	 */
        	do_action( 'theme_before_footer' ); ?>
            <div id="footer">
                <?php if(is_active_sidebar( 'footer-top' ) && kt_option('footer_top', true)){ ?>
                    <footer id="footer-top">
                        <div class="container">
                            <?php dynamic_sidebar('footer-top') ?>
                        </div><!-- .container -->
                    </footer><!-- #footer-top -->
                <?php } ?>
                <?php
                    $layouts = explode('-', kt_option('footer_widgets_layout', '4-4-4'));
                    $sidebar_widgets = true;
                    foreach($layouts as $i => $layout){
                        if(is_active_sidebar($layout)){
                            $sidebar_widgets = false;
                            break;
                        }
                    }
                ?>
                <?php if(kt_option('footer_widgets', true) && $sidebar_widgets){ ?>
                    <footer id="footer-area">
                        <div id="footer-area-content">
                            <div class="container">
                                <div class="row">
                                    
                                    <?php foreach($layouts as $i => $layout){ ?>
                                        <div class="<?php echo esc_attr('col-md-'.$layout . ' col-sm-'.$layout.' col-xs-12'); ?>">
                                            <?php dynamic_sidebar('footer-column-'.($i+1)) ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div><!-- .container -->
                        </div><!-- #footer-area-content -->
                    </footer><!-- #footer-area -->
                <?php } ?>
                <?php if(kt_option('footer_bottom', true)){ ?>
                	<footer id="footer-bottom">
                        <div class="container">
                            <?php get_template_part( 'templates/footers/footer', kt_option('footer_bottom_layout', 'sides') ); ?>
                        </div><!-- .container -->
                	</footer><!-- #footer -->
                <?php } ?>
            </div>
            <?php
        	/**
        	 * @hooked 
        	 */
        	do_action( 'theme_after_footer' ); ?>
        <?php } ?>
    </div><!-- #page -->
</div><!-- #page_outter -->

<?php if(kt_option('backtotop', true)){ ?>
    <a id="backtotop" href="#top"></a>
<?php } ?>


<?php wp_footer(); ?>

</body>
</html>
