<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\Html;
use intec\core\helpers\Json;
use intec\core\helpers\FileHelper;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CAllMain $APPLICATION
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);

if (!Loader::includeModule('intec.core'))
    return;

$bBase = false;

if (Loader::includeModule('catalog') && Loader::includeModule('sale'))
    $bBase = true;

if ($bBase)
    CJSCore::Init(array('currency'));

$arNavigation = !empty($arResult['NAV_RESULT']) ? [
    'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
    'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
    'NavNum' => $arResult['NAV_RESULT']->NavNum
] : [
    'NavPageCount' => 1,
    'NavPageNomer' => 1,
    'NavNum' => $this->randString()
];

$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
$sTemplateContainer = $sTemplateId.'-'.$arNavigation['NavNum'];

$arVisual = $arResult['VISUAL'];

$arVisual['NAVIGATION']['LAZY']['BUTTON'] =
    $arVisual['NAVIGATION']['LAZY']['BUTTON'] &&
    $arNavigation['NavPageNomer'] < $arNavigation['NavPageCount'];

$iCounter = 1;
$iItemsCount = count($arResult['ITEMS']);
$bGiftShowed = false;

$arSvg = [
    'DELAY' => FileHelper::getFileData(__DIR__.'/svg/delay.svg'),
    'COMPARE' => FileHelper::getFileData(__DIR__.'/svg/compare.svg'),
    'ORDER_FAST' => FileHelper::getFileData(__DIR__.'/svg/order.svg'),
    'QUICK_VIEW' => FileHelper::getFileData(__DIR__.'/svg/view.svg'),
    'PRICE_DIFFERENCE' => FileHelper::getFileData(__DIR__.'/svg/price.difference.svg')
];

/**
 * @var Closure $vCounter
 * @var Closure $dData
 * @var Closure $vButtons
 * @var Closure $vImage
 * @var Closure $vPrice
 * @var Closure $vPurchase
 * @var Closure $vQuantity
 * @var Closure $vSku
 * @var Closure $vQuickView
 */
