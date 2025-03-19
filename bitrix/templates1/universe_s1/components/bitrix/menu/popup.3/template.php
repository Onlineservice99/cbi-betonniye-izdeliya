<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\bitrix\Component;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Type;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;
use intec\core\helpers\StringHelper;
use Bitrix\Main\Localization\Loc;

/** @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

$this->setFrameMode(true);
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/'
];

$arLogotype = [
    'SHOW' => ArrayHelper::getValue($arParams, 'LOGOTYPE_SHOW') == 'Y',
    'PATH' => ArrayHelper::getValue($arParams, 'LOGOTYPE', null),
    'LINK' => ArrayHelper::getValue($arParams, 'LOGOTYPE_LINK', null),
];

$arLogotype['PATH'] = trim($arLogotype['PATH']);
$arLogotype['PATH'] = StringHelper::replaceMacros($arLogotype['PATH'], $arMacros);
$arLogotype['SHOW'] = $arLogotype['SHOW'] && !empty($arLogotype['PATH']);

$arVisual = $arResult['VISUAL'];
$arContacts = $arResult['CONTACTS'];
$iContactsCount = count($arContacts);
$arSocial = $arResult['SOCIAL'];
$arForms = $arResult['FORMS'];

include(__DIR__.'/parts/views.php');

/**
 * @param array $arItems
 * @param integer $iLevel
 * @param array $arParent
 */

