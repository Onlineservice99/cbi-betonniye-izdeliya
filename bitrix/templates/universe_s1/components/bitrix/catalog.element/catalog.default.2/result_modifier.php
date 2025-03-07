<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\helpers\ArrayHelper;
use intec\core\helpers\StringHelper;
use intec\template\Properties;

/**
 * @var array $arResult
 * @var array $arParams
 * @var CBitrixComponentTemplate $this
 */

if (!Loader::includeModule('intec.core'))
    return;

$arMacros = [
    'SITE_DIR' => SITE_DIR,
    'SITE_TEMPLATE_PATH' => SITE_TEMPLATE_PATH.'/'
];

$bBase = false;
$bLite = false;

if (Loader::includeModule('catalog') && Loader::includeModule('sale'))
    $bBase = true;
else if (Loader::includeModule('intec.startshop'))
    $bLite = true;

$bMeasures = false;

if ($bBase && Loader::includeModule('intec.measures'))
    $bMeasures = true;

$arParams = ArrayHelper::merge([
    'PROPERTY_MARKS_HIT' => null,
    'PROPERTY_MARKS_NEW' => null,
    'PROPERTY_MARKS_RECOMMEND' => null,
    'PROPERTY_MARKS_SHARE' => null,
    'PROPERTY_ARTICLE' => null,
    'PROPERTY_BRAND' => null,
    'PROPERTY_ADDITIONAL' => null,
    'PROPERTY_PICTURES' => null,
    'PROPERTY_TAB_META_TITLE' => null,
    'PROPERTY_TAB_META_CHAIN' => null,
    'PROPERTY_TAB_META_KEYWORDS' => null,
    'PROPERTY_TAB_META_DESCRIPTION' => null,
    'PROPERTY_TAB_META_BROWSER_TITLE' => null,
    'PROPERTY_ARTICLES' => null,
    'ARTICLES_SHOW' => 'N',
    'ARTICLES_NAME' => null,
    'PROPERTY_DOCUMENTS' => null,
    'PROPERTY_VIDEO' => null,
    'PROPERTY_ASSOCIATED' => null,
    'PROPERTY_RECOMMENDED' => null,
    'PROPERTY_ACCESSORIES' => null,
    'PRODUCTS_ACCESSORIES_SHOW' => 'N',
    'PROPERTY_SERVICES' => null,
    'PROPERTY_SIZES_SHOW' => null,
    'PROPERTY_ORDER_USE' => null,
    'OFFERS_PROPERTY_ARTICLE' => null,
    'OFFERS_PROPERTY_PICTURES' => null,
    'ARTICLE_SHOW' => 'Y',
    'ADDITIONAL_SHOW' => 'N',
    'BRAND_SHOW' => 'N',
    'VIDEO_IBLOCK_TYPE' => null,
    'VIDEO_IBLOCK_ID' => null,
    'VIDEO_PROPERTY_URL' => 'LINK',
    'REVIEWS_IBLOCK_TYPE' => null,
    'REVIEWS_IBLOCK_ID' => 	null,
    'REVIEWS_PROPERTY_ELEMENT_ID' => null,
    'REVIEWS_MAIL_EVENT' => null,
    'REVIEWS_USE_CAPTCHA' => 'Y',
    'REVIEWS_SHOW' => 'Y',
    'DELAY_USE' => 'N',
    'PRICE_EXTENDED' => 'N',
    'PRICE_RANGE' => 'N',
    'PRICE_DIFFERENCE' => 'N',
    'LAZYLOAD_USE' => 'N',
    'DELIVERY_CALCULATION_USE' => 'N',
    'DELIVERY_CALCULATION_TEMPLATE' => null,
    'VIEW' => 'wide',
    'VIEW_TABS_POSITION' => 'top',
    'PANEL_SHOW' => 'N',
    'PANEL_MOBILE_SHOW' => 'N',
    'VOTE_SHOW' => 'Y',
    'VOTE_MODE' => 'rating',
    'QUANTITY_SHOW' => 'Y',
    'QUANTITY_MODE' => 'number',
    'ACTION' => 'none',
    'SERVICES_SHOW' => 'Y',
    'DOCUMENTS_SHOW' => 'Y',
    'ASSOCIATED_SHOW' => 'Y',
    'RECOMMENDED_SHOW' => 'Y',
    'SERVIES_SHOW' => 'N',
    'MARKS_SHOW' => 'Y',
    'GALLERY_SHOW' => 'Y',
    'GALLERY_ZOOM' => 'Y',
    'GALLERY_POPUP' => 'Y',
    'GALLERY_PANEL' => 'Y',
    'GALLERY_PREVIEW' => 'Y',
    'GALLERY_VIDEO_USE' => 'N',
    'COUNTER_SHOW' => 'Y',
    'COUNTER_MESSAGE_MAX_SHOW' => 'Y',
    'STORES_SHOW' => 'Y',
    'SETS_SHOW' => 'Y',
    'PROPERTIES_DETAIL_SHOW' => 'Y',
    'OFFERS_PROPERTIES_SHOW' => 'Y',
    'OFFERS_PROPERTIES_PREVIEW_COUNT' => 2,
    'OFFERS_PROPERTIES_DELIMITER' => ',',
    'TABS_ANIMATION_USE' => 'N',
    'INFORMATION_PAYMENT_SHOW' => 'N',
    'INFORMATION_PAYMENT_PATH' => null,
    'INFORMATION_SHIPMENT_SHOW' => 'N',
    'INFORMATION_SHIPMENT_PATH' => null,
    'SIZES_SHOW' => 'N',
    'SIZES_MODE' => null,
    'SIZES_PATH' => null,
    'BASKET_URL' => null,
    'CONSENT_URL' => null,
    'USE_STORE' => 'N',
    'PRINT_SHOW' => 'N',
    'PROPERTY_ADVANTAGES' => null,
    'ADVANTAGES_SHOW' => 'N',
    'FORM_CHEAPER_SHOW' => 'N',
    'FORM_CHEAPER_ID' => null,
    'FORM_CHEAPER_PROPERTY_PRODUCT' => null,
    'FORM_MARKDOWN_SHOW' => 'N',
    'FORM_MARKDOWN_ID' => null,
    'FORM_MARKDOWN_PROPERTY_PRODUCT' => null,
    'PRICE_CREDIT_SHOW' => 'N',
    'PRICE_CREDIT_DURATION' => null,
    'RECALCULATION_PRICE_CREDIT_USE' => 'N',
    'PRICE_CREDIT_LINK_USE' => "N",
    'PRICE_CREDIT_LINK' => null,
    'MEASURES_USE' => 'N',
    'WIDE' => 'Y',
    'RECALCULATION_PRICES_USE' => 'N',
    'TIMER_SHOW' => 'N',
    'TIMER_TIMER_QUANTITY_OVER' => 'Y'
], $arParams);

