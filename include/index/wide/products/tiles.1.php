<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\core\collections\Arrays;
use intec\core\helpers\Html;
use intec\core\io\Path;

/**
 * @var Arrays $blocks
 * @var array $block
 * @var array $data
 * @var string $page
 * @var Path $path
 * @global CMain $APPLICATION
 */

?>
<?= Html::beginTag('div', ['style' => array (
  'background-color' => '#f8f9fb',
  'padding-top' => '50px',
  'padding-bottom' => '50px',
)]) ?>
<?php $APPLICATION->IncludeComponent('intec.universe:main.widget', 'products.1', array (
  'SETTINGS_USE' => 'Y',
  'LAZYLOAD_USE' => 'N',
  'IBLOCK_TYPE' => 'catalogs',
  'IBLOCK_ID' => '13',
  'MODE' => 'all',
  'DELAY_USE' => 'Y',
  'FORM_ID' => '6',
  'FORM_PROPERTY_PRODUCT' => 'form_text_21',
  'FORM_REQUEST_ID' => '7',
  'FORM_REQUEST_PROPERTY_PRODUCT' => 'form_text_25',
  'FORM_REQUEST_TEMPLATE' => '.default',
  'BASKET_URL' => '/personal/basket/',
  'QUICK_VIEW_USE' => 'Y',
  'QUICK_VIEW_DETAIL' => 'N',
  'QUICK_VIEW_TEMPLATE' => 2,
  'QUICK_VIEW_PROPERTY_CODE' => 
  array (
    0 => 'PROPERTY_TYPE',
    1 => 'PROPERTY_QUANTITY_OF_STRIPS',
    2 => 'PROPERTY_POWER',
    3 => 'PROPERTY_PROCREATOR',
    4 => 'PROPERTY_SCOPE',
    5 => 'PROPERTY_DISPLAY',
    6 => 'PROPERTY_WEIGTH',
    7 => 'PROPERTY_ENERGY_CONSUMPTION',
    8 => 'PROPERTY_SETTINGS',
    9 => 'PROPERTY_COMPOSITION',
    10 => 'PROPERTY_LENGTH',
    11 => 'PROPERTY_SEASON',
    12 => 'PROPERTY_PATTERN',
  ),
  'QUICK_VIEW_PROPERTY_MARKS_HIT' => 'HIT',
  'QUICK_VIEW_PROPERTY_MARKS_NEW' => 'NEW',
  'QUICK_VIEW_PROPERTY_MARKS_RECOMMEND' => 'RECOMMEND',
  'QUICK_VIEW_PROPERTY_PICTURES' => 'PICTURES',
  'QUICK_VIEW_OFFERS_PROPERTY_PICTURES' => 'PICTURES',
  'QUICK_VIEW_DELAY_USE' => 'Y',
  'QUICK_VIEW_MARKS_SHOW' => 'Y',
  'QUICK_VIEW_MARKS_ORIENTATION' => 'horizontal',
  'QUICK_VIEW_GALLERY_PREVIEW' => 'Y',
  'QUICK_VIEW_QUANTITY_SHOW' => 'Y',
  'QUICK_VIEW_QUANTITY_MODE' => 'number',
  'QUICK_VIEW_ACTION' => 'buy',
  'QUICK_VIEW_COUNTER_SHOW' => 'Y',
  'QUICK_VIEW_DESCRIPTION_SHOW' => 'Y',
  'QUICK_VIEW_DESCRIPTION_MODE' => 'preview',
  'QUICK_VIEW_PROPERTIES_SHOW' => 'Y',
  'QUICK_VIEW_DETAIL_SHOW' => 'Y',
  'PROPERTY_ORDER_USE' => 'ORDER_USE',
  'PROPERTY_MARKS_HIT' => 'HIT',
  'PROPERTY_MARKS_NEW' => 'NEW',
  'PROPERTY_MARKS_RECOMMEND' => 'RECOMMEND',
  'PROPERTY_PICTURES' => 'PICTURES',
  'PROPERTY_CATEGORY' => 'CATEGORY',
  'COMPARE_PATH' => '/catalog/compare.php',
  'COMPARE_NAME' => 'compare',
  'COLUMNS' => 4,
  'BLOCKS_HEADER_SHOW' => 'Y',
  'BLOCKS_HEADER_TEXT' => 'Популярные товары',
  'BLOCKS_DESCRIPTION_SHOW' => 'N',
  'TABS_ALIGN' => 'left',
  'MARKS_SHOW' => 'Y',
  'MARKS_ORIENTATION' => 'horizontal',
  'NAME_ALIGN' => 'left',
  'SECTION_SHOW' => 'Y',
  'SECTION_ALIGN' => 'left',
  'PRICE_ALIGN' => 'start',
  'IMAGE_SLIDER_SHOW' => 'Y',
  'ACTION' => 'buy',
  'VOTE_SHOW' => 'Y',
  'VOTE_ALIGN' => 'left',
  'VOTE_MODE' => 'rating',
  'QUANTITY_SHOW' => 'Y',
  'QUANTITY_MODE' => 'number',
  'QUANTITY_ALIGN' => 'left',
  'USE_COMPARE' => 'Y',
  'SLIDER_USE' => 'N',
  'SLIDER_NAVIGATION' => 'Y',
  'SLIDER_DOTS' => 'Y',
  'SECTION_URL' => '',
  'DETAIL_URL' => '',
  'CONSENT_URL' => '/company/consent/',
  'CACHE_TYPE' => 'A',
  'CACHE_TIME' => 3600000,
  'PRICE_CODE' => 
  array (
    0 => 'BASE',
  ),
  'CONVERT_CURRENCY' => 'N',
  'USE_PRICE_COUNT' => 'N',
  'PRICE_VAT_INCLUDE' => 'N',
  'STORES_FIELDS' => 'ADDRESS',
  'BLOCKS_HEADER_ALIGN' => 'center',
  'OFFERS_VARIABLE_SELECT' => 'offer',
), false) ?>
<?= Html::endTag('div') ?>
