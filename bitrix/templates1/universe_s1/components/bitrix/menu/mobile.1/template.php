<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\StringHelper;
use intec\core\helpers\Type;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

Loc::loadMessages(__FILE__);

$this->setFrameMode(true);
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arParams = ArrayHelper::merge([
    'ADDRESS_SHOW' => 'N',
    'ADDRESS' => null,
    'PHONE_SHOW' => 'N',
    'PHONE' => null,
    'EMAIL_SHOW' => 'N',
    'EMAIL' => null,
    'LOGOTYPE_SHOW' => 'N',
    'LOGOTYPE' => null,
    'LOGOTYPE_LINK' => null,
    'REGIONALITY_USE' => 'N'
], $arParams);

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/'
];

$arAddress = [
    'SHOW' => $arParams['ADDRESS_SHOW'] === 'Y',
    'VALUE' => $arParams['ADDRESS']
];

if (empty($arAddress['VALUE']))
    $arAddress['SHOW'] = false;

$arPhone = [
    'SHOW' => $arParams['PHONE_SHOW'] === 'Y',
    'VALUE' => $arParams['PHONE']
];

if (empty($arPhone['VALUE'])) {
    $arPhone['SHOW'] = false;
} else {
    $arPhone['VALUE'] = [
        'DISPLAY' => $arPhone['VALUE'],
        'LINK' => StringHelper::replace($arPhone['VALUE'], [
            '(' => '',
            ')' => '',
            ' ' => '',
            '-' => ''
        ])
    ];
}

$arEmail = [
    'SHOW' => $arParams['EMAIL_SHOW'] === 'Y',
    'VALUE' => $arParams['EMAIL']
];

if (empty($arEmail['VALUE']))
    $arEmail['SHOW'] = false;

$arLogotype = [
    'SHOW' => $arParams['LOGOTYPE_SHOW'] === 'Y',
    'PATH' => $arParams['LOGOTYPE'],
    'LINK' => $arParams['LOGOTYPE_LINK']
];

if (empty($arLogotype['PATH'])) {
    $arLogotype['SHOW'] = false;
} else {
    $arLogotype['PATH'] = StringHelper::replaceMacros(
        $arLogotype['PATH'],
        $arMacros
    );
}

$arRegionality = [
    'USE' => $arParams['REGIONALITY_USE'] === 'Y' && Loader::includeModule('intec.regionality')
];

$iExtraCounter = 0;