$arVisual = [
    'LAZYLOAD' => [
        'USE' => $arParams['LAZYLOAD_USE'] === 'Y',
        'STUB' => !defined('EDITOR') && $arParams['LAZYLOAD_USE'] === 'Y' ? Properties::get('template-images-lazyload-stub') : null
    ],
    'ARTICLE' => [
        'SHOW' => $arParams['ARTICLE_SHOW'] === 'Y'
    ],
    'BRAND' => [
        'SHOW' => $arParams['BRAND_SHOW'] === 'Y'
    ],
    'COUNTER' => [
        'SHOW' => $arParams['COUNTER_SHOW'] === 'Y',
        'MESSAGE' => [
            'MAX' => [
                'SHOW' => $arParams['COUNTER_MESSAGE_MAX_SHOW'] === 'Y'
            ]
        ]
    ],
    'QUANTITY' => [
        'SHOW' => ArrayHelper::getValue($arParams, 'QUANTITY_SHOW') === 'Y',
        'MODE' => ArrayHelper::fromRange(['number', 'text', 'logic'], ArrayHelper::getValue($arParams, 'QUANTITY_MODE')),
        'BOUNDS' => [
            'FEW' => ArrayHelper::getValue($arParams, 'QUANTITY_BOUNDS_FEW'),
            'MANY' => ArrayHelper::getValue($arParams, 'QUANTITY_BOUNDS_MANY')
        ]
    ],
    'STORES' => [
        'SHOW' => $arParams['USE_STORE'] === 'Y' && $arParams['STORES_SHOW'] === 'Y'
    ],
    'SETS' => [
        'SHOW' => $arParams['SETS_SHOW'] === 'Y'
    ],
    'MARKS' => [
        'SHOW' => $arParams['MARKS_SHOW'] === 'Y'
    ],
    'GALLERY' => [
        'SHOW' => $arParams['GALLERY_SHOW'] === 'Y',
        'ZOOM' => $arParams['GALLERY_ZOOM'] === 'Y',
        'POPUP' => $arParams['GALLERY_POPUP'] === 'Y',
        'PANEL' => $arParams['GALLERY_PANEL'] === 'Y',
        'PREVIEW' => $arParams['GALLERY_PREVIEW'] === 'Y',
        'VIDEO' => [
            'USE' => $arParams['GALLERY_VIDEO_USE'] === 'Y',
            'CONTROLS' => $arParams['GALLERY_VIDEO_CONTROLS_SHOW'] === 'Y',
            'ELEMENTS' => []
        ]
    ],
    'PRICE' => [
        'SHOW' => true,
        'EXTENDED' => $arParams['PRICE_EXTENDED'] === 'Y',
        'RANGE' => $arParams['PRICE_RANGE'] === 'Y',
        'DIFFERENCE' => $arParams['PRICE_DIFFERENCE'] === 'Y',
        'RECALCULATION' => $arParams['RECALCULATION_PRICES_USE'] === 'Y'
    ],
    'DESCRIPTION' => [
        'PREVIEW' => [
            'SHOW' => $arParams['DESCRIPTION_PREVIEW_SHOW'] === 'Y'
        ],
        'DETAIL' => [
            'SHOW' => $arParams['DESCRIPTION_DETAIL_SHOW'] === 'Y'
        ]
    ],
    'SIZES' => [
        'SHOW' => $arParams['SIZES_SHOW'] === 'Y',
        'PATH' => $arParams['SIZES_PATH'],
        'MODE' => ArrayHelper::fromRange([
            'all',
            'element'
        ], $arParams['SIZES_MODE'])
    ],
    'PROPERTIES' => [
        'PREVIEW' => [
            'SHOW' => $arParams['PROPERTIES_PREVIEW_SHOW'] === 'Y',
            'COUNT' => $arParams['PROPERTIES_PREVIEW_COUNT'],
        ],
        'DETAIL' => [
            'SHOW' => $arParams['PROPERTIES_DETAIL_SHOW'] === 'Y'
        ]
    ],
    'ADDITIONAL' => [
        'SHOW' => $arParams['ADDITIONAL_SHOW'] === 'Y'
    ],
    'DOCUMENTS' => [
        'SHOW' => $arParams['DOCUMENTS_SHOW'] === 'Y'
    ],
    'VIDEO' => [
        'SHOW' => $arParams['VIDEO_SHOW'] === 'Y'
    ],
    'REVIEWS' => [
        'SHOW' => $arParams['REVIEWS_SHOW'] === 'Y'
    ],
    'ASSOCIATED' => [
        'SHOW' => $arParams['ASSOCIATED_SHOW'] === 'Y'
    ],
    'ARTICLES' => [
        'SHOW' => $arParams['ARTICLES_SHOW'] === 'Y',
        'NAME' => $arParams['ARTICLES_NAME']
    ],
    'RECOMMENDED' => [
        'SHOW' => $arParams['RECOMMENDED_SHOW'] === 'Y'
    ],
    'ACCESSORIES' => [
        'SHOW' => $arParams['PRODUCTS_ACCESSORIES_SHOW'] === 'Y' && !empty($arParams['PROPERTY_ACCESSORIES']),
        'NAME' => $arParams['PRODUCTS_ACCESSORIES_NAME'],
        'VIEW' => ArrayHelper::fromRange(['list', 'tile', 'link'], $arParams['PRODUCTS_ACCESSORIES_VIEW']),
        'LINK' => null,
    ],
    'SERVICES' => [
        'SHOW' => $arParams['SERVICES_SHOW'] === 'Y'
    ],
    'INFORMATION' => [
        'PAYMENT' => [
            'SHOW' => $arParams['INFORMATION_PAYMENT_SHOW'] === 'Y',
            'PATH' => $arParams['INFORMATION_PAYMENT_PATH']
        ],
        'SHIPMENT' => [
            'SHOW' => $arParams['INFORMATION_SHIPMENT_SHOW'] === 'Y',
            'PATH' => $arParams['INFORMATION_SHIPMENT_PATH']
        ]
    ],
    'VIEW' => [
        'VALUE' => ArrayHelper::fromRange([
            'wide',
            'narrow',
            'tabs'
        ], $arParams['VIEW'])
    ],
    'WIDE' => $arParams['WIDE'] === 'Y',
    'PANEL' => [
        'DESKTOP' => [
            'SHOW' => $arParams['PANEL_SHOW'] === 'Y'
        ],
        'MOBILE' => [
            'SHOW' => $arParams['PANEL_MOBILE_SHOW'] === 'Y'
        ]
    ],
    'VOTE' => [
        'SHOW' => ArrayHelper::getValue($arParams, 'VOTE_SHOW') === 'Y',
        'MODE' => ArrayHelper::fromRange([
            'average',
            'rating'
        ], $arParams['VOTE_MODE'])
    ],
    'FORM' => [
        'SHOW' => $arParams['FORM_SHOW'] === 'Y'
    ],
    'TABS' => [
        'ANIMATION' => $arParams['TABS_ANIMATION_USE'] === 'Y'
    ],
    'PRINT' => [
        'SHOW' => $arParams['PRINT_SHOW'] === 'Y'
    ],
    'ADVANTAGES' => [
        'SHOW' => $arParams['ADVANTAGES_SHOW'] === 'Y'
    ],
    'BUTTONS' => [
        'BASKET' => [
            'TEXT' => $arParams['PURCHASE_BASKET_BUTTON_TEXT']
        ],
        'ORDER' => [
            'TEXT' => $arParams['PURCHASE_ORDER_BUTTON_TEXT']
        ],
        'REQUEST' => [
            'TEXT' => $arParams['PURCHASE_REQUEST_BUTTON_TEXT']
        ]
    ],
    'MEASURES' => [
        'USE' => $arParams['MEASURES_USE'] === 'Y'
    ],
    'MENU' => [
        'SHOW' => $arResult['ORIGINAL_PARAMETERS']['MENU_SHOW'] === 'Y'
    ],
    'CREDIT' => [
        'SHOW' => $arParams['PRICE_CREDIT_SHOW'] === 'Y',
        'DURATION' => $arParams['PRICE_CREDIT_DURATION'],
        'RECALCULATION'=> $arParams['RECALCULATION_PRICE_CREDIT_USE'] === 'Y' && $arParams['RECALCULATION_PRICES_USE'] === 'Y',
        'LINK' => [
            'USE' => $arParams['PRICE_CREDIT_LINK_USE'] === 'Y',
            'VALUE' => $arParams['PRICE_CREDIT_LINK']
        ]
    ],
    'TIMER' => [
        'SHOW' => $arParams['TIMER_SHOW'] === 'Y',
        'TIMER_QUANTITY_OVER' => $arParams['TIMER_TIMER_QUANTITY_OVER'] === 'Y'
    ],
    'OFFERS' => [
        'PROPERTIES' => [
            'SHOW' => $arParams['OFFERS_PROPERTIES_SHOW'] === 'Y',
            'COUNT' => !empty($arParams['OFFERS_PROPERTIES_PREVIEW_COUNT']) ? $arParams['OFFERS_PROPERTIES_PREVIEW_COUNT'] : 0,
            'DELIMITER' => !empty($arParams['OFFERS_PROPERTIES_DELIMITER']) ? $arParams['OFFERS_PROPERTIES_DELIMITER'] : ','
        ]
    ],
    'DEACTIVATED' => [
        'SHOW' => $arParams['SHOW_DEACTIVATED'] === 'Y'
    ]
];

