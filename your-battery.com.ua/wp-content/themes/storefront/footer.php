<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="footer" role="contentinfo">
		<div class="container-footer">
			<div class="footer-top">
				<div class="footer-colum">
					<div class="nav-footer">
						<?php if (!dynamic_sidebar("footer-1") ) : ?>
						<?php endif; ?>
					</div>
					<div class="logo-footer">
						<?php
						/**
						 * Functions hooked into storefront_header action
						 * @hooked storefront_social_icons                     - 10
						 * @hooked storefront_site_branding                    - 20
						 * @hooked storefront_secondary_navigation             - 30
						 * @hooked storefront_product_search                   - 40
						 * @hooked storefront_primary_navigation_wrapper       - 42
						 * @hooked storefront_primary_navigation               - 50
						 * @hooked storefront_header_cart                      - 60
						 * @hooked storefront_primary_navigation_wrapper_close - 68
						 */
						do_action( 'storefront_header' ); ?>
					</div>
				</div>
				<div class="footer-colum col-xs-6">
					<div class="footer-phone">
						<?php if (!dynamic_sidebar("footer-2") ) : ?>
						<?php endif; ?>
					</div>
				</div>
				<div class="footer-colum col-xs-6">
					<div class="footer-text">
						<div class="widget">
							<?php if (!dynamic_sidebar("address-header-widget") ) : ?>
							<?php endif; ?>
						</div>
						<div class="widget">
							<?php if (!dynamic_sidebar("mail-header-widget") ) : ?>
							<?php endif; ?>
						</div>
						<div class="widget">
							<span class="address-text">Бесплатная доставка по городу!</span>
						</div>
					</div>
				</div>
			</div>
<!--			--><?php
//			/**
//			 * Functions hooked in to storefront_footer action
//			 *
//			 * @hooked storefront_footer_widgets - 10
//			 * @hooked storefront_credit         - 20
//			 */
//			do_action( 'storefront_footer' ); ?>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->
<div class="footer-bottom">
	<p class="copyright">© 2012 - 2017, Центр Аккумуляторов.</p>
</div>
	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->
<script>
	jQuery(document).ready(function(){
//		jQuery(".page-product .storefront-sorting")[1].remove();
		jQuery(".woocommerce-tabs .tabs li").on('click', function () {
			jQuery(".woocommerce-tabs .tabs li").removeClass("active");
			jQuery(this).addClass("active");
		});
	});
</script>
<?php wp_footer(); ?>

</body>
</html>