?>
<?php $fRenderItem = function ($arItem, $iLevel, $arParent = null, $bActive = false) use (&$fRenderItem) {
    $sName = ArrayHelper::getValue($arItem, 'TEXT');
    $sLink = ArrayHelper::getValue($arItem, 'LINK');
    $arChildren = ArrayHelper::getValue($arItem, 'ITEMS');

    $bSelected = ArrayHelper::getValue($arItem, 'SELECTED');
    $bSelected = Type::toBoolean($bSelected);
    $bHasChildren = !empty($arChildren);

    $bActive = $arItem['ACTIVE'];
    $sTag = $bHasChildren || $bActive ? 'div' : 'a';
?>
    <?= Html::beginTag('div', [
        'class' => Html::cssClassFromArray([
            'menu-item' => [
                '' => true,
                'level-'.$iLevel => true,
                'inner' => $iLevel > 0,
                'selected' => $bSelected
            ]
        ], true),
        'data' => [
            'role' => 'item',
            'level' => $iLevel,
            'expanded' => 'false',
            'current' => 'false'
        ]
    ]) ?>
        <div class="menu-item-wrapper">
            <?= Html::beginTag($sTag, [
                'class' => Html::cssClassFromArray([
                    'menu-item-content' => true,
                    'intec-cl' => [
                        'text' => $bSelected,
                        'text-hover' => true
                    ]
                ], true),
                'href' => $sTag == 'a' ? $sLink : null,
                'data' => [
                    'action' => $bHasChildren ? 'menu.item.open' : 'menu.close'
                ]
            ]) ?>
                <div class="intec-grid intec-grid-nowrap intec-grid-i-h-10 intec-grid-a-v-center">
                    <div class="menu-item-text-wrap intec-grid-item intec-grid-item-shrink-1">
                        <div class="menu-item-text">
                            <?= $sName ?>
                        </div>
                    </div>
                    <?php if ($bHasChildren) { ?>
                        <div class="menu-item-icon-wrap intec-grid-item-auto">
                            <div class="menu-item-icon">
                                <i class="far fa-angle-right"></i>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?= Html::endTag($sTag) ?>
            <?php if ($bHasChildren) {

                $sChildTag = $bActive ? 'div' : 'a';

            ?>
                <div class="menu-item-items" data-role="items">
                    <?= Html::beginTag('div', [
                        'class' => [
                            'menu-item' => [
                                '',
                                'level-'.($iLevel + 1),
                                'button'
                            ]
                        ],
                        'data' => [
                            'level' => $iLevel + 1
                        ]
                    ]) ?>
                        <div class="menu-item-wrapper">
                            <div class="menu-item-content intec-cl-text-hover" data-action="menu.item.close">
                                <div class="intec-grid intec-grid-nowrap intec-grid-i-h-10 intec-grid-a-v-center">
                                    <div class="menu-item-icon-wrap intec-grid-item-auto">
                                        <div class="menu-item-icon">
                                            <i class="far fa-angle-left"></i>
                                        </div>
                                    </div>
                                    <div class="menu-item-text-wrap intec-grid-item intec-grid-item-shrink-1">
                                        <div class="menu-item-text">
                                            <?= Loc::getMessage('C_MENU_MOBILE_1_BACK') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?= Html::endTag('div') ?>
                    <?= Html::beginTag('div', [
                        'class' => [
                            'menu-item' => [
                                '',
                                'level-'.($iLevel + 1),
                                'title'
                            ]
                        ],
                        'data' => [
                            'level' => $iLevel + 1
                        ]
                    ]) ?>
                        <div class="menu-item-wrapper">
                            <?= Html::tag($sChildTag, $sName, [
                                'class' => 'menu-item-content',
                                'href' => $sChildTag == 'a' ? $sLink : null,
                                'data' => [
                                    'action' => 'menu.close'
                                ]
                            ]) ?>
                        </div>
                    <?= Html::endTag('div') ?>
                    <?php foreach ($arChildren as $arChild) {
                        $fRenderItem($arChild, $iLevel + 1, $arItem, $bActive);
                    } ?>
                </div>
            <?php } ?>
        </div>
    <?= Html::endTag('div') ?>
<?php } ?>
<?php if (!empty($arResult)) { ?>
    <div id="<?= $sTemplateId ?>" class="ns-bitrix c-menu c-menu-mobile-1">
        <div class="menu-button intec-cl-text-hover" data-action="menu.open">
            <i class="menu-button-icon glyph-icon-menu-icon"></i>
        </div>
        <div class="menu" data-role="menu">
            <div class="menu-panel">
                <div class="menu-panel-wrapper intec-grid intec-grid-nowrap intec-grid-i-h-10 intec-grid-a-v-center">
                    <?php if ($arLogotype['SHOW']) { ?>
                        <div class="menu-panel-logotype-wrap intec-grid-item">
                            <?= Html::beginTag(!empty($arLogotype['LINK']) ? 'a' : 'div', [
                                'class' => [
                                    'menu-panel-logotype'
                                ],
                                'href' => !empty($arLogotype['LINK']) ? $arLogotype['LINK'] : null
                            ]) ?>
                                <?php $APPLICATION->IncludeComponent(
                                    'bitrix:main.include',
                                    '.default',
                                    array(
                                        'AREA_FILE_SHOW' => 'file',
                                        'PATH' => $arLogotype['PATH'],
                                        'EDIT_TEMPLATE' => null
                                    ),
                                    $this->getComponent()
                                ) ?>
                            <?= Html::endTag(!empty($arLogotype['LINK']) ? 'a' : 'div') ?>
                        </div>
                    <?php } ?>
                    <div class="menu-panel-button-wrap intec-grid-item-auto">
                        <div class="menu-panel-button intec-cl-text-hover" data-action="menu.close">
                            <i class="glyph-icon-cancel"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-content" data-role="item" data-current="true">
                <div class="menu-content-wrapper">
                    <div class="menu-items" data-role="items">

                        <?php foreach ($arResult as $arItem) {
                            $fRenderItem($arItem, 0);
                        } ?>
                        <?php if ($arRegionality['USE']) { ?>
                            <?php $APPLICATION->IncludeComponent(
                                'intec.regionality:regions.select',
                                '.default',
                                [],
                                $component
                            ) ?>
                        <?php } ?>
                        <?php if ($arAddress['SHOW']) { ?>
                            <?php $iExtraCounter++ ?>
                            <?= Html::beginTag('div', [
                                'class' => [
                                    'menu-item' => [
                                        '',
                                        'level-0',
                                        'extra',
                                        $iExtraCounter > 1 ? null : 'extra-first'
                                    ]
                                ],
                                'data' => [
                                    'role' => 'item',
                                    'level' => 0,
                                    'expanded' => 'false',
                                    'current' => 'false'
                                ]
                            ]) ?>
                                <div class="menu-item-wrapper">
                                    <?= Html::beginTag('div', [
                                        'class' => [
                                            'menu-item-content',
                                            'intec-cl' => [
                                                'text-hover'
                                            ]
                                        ],
                                        'data' => [
                                            'action' => 'menu.item.open'
                                        ]
                                    ]) ?>
                                        <div class="intec-grid intec-grid-nowrap intec-grid-i-h-10 intec-grid-a-v-center">
                                            <div class="menu-item-icon-wrap intec-grid-item-auto">
                                                <div class="menu-item-icon intec-cl-text">
                                                    <i class="fas fa-map-marked-alt"></i>
                                                </div>
                                            </div>
                                            <div class="menu-item-text-wrap intec-grid-item intec-grid-item-shrink-1">
                                                <div class="menu-item-text">
                                                    <?= $arAddress['VALUE'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?= Html::endTag('div') ?>
                                </div>
                            <?= Html::endTag('div') ?>
                        <?php } ?>
                        <?php if ($arPhone['SHOW']) { ?>
                            <?php $iExtraCounter++ ?>
                            <?= Html::beginTag('div', [
                                'class' => [
                                    'menu-item' => [
                                        '',
                                        'level-0',
                                        'extra',
                                        $iExtraCounter > 1 ? null : 'extra-first'
                                    ]
                                ],
                                'data' => [
                                    'role' => 'item',
                                    'level' => 0,
                                    'expanded' => 'false',
                                    'current' => 'false'
                                ]
                            ]) ?>
                                <div class="menu-item-wrapper">
                                    <?= Html::beginTag('div', [
                                        'class' => [
                                            'menu-item-content',
                                            'intec-cl' => [
                                                'text-hover'
                                            ]
                                        ],
                                        'data' => [
                                            'action' => 'menu.item.open'
                                        ]
                                    ]) ?>
                                        <div class="intec-grid intec-grid-nowrap intec-grid-i-h-10 intec-grid-a-v-center">
                                            <div class="menu-item-icon-wrap intec-grid-item-auto">
                                                <div class="menu-item-icon intec-cl-text">
                                                    <i class="fas fa-phone fa-flip-horizontal"></i>
                                                </div>
                                            </div>
                                            <div class="menu-item-text-wrap intec-grid-item intec-grid-item-shrink-1">
                                                <a href="tel:<?= $arPhone['VALUE']['LINK'] ?>" class="menu-item-text">
                                                    <?= $arPhone['VALUE']['DISPLAY'] ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?= Html::endTag('div') ?>
                                </div>
                            <?= Html::endTag('div') ?>
                        <?php } ?>
                        <?php if ($arEmail['SHOW']) { ?>
                            <?php $iExtraCounter++ ?>
                            <?= Html::beginTag('div', [
                                'class' => [
                                    'menu-item' => [
                                        '',
                                        'level-0',
                                        'extra',
                                        $iExtraCounter > 1 ? null : 'extra-first'
                                    ]
                                ],
                                'data' => [
                                    'role' => 'item',
                                    'level' => 0,
                                    'expanded' => 'false',
                                    'current' => 'false'
                                ]
                            ]) ?>
                                <div class="menu-item-wrapper">
                                    <?= Html::beginTag('div', [
                                        'class' => [
                                            'menu-item-content',
                                            'intec-cl' => [
                                                'text-hover'
                                            ]
                                        ],
                                        'data' => [
                                            'action' => 'menu.item.open'
                                        ]
                                    ]) ?>
                                        <div class="intec-grid intec-grid-nowrap intec-grid-i-h-10 intec-grid-a-v-center">
                                            <div class="menu-item-icon-wrap intec-grid-item-auto">
                                                <div class="menu-item-icon intec-cl-text">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                            </div>
                                            <div class="menu-item-text-wrap intec-grid-item intec-grid-item-shrink-1">
                                                <a href="mailto:<?= $arEmail['VALUE'] ?>" class="menu-item-text">
                                                    <?= $arEmail['VALUE'] ?>
                                                </a>
                                            </div>
                                        </div>
                                    <?= Html::endTag('div') ?>
                                </div>
                            <?= Html::endTag('div') ?>
                        <?php } ?>
						<? /* вставка номера 30.01.2025 */ ?>
						<?= Html::beginTag('div', [
							'class' => [
								'menu-item' => [
									'',
									'level-0',
									'extra'
								]
							],
							'data' => [
								'role' => 'item',
								'level' => 0,
								'expanded' => 'false',
								'current' => 'false'
							]
						]) ?>
							<div class="menu-item-wrapper">
								<?= Html::beginTag('div', [
									'class' => [
										'menu-item-content',
										'intec-cl' => [
											'text-hover'
										]
									],
									'data' => [
										'action' => 'menu.item.open'
									]
								]) ?>
									<div class="intec-grid intec-grid-nowrap intec-grid-i-h-10 intec-grid-a-v-center">
										<div class="menu-item-icon-wrap intec-grid-item-auto">
											<div class="menu-item-icon intec-cl-text" style="height: 20px;">
												<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M3.50002 12C3.50002 7.30558 7.3056 3.5 12 3.5C16.6944 3.5 20.5 7.30558 20.5 12C20.5 16.6944 16.6944 20.5 12 20.5C10.3278 20.5 8.77127 20.0182 7.45798 19.1861C7.21357 19.0313 6.91408 18.9899 6.63684 19.0726L3.75769 19.9319L4.84173 17.3953C4.96986 17.0955 4.94379 16.7521 4.77187 16.4751C3.9657 15.176 3.50002 13.6439 3.50002 12ZM12 1.5C6.20103 1.5 1.50002 6.20101 1.50002 12C1.50002 13.8381 1.97316 15.5683 2.80465 17.0727L1.08047 21.107C0.928048 21.4637 0.99561 21.8763 1.25382 22.1657C1.51203 22.4552 1.91432 22.5692 2.28599 22.4582L6.78541 21.1155C8.32245 21.9965 10.1037 22.5 12 22.5C17.799 22.5 22.5 17.799 22.5 12C22.5 6.20101 17.799 1.5 12 1.5ZM14.2925 14.1824L12.9783 15.1081C12.3628 14.7575 11.6823 14.2681 10.9997 13.5855C10.2901 12.8759 9.76402 12.1433 9.37612 11.4713L10.2113 10.7624C10.5697 10.4582 10.6678 9.94533 10.447 9.53028L9.38284 7.53028C9.23954 7.26097 8.98116 7.0718 8.68115 7.01654C8.38113 6.96129 8.07231 7.046 7.84247 7.24659L7.52696 7.52195C6.76823 8.18414 6.3195 9.2723 6.69141 10.3741C7.07698 11.5163 7.89983 13.314 9.58552 14.9997C11.3991 16.8133 13.2413 17.5275 14.3186 17.8049C15.1866 18.0283 16.008 17.7288 16.5868 17.2572L17.1783 16.7752C17.4313 16.5691 17.5678 16.2524 17.544 15.9269C17.5201 15.6014 17.3389 15.308 17.0585 15.1409L15.3802 14.1409C15.0412 13.939 14.6152 13.9552 14.2925 14.1824Z" fill="#2d6e6e"></path> </g></svg>
											</div>
										</div>
										<div class="menu-item-text-wrap intec-grid-item intec-grid-item-shrink-1">
											<a href="https://wa.me/79201279887" class="menu-item-text">
												+7 (920) 127-98-87
											</a>
										</div>
									</div>
								<?= Html::endTag('div') ?>
							</div>
						<?= Html::endTag('div') ?>
						<? /* вставка номера 30.01.2025 */ ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            template.load(function (data) {
                var $ = this.getLibrary('$');

                var root = data.nodes;
                var menu = $('[data-role="menu"]', root);
                var page = $('html');
                var buttons = {};
                var state = false;
                var questionRegion = $('[data-role="header-mobile-region-select"]');
                var question = $('[data-role="question"]', questionRegion);

                menu.items = $('[data-role="item"]', root);
                buttons.open = $('[data-action="menu.open"]', root);
                buttons.close = $('[data-action="menu.close"]', root);

                menu.open = function () {
                    if (state) return;

                    state = true;
                    menu.css({
                        'display': 'block'
                    }).stop().animate({
                        'opacity': 1
                    }, 500);

                    page.css({
                        'overflow': 'hidden',
                        'height': '100%'
                    });
                };

                menu.close = function () {
                    if (!state) return;

                    state = false;
                    menu.stop().animate({
                        'opacity': 0
                    }, 500, function () {
                        menu.css({
                            'display': 'none'
                        });

                        page.css({
                            'overflow': '',
                            'height': ''
                        });
                    });
                };

                buttons.open.on('click', menu.open);
                buttons.close.on('click', menu.close);

                menu.items.each(function () {
                    var item = $(this);
                    var parent = item.parents('[data-role="item"]').first();
                    var items = $('[data-role="items"]', item).first();
                    var buttons = {};
                    var state = false;

                    parent.items = $('[data-role="items"]', parent).first();

                    if (items.length === 0)
                        return;

                    buttons.open = $('[data-action="menu.item.open"]', item).first();
                    buttons.close = $('[data-action="menu.item.close"]', items).first();

                    item.open = function () {
                        if (state) return;

                        state = true;
                        menu.items.attr('data-current', 'false');
                        item.attr('data-expanded', 'true');
                        item.attr('data-current', 'true');
                        parent.items.scrollTop(0);
                    };

                    item.close = function () {
                        if (!state) return;

                        state = false;
                        menu.items.attr('data-current', 'false');
                        item.attr('data-expanded', 'false');
                        parent.attr('data-current', 'true');
                    };

                    buttons.open.on('click', item.open);
                    buttons.close.on('click', item.close);
                });

                var regionSelect = $('[data-code="region.select"]', menu.items);
                regionSelect.close = $('[data-action="menu.item.close"]', regionSelect);

                regionSelect.close.on('click', function () {
                    regionSelect.attr('data-expanded', 'false');
                });

                $(questionRegion).on('click', '[data-role="question.no"]', function () {
                    menu.open();
                    question.remove();
                    regionSelect.attr('data-expanded', 'true');
                    regionSelect[0].dataset.current = 'true';
                });
            }, {
                'name': '[Component] bitrix:menu (mobile.1)',
                'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
                'loader': {
                    'name': 'lazy'
                }
            });
        </script>
    </div>
<?php } ?>