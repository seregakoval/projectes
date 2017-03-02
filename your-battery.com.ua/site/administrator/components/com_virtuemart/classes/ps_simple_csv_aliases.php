<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

$modules = array (
	'Категории производителей' => 'manufacturer_category',
	'Производители' => 'manufacturer',
	'Категории товаров' => 'category',
	'Типы товаров' => 'product_type',
	'Параметры' => 'product_type_parameter',
	'Группы покупателей' => 'shopper_group',
	'Товары' => 'product',
);

###################################################################################################

// #__{vm}_manufacturer_category 
// mf_category_id mf_category_name mf_category_desc
$manufacturer_category_fields = array (
	'№' => 'mf_category_id',
	'Наименование' => 'mf_category_name',
	'Описание' => 'mf_category_desc',
);

// #__{vm}_manufacturer
// manufacturer_id mf_name mf_email mf_desc mf_category_id mf_url
$manufacturer_fields = array (
	'№' => 'manufacturer_id',
	'Наименование производителя' => 'mf_name',
	'Email' => 'mf_email',
  'Страна' => 'mf_desc',
	'Описание' => 'mf_desc',
	'Категория' => 'mf_category_id',
	'Сайт компании' => 'mf_url',
);

// #__{vm}_category
// category_id vendor_id category_name category_description category_thumb_image category_full_image category_publish cdate mdate category_browsepage products_per_row category_flypage list_order parent_category_id
$category_fields = array (
	'№' => 'category_id',
	'Продавец' => 'vendor_id',
	'Наименование' => 'category_name',
	'Описание' => 'category_description',
	'Адрес маленькой картинки' => 'category_thumb_image',
	'Адрес полной картинки' => 'category_full_image',
	'Опубликована' => 'category_publish',
	'Шаблон для каталога' => 'category_browsepage',
	'Товаров в строке' => 'products_per_row',
	'Шаблон для товара' => 'category_flypage',
	'Номер по порядку' => 'list_order',
	'Родительская категория' => 'parent_category_id',
);

// #__{vm}_product_type
// product_type_id product_type_name product_type_description product_type_publish product_type_browsepage product_type_flypage  product_type_list_order
$product_type_fields = array (
	'№' => 'product_type_id',
	'Наименование' => 'product_type_name',
	'Описание' => 'product_type_description',
	'Опубликован' => 'product_type_publish',
	'Шаблон для каталога' => 'product_type_browsepage',
	'Шаблон для товара' => 'product_type_flypage',
	'Номер по порядку' => 'product_type_list_order',
);

// #__{vm}_product_type_parameter
// product_type_id parameter_name parameter_label parameter_description parameter_list_order parameter_type parameter_values parameter_multiselect parameter_default parameter_unit
$product_type_parameter_fields = array (
	'Номер типа' => 'product_type_id',
  'Тип' => 'product_type_name',
	'Наименование в базе' => 'parameter_name',
	'Наименование' => 'parameter_label',
	'Описание' => 'parameter_description',
	'Номер по порядку' => 'parameter_list_order',
	'Тип параметра' => 'parameter_type',
	'Возможные значения' => 'parameter_values',
	'Множество значений' => 'parameter_multiselect',
	'Значение по умолчанию' => 'parameter_default',
	'Единица измерения' => 'parameter_unit',
);   

//
//  product_id vendor_id product_parent_id product_sku product_s_desc product_desc product_thumb_image product_full_image product_publish product_weight product_weight_uom product_length product_width product_height product_lwh_uom product_url product_in_stock product_available_date product_availability   	  product_special product_discount_id ship_code_id cdate mdate product_name product_sales attribute custom_attribute product_tax_id product_unit product_packaging
$product_fields = array (
	'№' => 'product_id',
	'Идентификатор продавца' => 'vendor_id',
	'Идентификатор родительского товара' => 'product_parent_id',
	'Артикул' => 'product_sku',
	'Краткое описание' => 'product_s_desc',
  'Полное описание' => 'product_desc',
	'Маленькое изображение' => 'product_thumb_image',
	'Большое изображение' => 'product_full_image',
	'Опубликован' => 'product_publish',
	'Вес прибора' => 'product_weight',
	'Единица измерения веса' => 'product_weight_uom',
	'Длина' => 'product_length',
	'Ширина' => 'product_width',
	'Высота' => 'product_height',
	'Единица измерения размеров' => 'product_lwh_uom',
	'url' => 'product_url',
	'Количество в продаже' => 'product_in_stock',
	'product_available_date' => 'product_available_date',
	'Отгрузка' => 'product_availability',
	'Идентификатор скидки' => 'product_discount_id',
	'ship_code_id' => 'ship_code_id',
	'cdate' => 'cdate',
	'mdate' => 'mdate',
	'Наименование товара' => 'product_name',
	'Число продаж' => 'product_sales',
	'Атрибут' => 'attribute',
	'Атрибут определенный нами' => 'custom_attribute',
	'Идентификатор налога' => 'product_tax_id',
	'product_unit' => 'product_unit',
	'product_packaging' => 'product_packaging',
  'Идентификатор категории' => 'category_id',
  'Путь до родительской категории товара' => 'category_path',
  'Цена товара' => 'product_price',
  
);

$product_dynamic_fields = array (
	//'/Цена для (.+)/' => 'product_prices|shopper_group_name',
	'/(.+);(.+)/' => 'product_types|product_type_name|product_parameter_name',
);

?>
