<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Context;
use Bitrix\Main\Loader;

/**
 * @var array $arParams
 * @var CatalogSectionComponent $component
 */

global $APPLICATION;

if (Loader::includeModule('currency'))
    CJSCore::Init(['currency']);

//	lazy load and big data json answers
$request = Context::getCurrent()->getRequest();

if ($request->isAjaxRequest() && ($request->get('action') === 'showMore' || $request->get('action') === 'deferredLoad')) {
    $content = ob_get_contents();

    ob_end_clean();

    list(, $itemsContainer) = explode('<!-- items-container -->', $content);
    list(, $paginationContainer) = explode('<!-- pagination-container -->', $content);

    if ($arParams['AJAX_MODE'] === 'Y')
        $component->prepareLinks($paginationContainer);

    $component::sendJsonAnswer([
        'items' => $itemsContainer,
        'pagination' => $paginationContainer
    ]);
}