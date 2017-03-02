<?php
//no direct access
defined('_JEXEC') or die('Restricted access');

$categories   = $this->categories;
$manufacturer = $this->manufacturer;
$vendor       = $this->vendor;

?>

<style type="text/css">
.csv{width:100%}
.col1{width:15%;text-align:right}
.col2{width:15%;text-align:center}
.col3{width:15%;text-align:left}
.col4{width:15%;text-align:center}
.col5{width:40%;text-align:left}
.categories{display:none}
.divider{font-family:Georgia}
</style>
<script type="text/javascript">
window.addEvent('domready',function(){
    $$('input[type=checkbox]').addEvent('click',function(){
        var curtext = this.getParent().getParent().getElements('input[type=text]');
        var ftext = $('ftext').getElements('input[type=text]');
        var sum = ftext.length;
        var max = 1;
        for(var i=0;i<sum;i++){
            if(ftext[i].value >= max){
                max = parseInt(ftext[i].value) + 1;
            }
        }
        if(this.getProperty('checked')){
            curtext.setProperty('value',max);
            curtext.setProperty('disabled',false);
        }else{
            curtext.setProperty('value','');
            curtext.setProperty('disabled',true);
        }
    });
    $$('input[type=radio]').addEvent('click',function(){
        if(this.getProperty('value') == 'export'){
            $$('input[type=file]').setProperty('disabled',true);
        }else{
            $$('input[type=file]').setProperty('disabled',false);
        }
    });
});
</script>
<?php if(isset($this->debug)): ?>
    <style type="text/css">
        #debug{width:1500px;margin-bottom:40px;max-width:100%;}
        #debug td{border:1px solid #DDD}
        #debug .c{text-align:center}
        .ldebug{color:maroon;font-weight:bold;margin-top:20px;margin-bottom:5px;font-size:12px;text-decoration:underline}
    </style>
    <?php $products = $this->debug; ?>
    <div class="ldebug"><?php echo JText::_('LAST IMPORT RESULTS'); ?></div>
    <table id="debug">
    <tr>
        <th><?php echo JText::_('PRODUCT ID'); ?></th>
        <th><?php echo JText::_('CATEGORY ID'); ?></th>        
        <th><?php echo JText::_('PRODUCT SKU'); ?></th>
        <th><?php echo JText::_('PRODUCT NAME'); ?></th>
        
        <th><?php echo JText::_('PRODUCT CAPACITY'); ?></th>
        <th><?php echo JText::_('PRODUCT STARTING'); ?></th>
        <th><?php echo JText::_('PRODUCT VOLTAGE'); ?></th>
        
        <th><?php echo JText::_('PRODUCT REZ IMAGE'); ?></th>
        <th><?php echo JText::_('PRODUCT FULL IMAGE'); ?></th>
        
        <th><?php echo JText::_('PRODUCT PRICE'); ?></th>
        <th><?php echo JText::_('PRODUCT CURRENCY'); ?></th>
        <th><?php echo JText::_('PRODUCT SDESC'); ?></th>
        <th><?php echo JText::_('PRODUCT DESC'); ?></th>
        <th><?php echo JText::_('PRODUCT WEIGHT'); ?></th>
        <th><?php echo JText::_('PRODUCT WEIGHT UOM'); ?></th>
        <th><?php echo JText::_('PRODUCT LENGTH'); ?></th>
        <th><?php echo JText::_('PRODUCT WIDTH'); ?></th>
        <th><?php echo JText::_('PRODUCT HEIGHT'); ?></th>
        <th><?php echo JText::_('PRODUCT LWH UOM'); ?></th>
        <th><?php echo JText::_('PRODUCT PUBLISH'); ?></th>
        <th><?php echo JText::_('VENDOR ID'); ?></th>
        <th><?php echo JText::_('MANUFACTURER ID'); ?></th>
    </tr>
    <?php for($i=0,$sum=count($products);$i<$sum;$i++): ?>
    <?php $product = $products[$i]; ?>
    <tr>
        <td class="c"><?php echo $product->product_id ?></td>
        <td class="c"><?php echo $product->category_id ?></td>
        <td class="c"><?php echo $product->product_sku ?></td>
        <td><?php echo strip_tags(JString::substr($product->product_name,0,10)),'...' ?></td>
        
        <td class="c"><?php echo $product->product_capacity ?></td>
        <td class="c"><?php echo $product->product_starting ?></td>
        <td class="c"><?php echo $product->product_voltage ?></td>        
        <td class="c"><?php echo $product->product_thumb_image ?></td>
        <td class="c"><?php echo $product->product_full_image ?></td>   
        
        <td class="c"><?php echo $product->product_price ?></td>
        <td class="c"><?php echo $product->product_currency ?></td>
        <td><?php echo strip_tags(JString::substr($product->product_s_desc,0,10)),'...' ?></td>
        <td><?php echo strip_tags(JString::substr($product->product_desc,0,10)),'...' ?></td>
        <td class="c"><?php echo $product->product_weight ?></td>
        <td class="c"><?php echo $product->product_weight_uom ?></td>
        <td class="c"><?php echo $product->product_length ?></td>
        <td class="c"><?php echo $product->product_width ?></td>
        <td class="c"><?php echo $product->product_height ?></td>
        <td class="c"><?php echo $product->product_lwh_uom ?></td>
        <td class="c"><?php echo $product->product_publish ?></td>
        <td class="c"><?php echo $product->vendor_id ?></td>
        <td class="c"><?php echo $product->manufacturer_id ?></td>
    </tr>
    <?php endfor; ?>
    </table>