include(__DIR__.'/parts/counter.php');
include(__DIR__.'/parts/data.php');
include(__DIR__.'/parts/buttons.php');
include(__DIR__.'/parts/image.php');
include(__DIR__.'/parts/price.php');
include(__DIR__.'/parts/purchase.php');
include(__DIR__.'/parts/quantity.php');
include(__DIR__.'/parts/sku.php');

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-catalog-section',
        'c-catalog-section-catalog-tile-4'
    ],
    'data' => [
        'borders' => $arVisual['BORDERS']['USE'] ? 'true' : 'false',
        'columns-desktop' => $arVisual['COLUMNS']['DESKTOP'],
        'columns-mobile' => $arVisual['COLUMNS']['MOBILE'],
        'wide' => $arVisual['WIDE'] ? 'true' : 'false',
        'properties' => !empty($arResult['SKU_PROPS']) ? Json::encode($arResult['SKU_PROPS'], JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true) : '',
        'button' => $arResult['ACTION'] !== 'none' ? 'true' : 'false'
    ]
]) ?>
    <?php if ($arVisual['GIFTS']['SHOW'] && $arVisual['GIFTS']['POSITION'] === 'top') { ?>
        <?php include(__DIR__.'/parts/sale.products.gift.section.php'); ?>
    <?php } ?>
    <?php if ($arVisual['NAVIGATION']['TOP']['SHOW']) { ?>
        <div class="catalog-section-navigation catalog-section-navigation-top" data-pagination-num="<?= $arNavigation['NavNum'] ?>">
            <!-- pagination-container -->
            <?= $arResult['NAV_STRING'] ?>
            <!-- pagination-container -->
        </div>
    <?php } ?>
    <!-- items-container -->
    <?= Html::beginTag('div', [
        'class' => [
            'catalog-section-items',
            'intec-grid' => [
                '',
                'wrap',
                'a-v-stretch',
                'a-h-start'
            ]
        ],
        'data' => [
            'role' => 'items',
            'filtered' => !empty($arResult['OFFERS_FILTERED_APPLY']) ? Json::encode($arResult['OFFERS_FILTERED_APPLY'], JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true) : '',
            'entity' => $sTemplateContainer
        ]
    ]) ?>
        <?php foreach ($arResult['ITEMS'] as $arItem) {

            $sId = $sTemplateId.'_'.$arItem['ID'];
            $sAreaId = $this->GetEditAreaId($sId);
            $this->AddEditAction($sId, $arItem['EDIT_LINK']);
            $this->AddDeleteAction($sId, $arItem['DELETE_LINK']);

            $sData = Json::encode($dData($arItem), JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true);
            $sLink = Html::decode($arItem['DETAIL_PAGE_URL']);
            $bRecalculation = false;

            $arSkuProps = [];

            if (!empty($arResult['SKU_PROPS']))
                $arSkuProps = $arResult['SKU_PROPS'];
            else if (!empty($arItem['SKU_PROPS']))
                $arSkuProps = $arItem['SKU_PROPS'];

            if ($bBase && $arVisual['PRICE']['RECALCULATION']) {
                if ($arItem['VISUAL']['COUNTER']['SHOW'] && $arItem['VISUAL']['ACTION'] === 'buy')
                    $bRecalculation = true;
            }

        ?>
            <?= Html::beginTag('div', [
                'id' => $sAreaId,
                'class' => Html::cssClassFromArray([
                    'catalog-section-item' => true,
                    'intec-grid-item' => [
                        $arVisual['COLUMNS']['DESKTOP'] => true,
                        '500-1' => $arVisual['COLUMNS']['DESKTOP'] <= 4 && $arVisual['COLUMNS']['MOBILE'] == 1,
                        '800-2' => $arVisual['WIDE'] && $arVisual['COLUMNS']['DESKTOP'] > 2,
                        '1000-3' => $arVisual['WIDE'] && $arVisual['COLUMNS']['DESKTOP'] > 3,
                        '700-2' => !$arVisual['WIDE'] && $arVisual['COLUMNS']['DESKTOP'] > 2,
                        '720-3' => !$arVisual['WIDE'] && $arVisual['COLUMNS']['DESKTOP'] > 2,
                        '950-2' => !$arVisual['WIDE'] && $arVisual['COLUMNS']['DESKTOP'] > 2,
                        '1200-3' => !$arVisual['WIDE'] && $arVisual['COLUMNS']['DESKTOP'] > 3
                    ]
                ],  true),
                'data' => [
                    'id' => $arItem['ID'],
                    'role' => 'item',
                    'products' => 'main',
                    'data' => $sData,
                    'expanded' => 'false',
                    'available' => $arItem['CAN_BUY'] ? 'true' : 'false',
                    'entity' => 'items-row',
                    'recalculation' => $bRecalculation ? 'true' : 'false',
                    'properties' => !empty($arSkuProps) ? Json::encode($arSkuProps, JSON_UNESCAPED_UNICODE | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_APOS, true) : ''
                ]
            ]) ?>
                <div class="catalog-section-item-wrapper" data-borders-style="<?= $arVisual['BORDERS']['STYLE'] ?>">
                    <div class="catalog-section-item-base">
                        <?php if ($arItem['VISUAL']['DELAY']['USE'] || $arItem['VISUAL']['COMPARE']['USE']) { ?>
                            <!--noindex-->
                            <?php $vButtons($arItem) ?>
                            <!--/noindex-->
                        <?php } elseif ($arResult['QUICK_VIEW']['USE'] && !$arResult['QUICK_VIEW']['DETAIL']) { ?>
                            <div class="catalog-section-item-action-buttons visible">
                                <?= Html::tag('div', $arSvg['QUICK_VIEW'], [
                                    'class' => [
                                        'catalog-section-item-action-button' => [
                                            '',
                                            'quick-view'
                                        ],
                                        'intec' => [
                                            'ui-picture',
                                            'cl-background-hover'
                                        ]
                                    ],
                                    'title' => Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_4_QUICK_VIEW_TITLE'),
                                    'data-role' => 'quick.view'
                                ]) ?>
                            </div>
                        <?php } ?>
                        <div class="catalog-section-item-image-container">
                            <?php $vImage($arItem) ?>
                            <!--noindex-->
                            <div class="catalog-section-item-marks">
                                <?php $APPLICATION->includeComponent(
                                    'intec.universe:main.markers',
                                    'template.2', [
                                        'HIT' => $arItem['VISUAL']['MARKS']['VALUES']['HIT'] ? 'Y' : 'N',
                                        'NEW' => $arItem['VISUAL']['MARKS']['VALUES']['NEW'] ? 'Y' : 'N',
                                        'RECOMMEND' => $arItem['VISUAL']['MARKS']['VALUES']['RECOMMEND'] ? 'Y' : 'N',
                                        'SHARE' => $arItem['VISUAL']['MARKS']['VALUES']['SHARE'] ? 'Y' : 'N',
                                        'ORIENTATION' => $arVisual['MARKS']['ORIENTATION']
                                    ],
                                    $component,
                                    ['HIDE_ICONS' => 'Y']
                                ) ?>
                            </div>
                            <!--/noindex-->
                        </div>
                        <!--noindex-->
                        <?php if ($arVisual['VOTE']['SHOW']) { ?>
                            <div class="catalog-section-item-vote">
                                <?php $APPLICATION->IncludeComponent(
                                    'bitrix:iblock.vote',
                                    'template.1',
                                    array(
                                        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                                        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                                        'ELEMENT_ID' => $arItem['ID'],
                                        'ELEMENT_CODE' => $arItem['CODE'],
                                        'MAX_VOTE' => '5',
                                        'VOTE_NAMES' => array(
                                            0 => '1',
                                            1 => '2',
                                            2 => '3',
                                            3 => '4',
                                            4 => '5',
                                        ),
                                        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                                        'CACHE_TIME' => $arParams['CACHE_TIME'],
                                        'DISPLAY_AS_RATING' => $arVisual['VOTE']['MODE'] === 'rating' ? 'rating' : 'vote_avg',
                                        'SHOW_RATING' => 'N'
                                    ),
                                    $component,
                                    ['HIDE_ICONS' => 'Y']
                                ) ?>
                            </div>
                        <?php } ?>
                        <!--/noindex-->
                        <div class="catalog-section-item-name">
                            <?= Html::tag($arResult['QUICK_VIEW']['DETAIL'] ? 'div' : 'a', $arItem['NAME'], [
                                'class' => [
                                     'section-item-name',
                                    'intec-cl-text-hover',
                                ],
                                'href' => !$arResult['QUICK_VIEW']['DETAIL'] ? $sLink : null,
                                'data' => [
                                    'role' => $arResult['QUICK_VIEW']['DETAIL'] ? 'quick.view' : 'offer.link',
                                    'id' => $arItem['ID'],
                                ]
                            ]) ?>
                        </div>
                        <!--noindex-->
                        <?php if ($arItem['VISUAL']['QUANTITY']['SHOW'] || $arVisual['ARTICLE']['SHOW']) { ?>
                            <div class="catalog-section-item-information">
                                <div class="intec-grid intec-grid-wrap intec-grid-a-v-end intec-grid-i-h-8 intec-grid-i-v-2">
                                    <?php if ($arItem['VISUAL']['QUANTITY']['SHOW']) { ?>
                                        <div class="catalog-section-item-quantity-wrap intec-grid-item-auto">
                                            <?php $vQuantity($arItem) ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($arVisual['ARTICLE']['SHOW']) { ?>
                                        <?= Html::beginTag('div', [
                                            'class' => [
                                                'catalog-section-item-article-wrap',
                                                'intec-grid-item-auto',
                                                'intec-grid-item-shrink-1'
                                            ],
                                            'data' => [
                                                'role' => 'article',
                                                'show' => !empty($arItem['DATA']['ARTICLE']['VALUE']) ? 'true' : 'false'
                                            ]
                                        ]) ?>
                                            <div class="catalog-section-item-article">
                                                <?= Html::tag('span', $arItem['DATA']['ARTICLE']['NAME'], [
                                                    'class' => 'catalog-section-item-article-name'
                                                ]) ?>
                                                <?= Html::tag('span', $arItem['DATA']['ARTICLE']['VALUE'], [
                                                    'class' => 'catalog-section-item-article-value',
                                                    'data-role' => 'article.value'
                                                ]) ?>
                                            </div>
                                        <?= Html::endTag('div') ?>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($arVisual['OFFERS']['USE'] && $arItem['VISUAL']['OFFER'] && !empty($arSkuProps))
                            $vSku($arSkuProps);
                        ?>
                        <!--/noindex-->
                        <?php if ($arItem['VISUAL']['PRICE']['SHOW'])
                            $vPrice($arItem);
                        ?>
                        <?php if ($arItem['VISUAL']['TIMER']['SHOW']) { ?>
                            <div class="catalog-section-item-timer">
                                <?php include(__DIR__.'/parts/timer.php'); ?>
                            </div>
                        <?php } ?>
                        <?php if ($arItem['VISUAL']['MEASURES']['USE']) { ?>
                            <div class="catalog-element-purchase-block catalog-element-purchase-measures" data-role="measures.container" style="display: none;">
                                <div class="catalog-element-purchase-measures-multiplier">
                                    <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_4_MEASURES_MULTIPLICITY_ORDER') ?>
                                    <span class="intec-cl-text" data-role="measures.multiplier"></span>
                                </div>
                                <?php include(__DIR__.'/parts/measures.php') ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($arItem['VISUAL']['ACTION'] !== 'none') { ?>
                        <!--noindex-->
                        <div class="catalog-section-item-advanced">
                            <div class="catalog-section-item-purchase-container">
                                <div class="catalog-section-item-purchase-container-wrapper intec-grid intec-grid-a-v-center">
                                    <?php if ($arItem['VISUAL']['COUNTER']['SHOW'])
                                        $vCounter();
                                    ?>
                                    <div class="catalog-section-item-purchase intec-grid-item intec-grid-item-shrink-1">
                                        <div class="catalog-section-item-purchase-desktop">
                                            <?php $vPurchase($arItem) ?>
                                        </div>
                                        <div class="catalog-section-item-purchase-mobile">
                                            <?php $vPurchase($arItem, true) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($bRecalculation) { ?>
                                    <div class="catalog-section-item-summary hidden" data-role="item.summary">
                                        <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_4_TITLE_SUMMARY') ?>
                                        <span data-role="item.summary.price"></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!--/noindex-->
                    <?php } ?>
                </div>
            <?= Html::endTag('div') ?>
            <?php if ($arVisual['GIFTS']['SHOW'] && $arVisual['GIFTS']['POSITION'] === 'middle' && !$bGiftShowed) { ?>
                <?php if ($iItemsCount > $arVisual['COLUMNS']['DESKTOP'] && $arVisual['COLUMNS']['DESKTOP'] == $iCounter ||
                             $iItemsCount <= $arVisual['COLUMNS']['DESKTOP'] && $iItemsCount == $iCounter) { ?>
                    <?php include(__DIR__.'/parts/sale.products.gift.section.php'); ?>
                    <?php $bGiftShowed = true; ?>
                <?php } ?>
            <?php } ?>
            <?php $iCounter++ ?>
        <?php } ?>
    <?= Html::endTag('div') ?>
    <!-- items-container -->
    <?php if ($arVisual['NAVIGATION']['LAZY']['BUTTON']) { ?>
        <div class="catalog-section-more" data-use="show-more-<?= $arNavigation['NavNum'] ?>">
            <div class="catalog-section-more-button">
                <div class="catalog-section-more-icon intec-cl-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path d="M16.5059 9.00153L15.0044 10.5015L13.5037 9.00153"  stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4.75562 4.758C5.84237 3.672 7.34312 3 9.00137 3C12.3171 3 15.0051 5.6865 15.0051 9.0015C15.0051 9.4575 14.9496 9.9 14.8536 10.3268" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M1.4939 8.99847L2.9954 7.49847L4.49615 8.99847"  stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M13.2441 13.242C12.1574 14.328 10.6566 15 8.99838 15C5.68263 15 2.99463 12.3135 2.99463 8.99853C2.99463 8.54253 3.05013 8.10003 3.14613 7.67328" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="catalog-section-more-text intec-cl-text">
                    <?= Loc::getMessage('C_CATALOG_SECTION_CATALOG_TILE_4_LAZY_TEXT') ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($arVisual['NAVIGATION']['BOTTOM']['SHOW']) { ?>
        <div class="catalog-section-navigation catalog-section-navigation-bottom" data-pagination-num="<?= $arNavigation['NavNum'] ?>">
            <!-- pagination-container -->
            <?= $arResult['NAV_STRING'] ?>
            <!-- pagination-container -->
        </div>
    <?php } ?>
    <?php if ($arVisual['GIFTS']['SHOW'] && $arVisual['GIFTS']['POSITION'] === 'bottom') { ?>
        <?php include(__DIR__.'/parts/sale.products.gift.section.php'); ?>
    <?php } ?>
    <?php include(__DIR__.'/parts/script.php') ?>
<?= Html::endTag('div') ?>