if (empty($arVisual['BUTTONS']['BASKET']['TEXT']))
    $arVisual['BUTTONS']['BASKET']['TEXT'] = Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_PURCHASE_ORDER');

if (empty($arVisual['BUTTONS']['ORDER']['TEXT']))
    $arVisual['BUTTONS']['ORDER']['TEXT'] = Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_PURCHASE_FORM_ORDER');

if ($arVisual['VIEW']['VALUE'] === 'tabs') {
    $arVisual['VIEW']['POSITION'] = ArrayHelper::fromRange([
        'top',
        'bottom'
    ], $arParams['VIEW_TABS_POSITION']);
}

if($arVisual['CREDIT']['SHOW'] && !empty($arVisual['CREDIT']['DURATION'])) {

    if(is_numeric($arVisual['CREDIT']['DURATION'])){
        if($arVisual['CREDIT']['DURATION'] < 2)
            $arVisual['CREDIT']['DURATION'] = 2;
    }
    else {
        $arVisual['CREDIT']['DURATION'] = 2;
    }
}

if($arVisual['CREDIT']['LINK']['USE'])
    if(empty($arVisual['CREDIT']['LINK']['VALUE']))
        $arVisual['CREDIT']['LINK']['USE'] = false;

if ($arVisual['SIZES']['SHOW'] && $arVisual['SIZES']['MODE'] === 'element') {
    $arVisual['SIZES']['SHOW'] = ArrayHelper::getValue($arResult, [
        'PROPERTIES',
        $arParams['PROPERTY_SIZES_SHOW'],
        'VALUE'
    ]);

    $arVisual['SIZES']['SHOW'] = !empty($arVisual['SIZES']['SHOW']);

    if (empty($arVisual['SIZES']['PATH']))
        $arVisual['SIZES']['SHOW'] = false;
}

