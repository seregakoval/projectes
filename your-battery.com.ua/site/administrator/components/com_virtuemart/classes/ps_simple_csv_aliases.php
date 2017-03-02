<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$modules = array (
	'��������� ��������������' => 'manufacturer_category',
	'�������������' => 'manufacturer',
	'��������� �������' => 'category',
	'���� �������' => 'product_type',
	'���������' => 'product_type_parameter',
	'������ �����������' => 'shopper_group',
	'������' => 'product',
);

###################################################################################################

// #__{vm}_manufacturer_category 
// mf_category_id mf_category_name mf_category_desc
$manufacturer_category_fields = array (
	'�' => 'mf_category_id',
	'������������' => 'mf_category_name',
	'��������' => 'mf_category_desc',
);

// #__{vm}_manufacturer
// manufacturer_id mf_name mf_email mf_desc mf_category_id mf_url
$manufacturer_fields = array (
	'�' => 'manufacturer_id',
	'������������ �������������' => 'mf_name',
	'Email' => 'mf_email',
  '������' => 'mf_desc',
	'��������' => 'mf_desc',
	'���������' => 'mf_category_id',
	'���� ��������' => 'mf_url',
);

// #__{vm}_category
// category_id vendor_id category_name category_description category_thumb_image category_full_image category_publish cdate mdate category_browsepage products_per_row category_flypage list_order parent_category_id
$category_fields = array (
	'�' => 'category_id',
	'��������' => 'vendor_id',
	'������������' => 'category_name',
	'��������' => 'category_description',
	'����� ��������� ��������' => 'category_thumb_image',
	'����� ������ ��������' => 'category_full_image',
	'������������' => 'category_publish',
	'������ ��� ��������' => 'category_browsepage',
	'������� � ������' => 'products_per_row',
	'������ ��� ������' => 'category_flypage',
	'����� �� �������' => 'list_order',
	'������������ ���������' => 'parent_category_id',
);

// #__{vm}_product_type
// product_type_id product_type_name product_type_description product_type_publish product_type_browsepage product_type_flypage  product_type_list_order
$product_type_fields = array (
	'�' => 'product_type_id',
	'������������' => 'product_type_name',
	'��������' => 'product_type_description',
	'�����������' => 'product_type_publish',
	'������ ��� ��������' => 'product_type_browsepage',
	'������ ��� ������' => 'product_type_flypage',
	'����� �� �������' => 'product_type_list_order',
);

// #__{vm}_product_type_parameter
// product_type_id parameter_name parameter_label parameter_description parameter_list_order parameter_type parameter_values parameter_multiselect parameter_default parameter_unit
$product_type_parameter_fields = array (
	'����� ����' => 'product_type_id',
  '���' => 'product_type_name',
	'������������ � ����' => 'parameter_name',
	'������������' => 'parameter_label',
	'��������' => 'parameter_description',
	'����� �� �������' => 'parameter_list_order',
	'��� ���������' => 'parameter_type',
	'��������� ��������' => 'parameter_values',
	'��������� ��������' => 'parameter_multiselect',
	'�������� �� ���������' => 'parameter_default',
	'������� ���������' => 'parameter_unit',
);   

//
//  product_id vendor_id product_parent_id product_sku product_s_desc product_desc product_thumb_image product_full_image product_publish product_weight product_weight_uom product_length product_width product_height product_lwh_uom product_url product_in_stock product_available_date product_availability   	  product_special product_discount_id ship_code_id cdate mdate product_name product_sales attribute custom_attribute product_tax_id product_unit product_packaging
$product_fields = array (
	'�' => 'product_id',
	'������������� ��������' => 'vendor_id',
	'������������� ������������� ������' => 'product_parent_id',
	'�������' => 'product_sku',
	'������� ��������' => 'product_s_desc',
  '������ ��������' => 'product_desc',
	'��������� �����������' => 'product_thumb_image',
	'������� �����������' => 'product_full_image',
	'�����������' => 'product_publish',
	'��� �������' => 'product_weight',
	'������� ��������� ����' => 'product_weight_uom',
	'�����' => 'product_length',
	'������' => 'product_width',
	'������' => 'product_height',
	'������� ��������� ��������' => 'product_lwh_uom',
	'url' => 'product_url',
	'���������� � �������' => 'product_in_stock',
	'product_available_date' => 'product_available_date',
	'��������' => 'product_availability',
	'������������� ������' => 'product_discount_id',
	'ship_code_id' => 'ship_code_id',
	'cdate' => 'cdate',
	'mdate' => 'mdate',
	'������������ ������' => 'product_name',
	'����� ������' => 'product_sales',
	'�������' => 'attribute',
	'������� ������������ ����' => 'custom_attribute',
	'������������� ������' => 'product_tax_id',
	'product_unit' => 'product_unit',
	'product_packaging' => 'product_packaging',
  '������������� ���������' => 'category_id',
  '���� �� ������������ ��������� ������' => 'category_path',
  '���� ������' => 'product_price',
  
);

$product_dynamic_fields = array (
	//'/���� ��� (.+)/' => 'product_prices|shopper_group_name',
	'/(.+);(.+)/' => 'product_types|product_type_name|product_parameter_name',
);

?>
