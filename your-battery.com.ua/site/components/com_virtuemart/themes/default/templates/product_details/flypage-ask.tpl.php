<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__);
 ?>

<?php echo $buttons_header // The PDF, Email and Print buttons ?>

<?php 
if( $this->get_cfg( 'showPathway' )) {
	echo "<div class=\"pathway\">$navigation_pathway</div>";
} 
if( $this->get_cfg( 'product_navigation', 1 )) {
	if( !empty( $previous_product )) {
		echo '<a class="previous_page" href="'.$previous_product_url.'">'.shopMakeHtmlSafe($previous_product['product_name']).'</a>';
	}
	if( !empty( $next_product )) {		
		echo '<a class="next_page" href="'.$next_product_url.'">'.shopMakeHtmlSafe($next_product['product_name']).'</a>';
	}
}
?>
<br style="clear:both;" />
<table border="0" align="center" style="width: 100%;" >
    <tr>
	    <td rowspan="1" colspan="2" align="center">
	        <div style="text-align: center;">
                <h1><?php echo $product_name; echo ' ' . $edit_link; ?></h1>
            </div>
        </td>
        <td>
        </td>
    </tr>
    <tr>
        <td>
	        <?php echo $product_s_desc ?>
	    </td>
    </tr>
    <tr>
	    <td colspan="2" style="border-bottom: 1px dotted #275087;"></td>
    </tr>
    <tr>
        <td align="left" valign="top" width="220">
            <div><?php echo $product_image ?></div>
        </td>
        <td valign="top">
            <div class="browseOthersContainer">        
                <?php echo $product_starting_capacity  ?> 
                <?php echo $product_lwh ?>
            </div>
            <div style="text-align: center;">
            <span style="font-style: italic;"></span><?php echo $addtocart ?><span style="font-style: italic;"></span></div>
        </td></tr>
        <tr>
  <td rowspan="1" colspan="2"><?php echo $manufacturer_link ?><br /></td>
</tr>
<tr>
      <td valign="top" align="left"><?php echo $product_price ?><br /></td>
</tr>
<tr>
      <td valign="top"><?php echo $product_packaging ?><br /></td>
</tr>
	<tr>
	  <td ><?php echo $ask_seller ?></td>
	</tr>
	<tr>
	    <td rowspan="1" colspan="2" style="border-bottom: 1px dotted #275087;">
            <?php echo $product_description ?>
	        <br/><span style="font-style: italic;"><?php echo $file_list ?></span>
        </td>
	</tr>
 
 <?php if ($related_products) { ?>
    <tr>
	    <td colspan="2" style="border-bottom: 1px dotted #275087;">
	    <?php  echo $related_products ?>
	    <br />
	    </td>
	</tr>
    <?php }?>
    
    <?php if ($navigation_childlist) { ?>
    <tr>
	    <td colspan="2" style="border-bottom: 1px dotted #275087;">
        <div style="text-align: center;">
                </div>
                <?php echo $navigation_childlist ?><br /></td>
	</tr>
    <?php }?>
    
	<tr>
	  <td colspan="2"><?php echo $product_reviewform ?><br /></td>
	</tr>
  <tr>
	  <td colspan="3"><div style="text-align: center;"><?php echo $vendor_link ?><br /></div><br /></td>
	</tr>
</table><br style="clear:both"/>
<div class="back_button"><a href='javascript:history.go(-1)'> <?php echo $VM_LANG->_('BACK') ?></a></div>