if (empty($arVisual['INFORMATION']['PAYMENT']['PATH']))
    $arVisual['INFORMATION']['PAYMENT']['SHOW'] = false;

if (empty($arVisual['INFORMATION']['SHIPMENT']['PATH']))
    $arVisual['INFORMATION']['SHIPMENT']['SHOW'] = false;

if (empty($arResult['PREVIEW_TEXT']))
    $arVisual['DESCRIPTION']['PREVIEW']['SHOW'] = false;

if (empty($arResult['DETAIL_TEXT']))
    $arVisual['DESCRIPTION']['DETAIL']['SHOW'] = false;

if ($arVisual['ACCESSORIES']['SHOW'] && $arVisual['ACCESSORIES']['VIEW'] === 'link') {
    if (!empty($arParams['PRODUCTS_ACCESSORIES_LINK']))
        $arVisual['ACCESSORIES']['LINK'] = $arParams['PRODUCTS_ACCESSORIES_LINK'];
    else
        $arVisual['ACCESSORIES']['SHOW'] = false;

    if ($arVisual['ACCESSORIES']['SHOW']) {
        if (!empty($arParams['PRODUCTS_ACCESSORIES_LINK_REQUEST_NAME']))
            $sAccessoriesRequest = $arParams['PRODUCTS_ACCESSORIES_LINK_REQUEST_NAME'];
        else
            $sAccessoriesRequest = 'PRODUCT_ID';

        $arVisual['ACCESSORIES']['LINK'] = $arVisual['ACCESSORIES']['LINK'] . '?' . $sAccessoriesRequest . '=' . $arResult['ID'];
    }
}

