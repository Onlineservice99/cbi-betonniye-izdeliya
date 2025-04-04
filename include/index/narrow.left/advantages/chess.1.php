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
<?php $APPLICATION->IncludeComponent('intec.universe:main.advantages', 'template.3', array (
  'IBLOCK_TYPE' => 'content',
  'IBLOCK_ID' => '6',
  'SECTIONS_MODE' => 'id',
  'ELEMENTS_COUNT' => '2',
  'SETTINGS_USE' => 'Y',
  'LAZYLOAD_USE' => 'N',
  'HEADER_SHOW' => 'Y',
  'HEADER_POSITION' => 'left',
  'HEADER' => 'Преимущества',
  'DESCRIPTION_SHOW' => 'N',
  'BACKGROUND_SIZE' => 'cover',
  'ARROW_SHOW' => 'N',
  'CACHE_TYPE' => 'A',
  'CACHE_TIME' => 3600000,
  'SORT_BY' => 'SORT',
  'ORDER_BY' => 'ASC',
), false) ?>
<?= Html::endTag('div') ?>