$fRender = function ($arItems, $iLevel, $arParent = null) use (&$fRender, &$arViews) {
    $sView = 'simple.level.'.$iLevel;

    if (empty($arViews[$sView]))
        $sView = 'simple.level.*';

    if (empty($arViews[$sView]))
        return;

    $fView = $arViews[$sView];
    $fView($arItems, $iLevel, $arParent);
}
?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => [
        'ns-bitrix',
        'c-menu',
        'c-menu-popup-3'
    ],
    'data-theme' => $arVisual['THEME']
]) ?>
    <div class="menu-button intec-cl-text-hover" data-action="menu.open">
        <i class="menu-button-icon glyph-icon-menu-icon"></i>
    </div>
    <?= Html::beginTag('div', [
        'class' => Html::cssClassFromArray([
            'menu' => true,
            'background-image' => $arVisual['BACKGROUND']['TYPE'] == 'picture' && !empty($arVisual['BACKGROUND']['URL'])
        ], true),
        'data-role' => 'menu',
        'style' => Html::cssStyleFromArray([
            'background-image' => $arVisual['BACKGROUND']['TYPE'] == 'picture' && !empty($arVisual['BACKGROUND']['URL']) ? 'url(' . $arVisual['BACKGROUND']['URL'] . ')' : null,
            'background-color' => $arVisual['BACKGROUND']['TYPE'] == 'color' && !empty($arVisual['BACKGROUND']['COLOR']) ? $arVisual['BACKGROUND']['COLOR'] : null
        ])
    ]) ?>
        <div class="menu-wrapper intec-content intec-content-primary">
            <div class="menu-wrapper-2 intec-content-wrapper">
                <div class="menu-panel">
                    <div class="menu-panel-wrapper intec-grid intec-grid-nowrap intec-grid-i-h-10 intec-grid-a-v-center">
                        <?php if ($arLogotype['SHOW']) { ?>
                            <div class="menu-panel-logotype-wrap intec-grid-item-auto">
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

                        <div class="intec-grid-item"></div>

                        <div class="intec-grid-item-4">
                            <div class="intec-grid intec-grid-a-h-between intec-grid-a-v-center">
                                <?php if ($arContacts['SHOW'] && !empty($arContacts['PHONE'])) { ?>
                                    <div class="menu-panel-contact-wrap intec-grid-item-auto">
                                        <a class="menu-panel-contact" href="tel:<?= $arContacts['PHONE']['VALUE'] ?>" style="display: flex;align-items: center;">
                                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="22" height="22" viewBox="0,0,256,256">
                                                <g fill="#ffffff" fill-rule="nonzero" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.69047,0 -23,10.30953 -23,23c0,4.0791 1.11869,7.88588 2.98438,11.20898l-2.94727,10.52148c-0.09582,0.34262 -0.00241,0.71035 0.24531,0.96571c0.24772,0.25536 0.61244,0.35989 0.95781,0.27452l10.9707,-2.71875c3.22369,1.72098 6.88165,2.74805 10.78906,2.74805c12.69047,0 23,-10.30953 23,-23c0,-12.69047 -10.30953,-23 -23,-23zM25,4c11.60953,0 21,9.39047 21,21c0,11.60953 -9.39047,21 -21,21c-3.72198,0 -7.20788,-0.97037 -10.23828,-2.66602c-0.22164,-0.12385 -0.48208,-0.15876 -0.72852,-0.09766l-9.60742,2.38086l2.57617,-9.19141c0.07449,-0.26248 0.03851,-0.54399 -0.09961,-0.7793c-1.84166,-3.12289 -2.90234,-6.75638 -2.90234,-10.64648c0,-11.60953 9.39047,-21 21,-21zM16.64258,13c-0.64104,0 -1.55653,0.23849 -2.30859,1.04883c-0.45172,0.48672 -2.33398,2.32068 -2.33398,5.54492c0,3.36152 2.33139,6.2621 2.61328,6.63477h0.00195v0.00195c-0.02674,-0.03514 0.3578,0.52172 0.87109,1.18945c0.5133,0.66773 1.23108,1.54472 2.13281,2.49414c1.80347,1.89885 4.33914,4.09336 7.48633,5.43555c1.44932,0.61717 2.59271,0.98981 3.45898,1.26172c1.60539,0.5041 3.06762,0.42747 4.16602,0.26563c0.82216,-0.12108 1.72641,-0.51584 2.62109,-1.08203c0.89469,-0.56619 1.77153,-1.2702 2.1582,-2.33984c0.27701,-0.76683 0.41783,-1.47548 0.46875,-2.05859c0.02546,-0.29156 0.02869,-0.54888 0.00977,-0.78711c-0.01897,-0.23823 0.0013,-0.42071 -0.2207,-0.78516c-0.46557,-0.76441 -0.99283,-0.78437 -1.54297,-1.05664c-0.30567,-0.15128 -1.17595,-0.57625 -2.04883,-0.99219c-0.8719,-0.41547 -1.62686,-0.78344 -2.0918,-0.94922c-0.29375,-0.10568 -0.65243,-0.25782 -1.16992,-0.19922c-0.51749,0.0586 -1.0286,0.43198 -1.32617,0.87305c-0.28205,0.41807 -1.4175,1.75835 -1.76367,2.15234c-0.0046,-0.0028 0.02544,0.01104 -0.11133,-0.05664c-0.42813,-0.21189 -0.95173,-0.39205 -1.72656,-0.80078c-0.77483,-0.40873 -1.74407,-1.01229 -2.80469,-1.94727v-0.00195c-1.57861,-1.38975 -2.68437,-3.1346 -3.0332,-3.7207c0.0235,-0.02796 -0.00279,0.0059 0.04687,-0.04297l0.00195,-0.00195c0.35652,-0.35115 0.67247,-0.77056 0.93945,-1.07812c0.37854,-0.43609 0.54559,-0.82052 0.72656,-1.17969c0.36067,-0.71583 0.15985,-1.50352 -0.04883,-1.91797v-0.00195c0.01441,0.02867 -0.11288,-0.25219 -0.25,-0.57617c-0.13751,-0.32491 -0.31279,-0.74613 -0.5,-1.19531c-0.37442,-0.89836 -0.79243,-1.90595 -1.04102,-2.49609v-0.00195c-0.29285,-0.69513 -0.68904,-1.1959 -1.20703,-1.4375c-0.51799,-0.2416 -0.97563,-0.17291 -0.99414,-0.17383h-0.00195c-0.36964,-0.01705 -0.77527,-0.02148 -1.17773,-0.02148zM16.64258,15c0.38554,0 0.76564,0.0047 1.08398,0.01953c0.32749,0.01632 0.30712,0.01766 0.24414,-0.01172c-0.06399,-0.02984 0.02283,-0.03953 0.20898,0.40234c0.24341,0.57785 0.66348,1.58909 1.03906,2.49023c0.18779,0.45057 0.36354,0.87343 0.50391,1.20508c0.14036,0.33165 0.21642,0.51683 0.30469,0.69336v0.00195l0.00195,0.00195c0.08654,0.17075 0.07889,0.06143 0.04883,0.12109c-0.21103,0.41883 -0.23966,0.52166 -0.45312,0.76758c-0.32502,0.37443 -0.65655,0.792 -0.83203,0.96484c-0.15353,0.15082 -0.43055,0.38578 -0.60352,0.8457c-0.17323,0.46063 -0.09238,1.09262 0.18555,1.56445c0.37003,0.62819 1.58941,2.6129 3.48438,4.28125c1.19338,1.05202 2.30519,1.74828 3.19336,2.2168c0.88817,0.46852 1.61157,0.74215 1.77344,0.82227c0.38438,0.19023 0.80448,0.33795 1.29297,0.2793c0.48849,-0.05865 0.90964,-0.35504 1.17773,-0.6582l0.00195,-0.00195c0.3568,-0.40451 1.41702,-1.61513 1.92578,-2.36133c0.02156,0.0076 0.0145,0.0017 0.18359,0.0625v0.00195h0.00195c0.0772,0.02749 1.04413,0.46028 1.90625,0.87109c0.86212,0.41081 1.73716,0.8378 2.02148,0.97852c0.41033,0.20308 0.60422,0.33529 0.6543,0.33594c0.00338,0.08798 0.0068,0.18333 -0.00586,0.32813c-0.03507,0.40164 -0.14243,0.95757 -0.35742,1.55273c-0.10532,0.29136 -0.65389,0.89227 -1.3457,1.33008c-0.69181,0.43781 -1.53386,0.74705 -1.8457,0.79297c-0.9376,0.13815 -2.05083,0.18859 -3.27344,-0.19531c-0.84773,-0.26609 -1.90476,-0.61053 -3.27344,-1.19336c-2.77581,-1.18381 -5.13503,-3.19825 -6.82031,-4.97266c-0.84264,-0.8872 -1.51775,-1.71309 -1.99805,-2.33789c-0.4794,-0.62364 -0.68874,-0.94816 -0.86328,-1.17773l-0.00195,-0.00195c-0.30983,-0.40973 -2.20703,-3.04868 -2.20703,-5.42578c0,-2.51576 1.1685,-3.50231 1.80078,-4.18359c0.33194,-0.35766 0.69484,-0.41016 0.8418,-0.41016z"></path></g></g>
                                            </svg>
                                            <?= Html::tag('i', '', [
                                                'class' => Html::cssClassFromArray([
                                                    'icon-phone' => true,
                                                    'glyph-icon-phone' => true,
                                                    'intec-cl-text' => $arVisual['THEME'] == 'light' ? true : false
                                                ], true)
                                            ]) ?>
                                            <span><?= $arContacts['PHONE']['DISPLAY'] ?></span>
                                        </a>
                                        <?php if ($arForms['CALL']['SHOW']) { ?>
                                            <div class="menu-panel-call-wrap">
                                                <?= Html::tag('span', $arForms['CALL']['TITLE'], [
                                                    'class' => Html::cssClassFromArray([
                                                        'menu-panel-call' => true,
                                                        'intec-cl-text-hover' => $arVisual['THEME'] == 'light' ? true : false,
                                                        'intec-cl-border-hover' => $arVisual['THEME'] == 'light' ? true : false,
                                                    ], true),
                                                    'data' => [
                                                        'role' => 'forms.button',
                                                        'action' => 'call.open',
                                                    ]
                                                ]) ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="intec-grid-item"></div>
                                <?php } ?>
                                <div class="menu-panel-button-wrap intec-grid-item-auto">
                                    <div class="menu-panel-button intec-cl-text-hover" data-action="menu.close">
                                        <i class="glyph-icon-cancel"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-content">
                    <div class="menu-content-wrapper intec-grid intec-grid-nowrap intec-grid-a-v-stretch">
                        <div class="menu-content-items intec-grid-item">
                            <?php if ($arVisual['SEARCH']['SHOW']) { ?>
                            <div class="menu-content-search-wrap">
                                <div class="menu-content-search">
                                    <?php include(__DIR__.'/parts/search/input.1.php') ?>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="menu-content-items-wrapper scroll-mod-hiding scrollbar-inner" data-role="scroll">
                                <div class="menu-content-items-wrapper-2">
                                    <?php if (!empty($arResult['MENU']['CATALOGS'])) { ?>
                                        <div class="menu-content-catalog">
                                            <?php foreach ($arResult['MENU']['CATALOGS'] as $arCatalog) { ?>
                                                <div class="menu-content-catalog-title-wrap">
                                                    <span class="menu-content-catalog-icon">
                                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M3.16667 10.6667C2.24583 10.6667 1.5 9.92084 1.5 9.00001C1.5 8.07918 2.24583 7.33334 3.16667 7.33334C4.0875 7.33334 4.83333 8.07918 4.83333 9.00001C4.83333 9.92084 4.0875 10.6667 3.16667 10.6667Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M8.99992 10.6667C8.07909 10.6667 7.33325 9.92084 7.33325 9.00001C7.33325 8.07918 8.07909 7.33334 8.99992 7.33334C9.92075 7.33334 10.6666 8.07918 10.6666 9.00001C10.6666 9.92084 9.92075 10.6667 8.99992 10.6667Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M14.8334 10.6667C13.9126 10.6667 13.1667 9.92084 13.1667 9.00001C13.1667 8.07918 13.9126 7.33334 14.8334 7.33334C15.7542 7.33334 16.5001 8.07918 16.5001 9.00001C16.5001 9.92084 15.7542 10.6667 14.8334 10.6667Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M3.16667 16.5C2.24583 16.5 1.5 15.7542 1.5 14.8333C1.5 13.9125 2.24583 13.1667 3.16667 13.1667C4.0875 13.1667 4.83333 13.9125 4.83333 14.8333C4.83333 15.7542 4.0875 16.5 3.16667 16.5Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M8.99992 16.5C8.07909 16.5 7.33325 15.7542 7.33325 14.8333C7.33325 13.9125 8.07909 13.1667 8.99992 13.1667C9.92075 13.1667 10.6666 13.9125 10.6666 14.8333C10.6666 15.7542 9.92075 16.5 8.99992 16.5Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M14.8334 16.5C13.9126 16.5 13.1667 15.7542 13.1667 14.8333C13.1667 13.9125 13.9126 13.1667 14.8334 13.1667C15.7542 13.1667 16.5001 13.9125 16.5001 14.8333C16.5001 15.7542 15.7542 16.5 14.8334 16.5Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M3.16667 4.83333C2.24583 4.83333 1.5 4.0875 1.5 3.16667C1.5 2.24583 2.24583 1.5 3.16667 1.5C4.0875 1.5 4.83333 2.24583 4.83333 3.16667C4.83333 4.0875 4.0875 4.83333 3.16667 4.83333Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M8.99992 4.83333C8.07909 4.83333 7.33325 4.0875 7.33325 3.16667C7.33325 2.24583 8.07909 1.5 8.99992 1.5C9.92075 1.5 10.6666 2.24583 10.6666 3.16667C10.6666 4.0875 9.92075 4.83333 8.99992 4.83333Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M14.8334 4.83333C13.9126 4.83333 13.1667 4.0875 13.1667 3.16667C13.1667 2.24583 13.9126 1.5 14.8334 1.5C15.7542 1.5 16.5001 2.24583 16.5001 3.16667C16.5001 4.0875 15.7542 4.83333 14.8334 4.83333Z" stroke="#B0B0B0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </span>
                                                    <?= Html::beginTag('a', [
                                                        'class' => Html::cssClassFromArray([
                                                            'menu-content-catalog-title' => true,
                                                            'intec-cl-text-hover' => $arVisual['THEME'] == 'light' ? true : false
                                                        ], true),
                                                        'href' => $arCatalog['LINK'],
                                                        'rel' => 'nofollow'
                                                    ]) ?>
                                                        <?= $arCatalog['TEXT'] ?>
                                                    <?= Html::endTag('a') ?>
                                                </div>
                                                <div class="menu-content-catalog-items">
                                                    <?php $fRender($arCatalog['ITEMS'], 0) ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    <div class="menu-content-other-items">
                                        <?php $fRender($arResult['MENU']['OTHER'], 0) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($arContacts['SHOW']
                            || $arSocial['SHOW']
                            || $arForms['FEEDBACK']['SHOW']
                            || $arVisual['AUTHORIZATION']['SHOW']
                            || $arVisual['BASKET']['SHOW']
                            || $arVisual['DELAY']['SHOW']
                            || $arVisual['COMPARE']['SHOW']
                        ) { ?>
                            <div class="menu-content-contacts-wrap intec-grid-item-4">
                                <?php if ($arForms['FEEDBACK']['SHOW']) { ?>
                                    <div class="menu-content-feedback-wrap">
                                        <?= Html::tag('span', $arForms['FEEDBACK']['TITLE'], [
                                            'class' => Html::cssClassFromArray([
                                                'intec-ui' => [
                                                    '' => true,
                                                    'control-button' => true,
                                                    'mod-round-2' => true,
                                                    'mod-transparent' => true,
                                                    'scheme-current' => $arVisual['THEME'] == 'light' ? true : false
                                                ],
                                                'menu-content-feedback' => true,
                                                'intec-cl-text-hover' => $arVisual['THEME'] == 'dark' ? true : false
                                            ], true),
                                            'data' => [
                                                'role' => 'forms.button',
                                                'action' => 'feedback.open'
                                            ]
                                        ]) ?>
                                    </div>
                                <?php } ?>

                                <?php if ($arVisual['AUTHORIZATION']['SHOW']) { ?>
                                    <?//php include(__DIR__.'/parts/auth/panel.php') ?>
                                <?php } ?>

                                <?php if ($arVisual['BASKET']['SHOW'] || $arVisual['DELAY']['SHOW'] || $arVisual['COMPARE']['SHOW']) { ?>
                                    <?php include(__DIR__.'/parts/basket.php') ?>
                                <?php } ?>

                                <?php if ($arContacts['SHOW']) { ?>
                                    <div class="menu-content-contacts">
                                        <div class="menu-content-contacts-items">
                                            <?php if (!empty($arContacts['CITY'])) { ?>
                                                <div class="menu-content-contacts-name intec-grid intec-grid-a-v-center intec-grid-i-h-4">
                                                    <span class="menu-content-contacts-icon intec-grid-item-auto">
                                                        <i class="fal fa-map-marker-alt"></i>
                                                    </span>
                                                    <span class="intec-grid-item">
                                                        <?= $arContacts['CITY'] ?>
                                                    </span>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($arContacts['ADDRESS'])) { ?>
                                                <div class="menu-content-contacts-address intec-grid intec-grid-a-v-center intec-grid-i-h-4">
                                                    <span class="menu-content-contacts-icon intec-grid-item-auto">
                                                        <i class="fal fa-map"></i>
                                                    </span>
                                                    <span class="intec-grid-item">
                                                        <?= $arContacts['ADDRESS'] ?>
                                                    </span>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($arContacts['EMAIL'])) { ?>
                                                <?= Html::beginTag('a', [
                                                    'class' => Html::cssClassFromArray([
                                                        'menu-content-contacts-mail' => true,
                                                        'intec-grid' => true,
                                                        'intec-grid-a-v-center' => true,
                                                        'intec-grid-i-h-4' => true,
                                                        'intec-cl' => [
                                                            'text-hover' => $arVisual['THEME'] == 'light' ? true : false,
                                                        ]
                                                    ], true),
                                                    'href' => 'mailto:'.$arContacts['EMAIL']
                                                ]) ?>
                                                    <span class="menu-content-contacts-icon intec-grid-item-auto">
                                                        <i class="fal fa-envelope"></i>
                                                    </span>
                                                    <span class="intec-grid-item">
                                                        <?= $arContacts['EMAIL'] ?>
                                                    </span>
                                                <?= Html::endTag('a') ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if ($arSocial['SHOW']) { ?>
                                    <div class="menu-content-social">
                                        <div class="menu-content-social-icons intec-grid intec-grid-nowrap intec-grid-i-h-6">
                                            <?php foreach ($arSocial['ITEMS'] as $arItem) { ?>
                                                <?php if (empty($arItem['LINK'])) continue ?>
                                                <div class="menu-content-social-icon-wrap intec-grid-item-auto">
                                                    <?= Html::beginTag('a', [
                                                        'class' => Html::cssClassFromArray([
                                                            'menu-content-social-icon' => true,
                                                            'huinya' => true,
                                                            'intec-cl' => [
                                                                'svg-rect-fill-hover' => $arVisual['THEME'] == 'light' ? true : false,
                                                                'svg-path-fill-hover' => $arVisual['THEME'] == 'light' ? true : false,
                                                            ]
                                                        ], true),
                                                        'href' => $arItem['LINK']
                                                    ]) ?>
                                                        <?php include($arItem['ICON']); ?>
                                                    <?= Html::endTag('a') ?>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php include(__DIR__.'/parts/form.php') ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    <?= Html::endTag('div') ?>

    <script type="text/javascript">
        template.load(function (data) {
            var $ = this.getLibrary('$');

            var root = data.nodes;
            var area = $(window);
            var menu = $('[data-role="menu"]', root);
            var buttons = {};
            var state = false;
            var scroll = $('[data-role="scroll"]', root);
            var scrollValue = 0;

            menu.items = $('[data-role="menu.item"]', menu);
            buttons.open = $('[data-action="menu.open"]', root);
            buttons.close = $('[data-action="menu.close"]', root);

            scroll.scrollbar();

            menu.open = function () {
                if (state) return;

                state = true;
                scrollValue = area.scrollTop();
                menu.css({
                    'display': 'block'
                }).stop().animate({
                    'opacity': 1
                }, 500);
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
                });
            };

            area.on('scroll', function () {
                if (state && area.scrollTop() !== scrollValue)
                    area.scrollTop(scrollValue);
            });

            buttons.open.on('click', menu.open);
            buttons.close.on('click', menu.close);

            menu.items.each(function () {
                var item = $(this);
                var items = $('[data-role="menu.items"]', item).first();
                var buttons = {};
                var state = false;
                var expanded = item.data('expanded');

                buttons.toggle = $('[data-action="menu.item.toggle"]', item)
                    .not(items.find('[data-action="menu.item.toggle"]'))
                    .first();

                item.open = function () {
                    var height = {};

                    if (state) return;

                    state = true;
                    item.attr('data-expanded', 'true');

                    height.old = items.height();
                    items.css({
                        'height': 'auto'
                    });

                    height.new = items.height();
                    items.css({
                        'height': height.old
                    });

                    items.stop().animate({
                        'height': height.new
                    }, 350, function () {
                        items.css({
                            'height': 'auto'
                        })
                    })
                };

                item.close = function () {
                    if (!state) return;

                    state = false;
                    item.attr('data-expanded', 'false');

                    items.stop().animate({
                        'height': 0
                    }, 350);
                };

                if (expanded)
                    item.open();

                buttons.toggle.on('click', function () {
                    if (state) {
                        item.close();
                    } else {
                        item.open();
                    }
                });
            });
        }, {
            'name': '[Component] bitrix:menu (popup.3)',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>
        });
    </script>
<?= Html::endTag('div') ?>