<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__);
 ?>
 <div class="browseProductContainer">
        
        
        <div class="browseProductTitle"><a title="<?php echo $product_name ?>" href="<?php echo $product_flypage ?>">
            <?php echo $product_name ?></a><br />
            
        <div class="browsePriceContainer">
            <?php echo $product_price ?>
        </div>
        
        </div>
        
        <div class="browseProductImageContainer">
	        <script type="text/javascript">//<![CDATA[
	        document.write('<a href="javascript:void window.open(\'<?php echo $product_full_image ?>\', \'win2\', \'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=<?php echo $full_image_width ?>,height=<?php echo $full_image_height ?>,directories=no,location=no\');">');
	        document.write( '<?php echo ps_product::image_tag( $product_thumb_image, 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' ) ?></a>' );
	        //]]>
	        </script>
	        <noscript>
	            <a href="<?php echo $product_full_image ?>" target="_blank" title="<?php echo $product_name ?>">
	            <?php echo ps_product::image_tag( $product_thumb_image, 'class="browseProductImage" border="0" title="'.$product_name.'" alt="'.$product_name .'"' ) ?>
	            </a>
	        </noscript>
        </div>
        
        <div class="browseRatingContainer">
        <?php echo $product_rating ?>
            <div class="browseOthersContainer">
                <?php echo $ps_voltage; ?>         
                <?php echo $product_starting_capacity;  ?> 
                <?php echo $product_lwh; ?>
            </div>
        </div>
            <div style="clear: both;"></div>
        <div class="browseProductDescription">         
            <?php echo $orientir ?> <br /> 
            <?php echo $product_s_desc ?>
        </div>
        <div style="text-align: right;">
            <a style="text-decoration: none;" href="<?php echo $product_flypage ?>" title="<?php echo $product_details ?>"><br />
            <img src="components/com_virtuemart/themes/default/images/icon-16-search_.png"/> <?php echo $product_details ?>...</a>
            <br />
        </div>
        <span class="browseAddToCartContainer">
        <?php echo $form_addtocart ?>
        </span>

</div>