<?php endif; ?>
<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <fieldset>
    <legend><?php echo JText::_('MODE'); ?></legend>
        <div>
            <input type="radio" checked="checked" name="mode" value="import" /> <?php echo JText::_('IMPORT'); ?>
            <input type="radio" name="mode" value="export" /> <?php echo JText::_('EXPORT'); ?>
        </div>
    </fieldset>
    <fieldset>
    <legend><?php echo JText::_('DIVIDERS'); ?></legend>
        <table>
        <tr>
            <td width="150px" align="right"><?php echo JText::_('DIVIDER FIELD'); ?></td>
            <td align="left">
                <select name="divider_field" class="divider">
                    <option value="comma">,</option>
                    <option value="colon">:</option>
                    <option value="semicolon">;</option>
                    <option value="space">{<?php echo JText::_('SPACE'); ?>}</option>
                </select>
            </td>
        </tr>
        <tr>
            <td align="right"><?php echo JText::_('DIVIDER TEXT'); ?></td>
            <td align="left">
                <select name="divider_text" class="divider">
                    <option value="none"></option>
                    <option value="apos">'</option>
                    <option value="quote">"</option>
                </select>
            </td>
        </tr>
        </table>
    </fieldset>
    <fieldset id="ftext">
    <legend><?php echo JText::_('ORDER OF FIELDS'); ?></legend>
        <table class="csv">
        <tr>
            <th class="col1"><?php echo JText::_('NAME'); ?></th>
            <th class="col2"><?php echo JText::_('SELECT'); ?></th>
            <th class="col3"><?php echo JText::_('DB FIELD'); ?></th>
            <th class="col4">№</th>
            <th class="col5"><?php echo JText::_('ADD INFO'); ?></th>
        </tr>
        <tr>
            <td class="col1"><label for="category_id"><?php echo JText::_('CATEGORY ID'); ?></label></td>
            <td class="col2"><input type="checkbox" id="category_id" name="category_id" /></td>
            <td class="col3">category_id</td>
            <td class="col4"><input type="text" name="category_id_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5">
                <?php echo JText::_('MUST FIELD'); ?>
                <select>
                    <?php for($i=0,$sum=count($categories);$i<$sum;$i++): ?>
                    <option value=""><?php echo $categories[$i]->category_name,' - id',$categories[$i]->category_id; ?></option>
                    <?php endfor; ?>
                </select>
            </td>
        </tr> 
        
        <tr>
            <td class="col1"><label for="product_sku"><?php echo JText::_('PRODUCT SKU'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_sku" /></td>
            <td class="col3">product_sku</td>
            <td class="col4"><input type="text" name="product_sku_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('MUST FIELD'); ?>. <?php echo JText::_('SHOULD BE UNIQUE') ?></td>
        </tr>
            
        <tr>
            <td class="col1"><label for="product_name"><?php echo JText::_('PRODUCT NAME'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_name" /></td>
            <td class="col3">product_name</td>
            <td class="col4"><input type="text" name="product_name_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('MUST FIELD'); ?></td>
        </tr>
        
        <tr>
            <td class="col1"><label for="product_price"><?php echo JText::_('PRODUCT PRICE'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_price" /></td>
            <td class="col3">product_price</td>
            <td class="col4"><input type="text" name="product_price_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        
        <tr>
            <td class="col1"><label for="product_voltage"><?php echo JText::_('PRODUCT VOLTAGE'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_voltage" /></td>
            <td class="col3">product_voltage</td>
            <td class="col4"><input type="text" name="product_voltage_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>  
        
        <tr>
            <td class="col1"><label for="product_capacity"><?php echo JText::_('PRODUCT CAPACITY'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_capacity" /></td>
            <td class="col3">product_capacity</td>
            <td class="col4"><input type="text" name="product_capacity_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        
            <tr>
            <td class="col1"><label for="product_starting"><?php echo JText::_('PRODUCT STARTING'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_starting" /></td>
            <td class="col3">product_starting</td>
            <td class="col4"><input type="text" name="product_starting_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>    
        
 
             <tr>
            <td class="col1"><label for="product_thumb_image"><?php echo JText::_('PRODUCT REZ IMAGE'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_thumb_image" /></td>
            <td class="col3">product_thumb_image</td>
            <td class="col4"><input type="text" name="product_thumb_image_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>   
 
 
              <tr>
            <td class="col1"><label for="product_full_image"><?php echo JText::_('PRODUCT FULL IMAGE'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_full_image" /></td>
            <td class="col3">product_full_image</td>
            <td class="col4"><input type="text" name="product_full_image_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>   
 
 

        <tr>
            <td class="col1"><label for="product_publish"><?php echo JText::_('PRODUCT PUBLISH'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_publish" /></td>
            <td class="col3">product_publish</td>
            <td class="col4"><input type="text" name="product_publish_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT PUBLISHED'); ?> <strong>Y</strong>(N)</td>
        </tr>

        <tr>
            <td class="col1"><label for="product_currency"><?php echo JText::_('PRODUCT CURRENCY'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_currency" /></td>
            <td class="col3">product_currency</td>
            <td class="col4"><input type="text" name="product_currency_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT'); ?> <strong>USD</strong></td>
        </tr>
        <tr>
            <td class="col1"><label for="product_s_desc"><?php echo JText::_('PRODUCT SDESC'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_s_desc" /></td>
            <td class="col3">product_s_desc</td>
            <td class="col4"><input type="text" name="product_s_desc_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        <tr>
            <td class="col1"><label for="product_desc"><?php echo JText::_('PRODUCT DESC'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_desc" /></td>
            <td class="col3">product_desc</td>
            <td class="col4"><input type="text" name="product_desc_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        <tr>
            <td class="col1"><label for="manufacturer_id"><?php echo JText::_('MANUFACTURER ID'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="manufacturer_id" /></td>
            <td class="col3">manufacturer_id</td>
            <td class="col4"><input type="text" name="manufacturer_id_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT'); ?> <strong><?php echo $manufacturer->mf_name; ?></strong> - id<?php echo $manufacturer->manufacturer_id; ?></td>
        </tr>
        <tr>
            <td class="col1"><label for="vendor_id"><?php echo JText::_('VENDOR ID'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="vendor_id" /></td>
            <td class="col3">vendor_id</td>
            <td class="col4"><input type="text" name="vendor_id_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT'); ?> <strong><?php echo $vendor->vendor_name; ?></strong> - id<?php echo $vendor->vendor_id; ?></td>
        </tr>
        <tr>
            <td class="col1"><label for="product_weight"><?php echo JText::_('PRODUCT WEIGHT'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_weight" /></td>
            <td class="col3">product_weight</td>
            <td class="col4"><input type="text" name="product_weight_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        <tr>
            <td class="col1"><label for="product_weight_uom"><?php echo JText::_('PRODUCT WEIGHT UOM'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_weight_uom" /></td>
            <td class="col3">product_weight_uom</td>
            <td class="col4"><input type="text" name="product_weight_uom_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        <tr>
            <td class="col1"><label for="product_length"><?php echo JText::_('PRODUCT LENGTH'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_length" /></td>
            <td class="col3">product_length</td>
            <td class="col4"><input type="text" name="product_length_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        <tr>
            <td class="col1"><label for="product_width"><?php echo JText::_('PRODUCT WIDTH'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_width" /></td>
            <td class="col3">product_width</td>
            <td class="col4"><input type="text" name="product_width_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        <tr>
            <td class="col1"><label for="product_height"><?php echo JText::_('PRODUCT HEIGHT'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_height" /></td>
            <td class="col3">product_height</td>
            <td class="col4"><input type="text" name="product_height_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        <tr>
            <td class="col1"><label for="product_lwh_uom"><?php echo JText::_('PRODUCT LWH UOM'); ?></label></td>
	    <td class="col2"><input type="checkbox" name="product_lwh_uom" /></td>
            <td class="col3">product_lwh_uom</td>
            <td class="col4"><input type="text" name="product_lwh_uom_order" disabled="disabled" value="" size="3" /></td>
            <td class="col5"><?php echo JText::_('BY DEFAULT NOT FILLED'); ?></td>
        </tr>
        </table>
    </fieldset>
    <fieldset>
    <legend>CSV</legend>
        <table>
        <tr>
            <td><input type="file" name="csv" value="" /></td>
            <td>.csv, .txt</td>
        </tr>
        </table>       
    </fieldset>
    <input type="hidden" name="option" value="com_simplecsv" />
    <input type="hidden" name="task" value="load" />
</form>