$arResult['ACCESSORIES'] = [
    'VALUES' => []
];

if ($arVisual['ACCESSORIES']['SHOW']) {
    if (ArrayHelper::keyExists($arParams['PROPERTY_ACCESSORIES'], $arResult['PROPERTIES'])) {
        if (!empty($arResult['PROPERTIES'][$arParams['PROPERTY_ACCESSORIES']]['VALUE'])) {
            $arResult['ACCESSORIES']['VALUES'] = $arResult['PROPERTIES'][$arParams['PROPERTY_ACCESSORIES']]['VALUE'];
        }
    }

    if (empty($arResult['ACCESSORIES']['VALUES']))
        $arVisual['ACCESSORIES']['SHOW'] = false;
}

$arResult['ACTION'] = ArrayHelper::fromRange([
    'none',
    'buy',
    'order',
    'request'
], $arParams['ACTION']);

if ($arResult['ACTION'] === 'buy' || $arResult['ACTION'] === 'order') {
    $arRequestUse = ArrayHelper::getValue($arResult['PROPERTIES'], [
        $arParams['PROPERTY_REQUEST_USE'],
        'VALUE'
    ]);

    $arOrderUse = ArrayHelper::getValue($arResult['PROPERTIES'], [
        $arParams['PROPERTY_ORDER_USE'],
        'VALUE'
    ]);

    if (!empty($arOrderUse))
        $arResult['ACTION'] = 'order';

    if (!empty($arRequestUse))
        $arResult['ACTION'] = 'request';

    unset($arRequestUse, $arOrderUse);
}

