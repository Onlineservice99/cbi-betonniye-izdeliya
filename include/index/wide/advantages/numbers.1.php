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
<?= Html::beginTag('div') ?>
<?php $APPLICATION->IncludeComponent('intec.universe:main.advantages', 'template.31', array (
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
  'BACKGROUND_SHOW' => 'Y',
  'BACKGROUND_COLOR' => '#F8F9FB',
  'PROPERTY_NUMBER' => 'NUMBER_VALUE',
  'HEADER_SHOW' => 'Y',
  'HEADER_POSITION' => 'center',
  'HEADER' => 'О нас в цифрах',
  'DESCRIPTION_SHOW' => 'N',
  'THEME' => 'light',
  'COLUMNS' => 4,
  'NUMBER_SHOW' => 'Y',
  'NUMBER_ALIGN' => 'center',
  'PREVIEW_SHOW' => 'Y',
  'PREVIEW_ALIGN' => 'center',
), false) ?>
<?= Html::endTag('div') ?>
