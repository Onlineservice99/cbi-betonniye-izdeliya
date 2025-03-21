<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die(); ?>
<?php

use intec\core\bitrix\Component;
use intec\core\helpers\Html;

/**
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if (empty($arResult['ITEMS']))
    return;

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arBlocks = $arResult['BLOCKS'];
$arVisual = $arResult['VISUAL'];

?>
<div class="widget c-advantages c-advantages-template-40" id="<?= $sTemplateId ?>">
    <div class="intec-content intec-content-visible">
        <div class="intec-content-wrapper">
            <?php if ($arBlocks['HEADER']['SHOW'] || $arBlocks['DESCRIPTION']['SHOW']) { ?>
                <div class="widget-header">
                    <?php if ($arBlocks['HEADER']['SHOW']) { ?>
                        <?= Html::tag('div', $arBlocks['HEADER']['TEXT'], [
                            'class' => [
                                'widget-title',
                                'align-' . $arBlocks['HEADER']['POSITION']
                            ]
                        ]) ?>
                    <?php } ?>
                    <?php if ($arBlocks['DESCRIPTION']['SHOW']) { ?>
                        <?= Html::tag('div', $arBlocks['DESCRIPTION']['TEXT'], [
                            'class' => [
                                'widget-description',
                                'align-' . $arBlocks['DESCRIPTION']['POSITION']
                            ]
                        ]) ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <?= Html::beginTag('div', [
                'class' => 'widget-content',
                'data-nav-view' => $arVisual['SLIDER']['NAV']['SHOW'] ? $arVisual['SLIDER']['NAV']['VIEW'] : null,
            ]) ?>
                <?= Html::beginTag('div', [
                    'class' => [
                        'widget-items',
                        'owl-carousel'
                    ],
                    'data-role' => 'container'
                ]) ?>
                    <?php foreach ($arResult['ITEMS'] as $arItem) {

                        $sTag = ($arVisual['LINK']['USE'] && !empty($arItem['DATA']['LINK']) && $arItem['DATA']['LINK'] !== '/') ? 'a' : 'div';

                        $sId = $sTemplateId . '_' . $arItem['ID'];
                        $sAreaId = $this->GetEditAreaId($sId);
                        $this->AddEditAction($sId, $arItem['EDIT_LINK']);
                        $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

                        $sPicture = $arItem['PREVIEW_PICTURE'];

                        if (empty($sPicture))
                            $sPicture = $arItem['DETAIL_PICTURE'];

                        if (!empty($sPicture)) {
                            $sPicture = CFile::ResizeImageGet($sPicture, [
                                'width' => 1500,
                                'height' => 1500
                            ], BX_RESIZE_IMAGE_EXACT);

                            if (!empty($sPicture))
                                $sPicture = $sPicture['src'];
                        }

                        if (empty($sPicture))
                            $sPicture = SITE_TEMPLATE_PATH . '/images/picture.missing.png';

                        ?>
                        <div class="widget-item" id="<?= $sAreaId ?>">
                            <div class="intec-grid intec-grid-wrap intec-grid-a-h-center intec-grid-a-v-center intec-grid-i-20">
                                <div class="intec-grid-item-2 intec-grid-item-1024-1">
                                    <?= Html::tag($sTag, $arItem['NAME'], [
                                        'class' => Html::cssClassFromArray([
                                            'widget-item-name' => true,
                                            'intec-cl-text-hover' => $sTag === 'a'
                                        ], true),
                                        'href' => $sTag === 'a' ? $arItem['DATA']['LINK'] : null,
                                        'target' => $sTag === 'a' && $arVisual['LINK']['BLANK'] ? '_blank' : null
                                    ]) ?>
                                    <?php if (!empty($arItem['PREVIEW_TEXT'])) { ?>
                                        <div class="widget-item-description">
                                            <?= $arItem['PREVIEW_TEXT'] ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="intec-grid-item-2 intec-grid-item-1024-1">
                                    <?= Html::beginTag($sTag, [
                                        'class' => [
                                            'widget-item-picture',
                                            'intec-ui-picture'
                                        ],
                                        'href' => $sTag === 'a' ? $arItem['DATA']['LINK'] : null,
                                        'target' => $sTag === 'a' && $arVisual['LINK']['BLANK'] ? '_blank' : null
                                    ]) ?>
                                        <?= Html::img($arVisual['LAZYLOAD']['USE'] ? $arVisual['LAZYLOAD']['STUB'] : $sPicture, [
                                            'class' => 'intec-image-effect',
                                            'alt' => $arItem['NAME'],
                                            'title' => $arItem['NAME'],
                                            'loading' => 'lazy',
                                            'data' => [
                                                'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                                                'original' => $arVisual['LAZYLOAD']['USE'] ? $sPicture : null
                                            ]
                                        ]) ?>
                                    <?= Html::endTag($sTag) ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?= Html::endTag('div') ?>
                <?php if ($arVisual['SLIDER']['NAV']['SHOW']) { ?>
                    <div class="widget-nav" data-role="container.nav"></div>
                <?php } ?>
            <?= Html::endTag('div') ?>
        </div>
    </div>
    <?php include(__DIR__ . '/parts/script.php') ?>
</div>