$arResult['COMPARE'] = [
    'USE' => $arParams['USE_COMPARE'] === 'Y',
    'CODE' => $arParams['COMPARE_NAME']
];

if (empty($arResult['COMPARE']['CODE']))
    $arResult['COMPARE']['USE'] = false;

$arResult['DELAY'] = [
    'USE' => $arParams['DELAY_USE'] === 'Y'
];

$arResult['URL'] = [
    'BASKET' => $arParams['BASKET_URL'],
    'CONSENT' => $arParams['CONSENT_URL']
];

foreach ($arResult['URL'] as $sKey => $sUrl)
    $arResult['URL'][$sKey] = StringHelper::replaceMacros($sUrl, $arMacros);

if ($bLite) {
    $arResult['DELAY']['USE'] = false;
    $arVisual['STORES']['SHOW'] = false;
    $arVisual['SETS']['SHOW'] = false;

    include(__DIR__.'/modifiers/lite/catalog.php');
}

include(__DIR__.'/modifiers/fields.php');
include(__DIR__.'/modifiers/pictures.php');
include(__DIR__.'/modifiers/order.fast.php');
include(__DIR__.'/modifiers/shares.php');
include(__DIR__.'/modifiers/marks.php');
include(__DIR__.'/modifiers/services.php');

if ($arVisual['TIMER']['SHOW']) {
    include(__DIR__.'/modifiers/timer.php');
}

if ($bBase)
    include(__DIR__.'/modifiers/delivery.calculation.php');

if (empty($arResult['ADDITIONAL']))
    $arVisual['ADDITIONAL']['SHOW'] = false;

if (empty($arResult['DOCUMENTS']))
    $arVisual['DOCUMENTS']['SHOW'] = false;

if (empty($arResult['VIDEO']))
    $arVisual['VIDEO']['SHOW'] = false;

if (empty($arResult['ARTICLES']) || empty($arParams['ARTICLES_IBLOCK_ID']))
    $arVisual['ARTICLES']['SHOW'] = false;

if (empty($arResult['ASSOCIATED']))
    $arVisual['ASSOCIATED']['SHOW'] = false;


if (empty($arResult['RECOMMENDED']))
    $arVisual['RECOMMENDED']['SHOW'] = false;

if (empty($arResult['ADVANTAGES']))
    $arVisual['ADVANTAGES']['SHOW'] = false;

include(__DIR__.'/modifiers/tab.php');

if ($bBase)
    include(__DIR__.'/modifiers/base/catalog.php');

if ($bBase || $bLite)
    include(__DIR__.'/modifiers/catalog.php');

include(__DIR__.'/modifiers/properties.php');

if (empty($arResult['DISPLAY_PROPERTIES'])) {
    $arVisual['PROPERTIES']['PREVIEW']['SHOW'] = false;
    $arVisual['PROPERTIES']['DETAIL']['SHOW'] = false;
} else {
    if ($arVisual['PROPERTIES']['PREVIEW']['SHOW']) {
        $arVisual['PROPERTIES']['PREVIEW']['SHOW'] = false;

        foreach ($arResult['DISPLAY_PROPERTIES'] as &$arProperty)
            if (empty($arProperty['USER_TYPE'])) {
                $arVisual['PROPERTIES']['PREVIEW']['SHOW'] = true;
                break;
            }

        unset($arProperty);
    }
}

$arResult['SECTIONS'] = [];

if ($arVisual['DESCRIPTION']['DETAIL']['SHOW'])
    $arResult['SECTIONS']['DESCRIPTION'] = ['PRINT'=>true];


