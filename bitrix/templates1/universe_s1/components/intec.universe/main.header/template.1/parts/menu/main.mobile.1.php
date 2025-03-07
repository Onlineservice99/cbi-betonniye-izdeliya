<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use intec\core\helpers\ArrayHelper;

$arMenu = $arResult['MENU']['MAIN'];
$arMenuParams = !empty($arMenuParams) ? $arMenuParams : [];

if (!empty($arResult['CONTACTS']['SELECTED']) && $arResult['CONTACTS']['ADVANCED'])
    $sPhoneDisplay = ArrayHelper::shift($arResult['CONTACTS']['SELECTED'])['PHONE']['DISPLAY'];
elseif (!empty($arResult['CONTACTS']['ADVANCED']) && !$arResult['CONTACTS']['ADVANCED'])
    $sPhoneDisplay = ArrayHelper::shift($arResult['CONTACTS']['SELECTED'])['DISPLAY'];
else
    $sPhoneDisplay = '';

?>
<?php $APPLICATION->IncludeComponent(
    'bitrix:menu',
    'mobile.1',
    ArrayHelper::merge([
        'ROOT_MENU_TYPE' => $arMenu['ROOT'],
        'CHILD_MENU_TYPE' => $arMenu['CHILD'],
        'MAX_LEVEL' => $arMenu['LEVEL'],
        'MENU_CACHE_TYPE' => 'N',
        'USE_EXT' => 'Y',
        'DELAY' => 'N',
        'ALLOW_MULTI_SELECT' => 'N',
        'ADDRESS_SHOW' => $arResult['ADDRESS']['SHOW']['MOBILE'] ? 'Y' : 'N',
        'ADDRESS' => $arResult['ADDRESS']['VALUE'],
        'PHONE_SHOW' => $arResult['CONTACTS']['SHOW']['MOBILE'] ? 'Y' : 'N',
        'PHONE' => $sPhoneDisplay,
        'EMAIL_SHOW' => $arResult['EMAIL']['SHOW']['MOBILE'] ? 'Y' : 'N',
        'EMAIL' => $arResult['EMAIL']['VALUE'],
        'LOGOTYPE_SHOW' => $arResult['LOGOTYPE']['SHOW']['MOBILE'] ? 'Y' : 'N',
        'LOGOTYPE' => $arResult['LOGOTYPE']['PATH'],
        'LOGOTYPE_LINK' => $arResult['LOGOTYPE']['LINK']['USE'] ? $arResult['LOGOTYPE']['LINK']['VALUE'] : null,
        'REGIONALITY_USE' => $arResult['REGIONALITY']['USE'] ? 'Y' : 'N',
        'CACHE_SELECTED_ITEMS' => 'N'
    ], $arMenuParams),
    $this->getComponent()
); ?>
<?php unset($arMenu) ?>