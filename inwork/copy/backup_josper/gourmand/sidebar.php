

<aside class="sidebar">
<!--
	<div class="product-selected-category">
		<?php //echo do_shortcode("[product_categories number='7' ids='9' parent='0']"); ?>
		<div class="sub-broducts" style="display: none;">
			<?php //echo do_shortcode("[product_category category='ugolnyie-pechi']"); ?>
		</div>
		<?php
		/**
		 * woocommerce_before_shop_loop hook
		 *
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		//do_action( 'woocommerce_before_shop_loop' );
		?>

		<?php //woocommerce_product_loop_start(); ?>

		<?php //woocommerce_product_subcategories(); ?>

		<?php //while ( have_posts() ) : the_post(); ?>
		<?php //wc_get_template_part( 'content', 'product' ); ?>

		<?php //endwhile; // end of the loop. ?>

	<?php //woocommerce_product_loop_end(); ?>
	</div>
-->

    <?php

	if(is_page() || is_archive() || is_single() ){
	?>

		<!-- Page Widgets Area -->
		<?php if ( !function_exists('dynamic_sidebar') || dynamic_sidebar('Page') ) { ?>

		<?php } else { ?>
		<!-- This content shows up if there are no widgets defined in the backend. -->
			<p>
				Here you can add widgets.
				<?php if(current_user_can('edit_theme_options')) : ?><br>
				<a href="<?php echo admin_url('widgets.php')?>" class="add-widget">Add Widget</a>
				<?php endif ?>
			</p>
		<?php
		}
		?>
	
    <?php
	} else {
	?>
    <!-- End Page Widgets Area -->

	<!-- Sidebar Widgets Area -->
    <?php if ( !function_exists('dynamic_sidebar') || dynamic_sidebar('Sidebar') ) { ?>
	<?php } else { ?>
    <!-- This content shows up if there are no widgets defined in the backend. -->
        <p>
            Here you can add widgets.
            <?php if(current_user_can('edit_theme_options')) : ?><br>
            <a href="<?php echo admin_url('widgets.php')?>" class="add-widget">Add Widget</a>
            <?php endif ?>
        </p>
    
    <!-- END Sidebar Widgets Area -->
	<?php
	}
	?>
	<?php
		}
		?>
</aside>
<!-- end aside -->