if ($arVisual['STORES']['SHOW'])
    $arResult['SECTIONS']['STORES'] = [];

if ($arVisual['PROPERTIES']['DETAIL']['SHOW'])
    $arResult['SECTIONS']['PROPERTIES'] = ['PRINT'=>true];

if ($arVisual['ARTICLES']['SHOW'])
    $arResult['SECTIONS']['ARTICLES'] = [];

if ($arVisual['DOCUMENTS']['SHOW'])
    $arResult['SECTIONS']['DOCUMENTS'] = [];

if ($arVisual['VIDEO']['SHOW'])
    $arResult['SECTIONS']['VIDEO'] = [];

if ($arVisual['REVIEWS']['SHOW'])
    $arResult['SECTIONS']['REVIEWS'] = [];

$bSectionFirst = true;


foreach ($arResult['SECTIONS'] as $sCode => &$arSection) {
    $arSection = ArrayHelper::merge([
        'CODE' => StringHelper::toLowerCase($sCode),
        'NAME' => Loc::getMessage('C_CATALOG_ELEMENT_CATALOG_DEFAULT_2_SECTIONS_'.$sCode)
    ], $arSection, [
        'ACTIVE' => $bSectionFirst,
        'URL' => null
    ]);

    if ($arResult['TAB']['USE']) {
        $arSection['URL'] = $bSectionFirst ?
            $arResult['DETAIL_PAGE_URL'] :
            StringHelper::replaceMacros($arResult['TAB']['URL']['TEMPLATE'], [
                'TAB' => $arSection['CODE']
            ]);
    }

    if ($bSectionFirst)
        $bSectionFirst = false;
}

unset($bSectionFirst);

if ($arResult['TAB']['USE'] && !empty($arResult['TAB']['VALUE']) && isset($arResult['SECTIONS'][$arResult['TAB']['VALUE']])) {
    $arTab = $arResult['SECTIONS'][$arResult['TAB']['VALUE']];

    foreach ($arResult['TAB']['META'] as $sKey => $sValue) {
        if (!empty($sValue))
            $arResult['TAB']['META'][$sKey] = StringHelper::replaceMacros($sValue, [
                'TAB' => $arTab['NAME']
            ]);
    }

    if (!empty($arResult['TAB']['META']['TITLE']))
        $arResult['META_TAGS']['TITLE'] = $arResult['TAB']['META']['TITLE'];

    if (!empty($arResult['TAB']['META']['BROWSER_TITLE']))
        $arResult['META_TAGS']['BROWSER_TITLE'] = $arResult['TAB']['META']['BROWSER_TITLE'];

    if (!empty($arResult['TAB']['META']['CHAIN']))
        $arResult['META_TAGS']['ELEMENT_CHAIN'] = $arResult['TAB']['META']['CHAIN'];

    if (!empty($arResult['TAB']['META']['KEYWORDS']))
        $arResult['META_TAGS']['KEYWORDS'] = $arResult['TAB']['META']['TITLE'];

    if (!empty($arResult['TAB']['META']['DESCRIPTION']))
        $arResult['META_TAGS']['DESCRIPTION'] = $arResult['TAB']['META']['DESCRIPTION'];

    unset($arTab, $sKey, $sValue);
}

