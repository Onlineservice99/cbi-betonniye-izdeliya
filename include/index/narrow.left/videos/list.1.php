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
  'margin-bottom' => '50px',
)]) ?>
<?php $APPLICATION->IncludeComponent('intec.universe:main.videos', 'template.2', array (
  'IBLOCK_TYPE' => 'content',
  'IBLOCK_ID' => '36',
  'SECTIONS_MODE' => 'id',
  'ELEMENTS_COUNT' => '',
  'PICTURE_SOURCES' => 
  array (
    0 => 'service',
    1 => 'preview',
    2 => 'detail',
  ),
  'PICTURE_SERVICE_QUALITY' => 'sddefault',
  'SETTINGS_USE' => 'Y',
  'LAZYLOAD_USE' => 'N',
  'PROPERTY_URL' => 'LINK',
  'HEADER_SHOW' => 'Y',
  'HEADER_POSITION' => 'center',
  'HEADER' => 'Видеогалерея',
  'DESCRIPTION_SHOW' => 'N',
  'FOOTER_SHOW' => 'N',
  'CACHE_TYPE' => 'A',
  'CACHE_TIME' => 3600000,
  'SORT_BY' => 'SORT',
  'ORDER_BY' => 'ASC',
), false) ?>
<?= Html::endTag('div') ?>
