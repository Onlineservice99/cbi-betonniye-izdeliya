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
  'margin-top' => '50px',
  'margin-bottom' => '50px',
)]) ?>
<?php $APPLICATION->IncludeComponent('intec.universe:main.advantages', 'template.33', array (
  'IBLOCK_TYPE' => 'content',
  'IBLOCK_ID' => '8',
  'SECTIONS_MODE' => 'id',
  'SETTINGS_USE' => 'Y',
  'LAZYLOAD_USE' => 'N',
  'CACHE_TYPE' => 'A',
  'CACHE_TIME' => 3600000,
  'SORT_BY' => 'SORT',
  'ORDER_BY' => 'ASC',
  'ELEMENTS_COUNT' => 4,
  'PROPERTY_NUMBER' => 'NUMBER_VALUE',
  'PROPERTY_MAX_NUMBER' => 'NUMBER_MAXIMUM',
  'HEADER_SHOW' => 'Y',
  'HEADER_POSITION' => 'center',
  'HEADER' => 'О нас в цифрах',
  'COLUMNS' => 4,
), false) ?>
<?= Html::endTag('div') ?>