$arResult['FORM']['TITLE'] = $arParams['FORM_TITLE'];
$arResult['FORM']['FORM_1_ID'] = $arParams['FORM_1_ID'];
$arResult['FORM']['FORM_2_ID'] = $arParams['FORM_2_ID'];
$arResult['FORM']['FORM_1_NAME'] = $arParams['FORM_1_NAME'];
$arResult['FORM']['FORM_2_NAME'] = $arParams['FORM_2_NAME'];
$arResult['FORM']['FORM_1_BUTTON_TEXT'] = $arParams['FORM_1_BUTTON_TEXT'];
$arResult['FORM']['FORM_2_BUTTON_TEXT'] = $arParams['FORM_2_BUTTON_TEXT'];
$arResult['FORM']['DESCRIPTION'] = $arParams['FORM_DESCRIPTION'];
$arResult['FORM']['IMAGE'] = $arParams['FORM_IMAGE'];
$arResult['FORM']['ORDER'] = [
    'SHOW' => $arResult['ACTION'] === 'order',
    'ID' => $arParams['FORM_ID'],
    'TEMPLATE' => $arParams['FORM_TEMPLATE'],
    'PROPERTIES' => [
        'PRODUCT' => $arParams['FORM_PROPERTY_PRODUCT']
    ]
];
$arResult['FORM']['REQUEST'] = [
    'SHOW' => $arResult['ACTION'] === 'request',
    'ID' => $arParams['FORM_REQUEST_ID'],
    'TEMPLATE' => $arParams['FORM_REQUEST_TEMPLATE'],
    'PROPERTIES' => [
        'PRODUCT' => $arParams['FORM_REQUEST_PROPERTY_PRODUCT']
    ]
];
$arResult['FORM']['CHEAPER'] = [
    'SHOW' => $arParams['FORM_CHEAPER_SHOW'] === 'Y',
    'ID' => $arParams['FORM_CHEAPER_ID'],
    'TEMPLATE' => $arParams['FORM_CHEAPER_TEMPLATE'],
    'PROPERTIES' => [
        'PRODUCT' => $arParams['FORM_CHEAPER_PROPERTY_PRODUCT']
    ]
];

if (empty($arResult['FORM']['REQUEST']['ID'])) {
    $arResult['FORM']['REQUEST']['SHOW'] = false;
}

if (empty($arResult['FORM']['CHEAPER']['ID']))
    $arResult['FORM']['CHEAPER']['SHOW'] = false;

$arResult['FORM']['MARKDOWN'] = [
    'SHOW' => $arParams['FORM_MARKDOWN_SHOW'] === 'Y',
    'ID' => $arParams['FORM_MARKDOWN_ID'],
    'TEMPLATE' => $arParams['FORM_MARKDOWN_TEMPLATE'],
    'PROPERTIES' => [
        'PRODUCT' => $arParams['FORM_MARKDOWN_PROPERTY_PRODUCT']
    ]
];

if (empty($arResult['FORM']['MARKDOWN']['ID']))
    $arResult['FORM']['MARKDOWN']['SHOW'] = false;

$arResult['SKU_VIEW'] = ArrayHelper::fromRange([
    'dynamic',
    'list'
], $arParams['SKU_VIEW']);

if (!empty($arResult['OFFERS']) && $arResult['SKU_VIEW'] == 'list') {
    $arVisual['PANEL']['DESKTOP']['SHOW'] = false;
    $arVisual['PANEL']['MOBILE']['SHOW'] = false;
    $arVisual['STORES']['SHOW'] = false;
}

if (!$bMeasures)
    $arVisual['MEASURES']['USE'] = false;

if ($arVisual['MEASURES']['USE'])
    include(__DIR__.'/modifiers/measures.php');

if ($arVisual['GALLERY']['VIDEO']['USE'])
    include(__DIR__.'/modifiers/video.php');

if ($arResult['ACTION'] !== 'buy') {
    $arResult['DELAY']['USE'] = false;
    $arResult['ORDER_FAST']['USE'] = false;
    $arVisual['COUNTER']['SHOW'] = false;
    $arVisual['ADDITIONAL']['SHOW'] = false;

    if ($arResult['ACTION'] === 'request') {
        $arResult['DELIVERY_CALCULATION']['USE'] = false;
        $arResult['FORM']['CHEAPER']['SHOW'] = false;
        $arResult['FORM']['MARKDOWN']['SHOW'] = false;
        $arVisual['ADDITIONAL']['SHOW'] = false;
        $arVisual['CREDIT']['SHOW'] = false;
        $arVisual['MEASURES']['USE'] = false;
        $arVisual['PRICE']['SHOW'] = false;
        $arVisual['PRICE']['RECALCULATION'] = false;
        $arVisual['TIMER']['SHOW'] = false;
    }
}

$arResult['VISUAL'] = $arVisual;

$this->getComponent()->setResultCacheKeys(['SECTIONS', 'VISUAL', 'PREVIEW_PICTURE', 'DETAIL_PICTURE']);

unset($arVisual);