<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

/**
 * @var array $arCurrentValues
 */

if (!Loader::includeModule('intec.core'))
    return;

if (Loader::includeModule('form'))
    include('parameters/base.php');
else if (Loader::includeModule('intec.startshop'))
    include('parameters/lite.php');
else
    return;

$arTemplateParameters = [];

$arTemplateParameters['FORM_ID'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_FORM_ID'),
    'TYPE' => 'LIST',
    'VALUES' => $arForms,
    'ADDITIONAL_VALUES' => 'Y',
    'REFRESH' => 'Y'
];

if (!empty($arCurrentValues['FORM_ID'])) {
    $arTemplates = [];

    foreach ($rsTemplates as $arTemplate)
        $arTemplates[$arTemplate['NAME']] = $arTemplate['NAME'].(!empty($arTemplate['TEMPLATE']) ? ' ('.$arTemplate['TEMPLATE'].')' : null);

    $arTemplateParameters['FORM_TEMPLATE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_FORM_TEMPLATE'),
        'TYPE' => 'LIST',
        'VALUES' => $arTemplates,
        'ADDITIONAL_VALUES' => 'Y'
    ];
    $arTemplateParameters['FORM_TITLE'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_FORM_TITLE'),
        'TYPE' => 'STRING'
    ];

    unset($arTemplates, $arTemplate);
}

$arTemplateParameters['SETTINGS_USE'] = [
    'PARENT' => 'BASE',
    'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_SETTINGS_USE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['SETTINGS_USE'] !== 'Y') {
    $arTemplateParameters['CONSENT_SHOW'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_CONSENT_SHOW'),
        'TYPE' => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'Y'
    ];
}

if ($arCurrentValues['CONSENT_SHOW'] === 'Y' || $arCurrentValues['SETTINGS_USE'] === 'Y') {
    $arTemplateParameters['CONSENT_URL'] = [
        'PARENT' => 'BASE',
        'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_CONSENT_URL'),
        'TYPE' => 'STRING',
        'DEFAULT' => '#SITE_DIR#company/consent/'
    ];
}

$arTemplateParameters['WIDE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_WIDE'),
    'TYPE' => 'CHECKBOX',
    'DEFAULT' => 'N',
    'REFRESH' => 'Y'
];

if ($arCurrentValues['WIDE'] !== 'Y') {
    $arTemplateParameters['BORDER_STYLE'] = [
        'PARENT' => 'VISUAL',
        'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_BORDER_STYLE'),
        'TYPE' => 'LIST',
        'VALUES' => [
            'squared' => Loc::getMessage('C_WIDGET_FORM_4_BORDER_STYLE_SQUARED'),
            'rounded' => Loc::getMessage('C_WIDGET_FORM_4_BORDER_STYLE_ROUNDED')
        ],
        'DEFAULT' => 'squared'
    ];
}

$arTemplateParameters['TITLE'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_TITLE'),
    'TYPE' => 'STRING'
];
$arTemplateParameters['DESCRIPTION'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_DESCRIPTION'),
    'TYPE' => 'STRING'
];
$arTemplateParameters['BUTTON_TEXT'] = [
    'PARENT' => 'VISUAL',
    'NAME' => Loc::GetMessage('C_WIDGET_FORM_4_BUTTON'),
    'TYPE' => 'STRING'
];