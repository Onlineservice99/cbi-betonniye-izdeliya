<?php if (defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Loader;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\template\Properties;

/**
 * @var array $arParams
 * @var array $arResult
 * @var array $arSection
 * @var array $arViews
 * @var array $arFilter
 * @var CBitrixComponent
 */

$arElement = [
    'SHOW' => true,
    'TEMPLATE' => ArrayHelper::getValue($arParams, 'DETAIL_TEMPLATE'),
    'PARAMETERS' => []
];

if (empty($arElement['TEMPLATE']))
    $arElement['SHOW'] = false;

if ($arElement['SHOW']) {
    $sPrefix = 'DETAIL_';
    $arElement['TEMPLATE'] = 'catalog.'.$arElement['TEMPLATE'];

    foreach ($arParams as $sKey => $mValue) {
        if (StringHelper::startsWith($sKey, 'CATALOG_TIMER_')) {
            $sKey = StringHelper::cut(
                $sKey,
                StringHelper::length('CATALOG_')
            );
            $arElement['PARAMETERS'][$sKey] = $mValue;

            continue;
        }

        if (StringHelper::startsWith($sKey, 'ORDER_FAST_') || StringHelper::startsWith($sKey, 'GALLERY_VIDEO_')) {
            $arElement['PARAMETERS'][$sKey] = $mValue;
        } else if (StringHelper::startsWith($sKey, $sPrefix)) {
            $sKey = StringHelper::cut(
                $sKey,
                StringHelper::length($sPrefix)
            );

            if ($sKey === 'TEMPLATE')
                continue;

            if (StringHelper::startsWith($sKey, 'ORDER_FAST_'))
                continue;

            $arElement['PARAMETERS'][$sKey] = $mValue;
        }
    }

    foreach ($arResult['PARAMETERS']['COMMON'] as $sProperty)
        $arElement['PARAMETERS'][$sProperty] = ArrayHelper::getValue($arParams, $sProperty);


    foreach($arParams['PRICE_CODE'] as $sPrice) {
        if (!empty($sPrice))
            $arElement['PARAMETERS']['PROPERTY_OLD_PRICE_'.$sPrice] = $arParams['PROPERTY_OLD_PRICE_'.$sPrice];
    }

    if (isset($arElement['PARAMETERS']['ORDER_FAST_USE']))
        $arElement['PARAMETERS']['ORDER_FAST_USE'] = Properties::get('catalog-detail-fast-order-show') ? 'Y' : 'N';

    $arElement['PARAMETERS'] = ArrayHelper::merge($arElement['PARAMETERS'], [
        'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
        'IBLOCK_ID' => $arParams['IBLOCK_ID'],
        'PROPERTY_CODE' => $arParams['DETAIL_PROPERTY_CODE'],
        'META_KEYWORDS' => $arParams['DETAIL_META_KEYWORDS'],
        'META_DESCRIPTION' => $arParams['DETAIL_META_DESCRIPTION'],
        'BROWSER_TITLE' => $arParams['DETAIL_BROWSER_TITLE'],
        'SET_CANONICAL_URL' => $arParams['DETAIL_SET_CANONICAL_URL'],
        'BASKET_URL' => $arParams['BASKET_URL'],
        'ACTION_VARIABLE' => $arParams['ACTION_VARIABLE'],
        'PRODUCT_ID_VARIABLE' => $arParams['PRODUCT_ID_VARIABLE'],
        'SECTION_ID_VARIABLE' => $arParams['SECTION_ID_VARIABLE'],
        'CHECK_SECTION_ID_VARIABLE' => $arParams['DETAIL_CHECK_SECTION_ID_VARIABLE'],
        'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
        'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
        'CACHE_TYPE' => $arParams['CACHE_TYPE'],
        'CACHE_TIME' => $arParams['CACHE_TIME'],
        'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
        'SET_TITLE' => $arParams['SET_TITLE'],
        'SET_LAST_MODIFIED' => $arParams['SET_LAST_MODIFIED'],
        'MESSAGE_404' => $arParams['MESSAGE_404'],
        'SET_STATUS_404' => $arParams['SET_STATUS_404'],
        'SHOW_404' => $arParams['SHOW_404'],
        'FILE_404' => $arParams['FILE_404'],
        'PRICE_CODE' => $arParams['PRICE_CODE'],
        'USE_PRICE_COUNT' => $arParams['USE_PRICE_COUNT'],
        'SHOW_PRICE_COUNT' => $arParams['SHOW_PRICE_COUNT'],
        'PRICE_VAT_INCLUDE' => $arParams['PRICE_VAT_INCLUDE'],
        'PRICE_VAT_SHOW_VALUE' => $arParams['PRICE_VAT_SHOW_VALUE'],
        'USE_PRODUCT_QUANTITY' => $arParams['DETAIL_COUNTER_SHOW'],
        'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
        'PARTIAL_PRODUCT_PROPERTIES' => $arParams['PARTIAL_PRODUCT_PROPERTIES'],
        'LINK_IBLOCK_TYPE' => $arParams['LINK_IBLOCK_TYPE'],
        'LINK_IBLOCK_ID' => $arParams['LINK_IBLOCK_ID'],
        'LINK_PROPERTY_SID' => $arParams['LINK_PROPERTY_SID'],
        'LINK_ELEMENTS_URL' => $arParams['LINK_ELEMENTS_URL'],
        'USE_MAIN_ELEMENT_SECTION' => $arParams['USE_MAIN_ELEMENT_SECTION'],
        'STRICT_SECTION_CHECK' => $arParams['DETAIL_STRICT_SECTION_CHECK'],
        'SHOW_DEACTIVATED' => $arParams['SHOW_DEACTIVATED'],
        'TIMER_SHOW' => $arParams[$sPrefix.'TIMER_SHOW'],

        'HIDE_NOT_AVAILABLE_OFFERS' => $arParams['HIDE_NOT_AVAILABLE_OFFERS'],
        'PRODUCT_DISPLAY_MODE' => 'Y',
        'PRODUCT_PROPERTIES' => $arParams['PRODUCT_PROPERTIES'],
        'OFFER_TREE_PROPS' => $arParams['DETAIL_OFFERS_PROPERTY_CODE'],
        'OFFERS_CART_PROPERTIES' => $arParams['OFFERS_CART_PROPERTIES'],
        'OFFERS_FIELD_CODE' => $arParams['DETAIL_OFFERS_FIELD_CODE'],
        'OFFERS_PROPERTY_CODE' => $arParams['DETAIL_OFFERS_PROPERTY_CODE'],
        'OFFERS_SORT_FIELD' => $arParams['OFFERS_SORT_FIELD'],
        'OFFERS_SORT_ORDER' => $arParams['OFFERS_SORT_ORDER'],
        'OFFERS_SORT_FIELD2' => $arParams['OFFERS_SORT_FIELD2'],
        'OFFERS_SORT_ORDER2' => $arParams['OFFERS_SORT_ORDER2'],
        'OFFERS_PROPERTY_PICTURE_DIRECTORY' => $arParams['OFFERS_PROPERTY_PICTURE_DIRECTORY'],
        'OFFERS_VARIABLE_SELECT' => $arParams['OFFERS_VARIABLE_SELECT'],

        'ELEMENT_ID' => !empty($arResult['VARIABLES']['ELEMENT_ID']) ? $arResult['VARIABLES']['ELEMENT_ID'] : null,
        'ELEMENT_CODE' => !empty($arResult['VARIABLES']['ELEMENT_CODE']) ? $arResult['VARIABLES']['ELEMENT_CODE'] : null,
        'SECTION_ID' => !empty($arResult['VARIABLES']['SECTION_ID']) ? $arResult['VARIABLES']['SECTION_ID'] : null,
        'SECTION_CODE' => !empty($arResult['VARIABLES']['SECTION_CODE']) ? $arResult['VARIABLES']['SECTION_CODE'] : null,
        'TAB' => !empty($arResult['VARIABLES']['TAB']) ? $arResult['VARIABLES']['TAB'] : null,
        'SECTION_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['section'],
        'DETAIL_URL' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['element'],
        'TAB_URL' => !empty($arResult['URL_TEMPLATES']['tab']) ? $arResult['FOLDER'].$arResult['URL_TEMPLATES']['tab'] : null,

        'CURRENCY_ID' => $arParams['CURRENCY_ID'],
        'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],

        'USE_COMPARE' => $arParams['USE_COMPARE'],
        'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
        'COMPARE_NAME' => $arParams['COMPARE_NAME'],

        'ADD_SECTIONS_CHAIN' => $arParams['ADD_SECTIONS_CHAIN'],
        'ADD_ELEMENT_CHAIN' => $arParams['ADD_ELEMENT_CHAIN'],

        'DISABLE_INIT_JS_IN_COMPONENT' => $arParams['DISABLE_INIT_JS_IN_COMPONENT'],
        'SET_VIEWED_IN_COMPONENT' => $arParams['DETAIL_SET_VIEWED_IN_COMPONENT'],

        'WIDE' => 'Y',

        'USE_STORE' => $arParams['USE_STORE'],
        'STORES' => $arParams["STORES"],
        'STORE_PATH' => $arParams["STORE_PATH"],
        'USE_MIN_AMOUNT' => $arParams["USE_MIN_AMOUNT"],
        'MIN_AMOUNT' => $arParams["MIN_AMOUNT"],
        'SHOW_EMPTY_STORE' => $arParams["SHOW_EMPTY_STORE"],
        'SHOW_GENERAL_STORE_INFORMATION' => $arParams["SHOW_GENERAL_STORE_INFORMATION"],
        'MAIN_TITLE' => $arParams["MAIN_TITLE"],
        'FIELDS' => $arParams["FIELDS"],
        'USE_GIFTS_DETAIL' => $arParams['USE_GIFTS_DETAIL'],
        'GIFTS_DETAIL_PAGE_ELEMENT_COUNT' => $arParams['GIFTS_DETAIL_PAGE_ELEMENT_COUNT'],
        'STORE_BLOCK_DESCRIPTION_USE' => $arParams['STORE_BLOCK_DESCRIPTION_USE'],
        'STORE_BLOCK_DESCRIPTION_TEXT' => $arParams['STORE_BLOCK_DESCRIPTION_TEXT'],
        'SHOW_SKU_DESCRIPTION' => $arParams['SHOW_SKU_DESCRIPTION'],
        'COMPATIBLE_MODE' => $arParams['COMPATIBLE_MODE']
    ]);
}

if (Loader::includeModule('intec.seo')) {
    $arArticlesExtending = [
        'SHOW' => $bSeo,
        'PROPERTY' => ArrayHelper::getValue($arParams, 'SECTIONS_ARTICLES_EXTENDING_PROPERTY'),
        'TEMPLATE' => ArrayHelper::getValue($arParams, 'SECTIONS_ARTICLES_EXTENDING_TEMPLATE'),
        'TITLE' => ArrayHelper::getValue($arParams, 'SECTIONS_ARTICLES_EXTENDING_TITLE'),
        'QUANTITY' => ArrayHelper::getValue($arParams, 'SECTIONS_ARTICLES_EXTENDING_QUANTITY'),
        'PARAMETERS' => []
    ];

    if (empty($arArticlesExtending['TEMPLATE']))
        $arArticlesExtending['SHOW'] = false;

    if ($arArticlesExtending['SHOW']) {
        $sPrefix = 'SECTIONS_ARTICLES_EXTENDING_';
        $arArticlesExtending['TEMPLATE'] = 'news.'.$arArticlesExtending['TEMPLATE'];

        foreach ($arParams as $sKey => $mValue) {
            if (!StringHelper::startsWith($sKey, $sPrefix))
                continue;

            $sKey = StringHelper::cut(
                $sKey,
                StringHelper::length($sPrefix)
            );

            if ($sKey === 'TEMPLATE')
                continue;

            $arArticlesExtending['PARAMETERS'][$sKey] = $mValue;
        }

        $arArticlesExtending['PARAMETERS'] = ArrayHelper::merge($arArticlesExtending['PARAMETERS'], [
            'SECTION_USER_FIELDS' => array(),
            'SET_TITLE' => 'N',
            'ADD_SECTIONS_CHAIN' => 'N',
            'SET_BROWSER_TITLE' => 'N',
            'INCLUDE_IBLOCK_INTO_CHAIN' => 'N',
            'CURRENCY_ID' => $arParams['CURRENCY_ID'],
            'CONSENT_URL' => $arParams['CONSENT_URL'],
            'COMPARE_NAME' => $arParams['COMPARE_NAME'],
            'USE_COMPARE' => $arParams['USE_COMPARE'],
            'WIDE' => 'Y'
        ]);
    }
}