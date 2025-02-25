<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
use Bitrix\Main\Loader;

if (!Loader::includeModule('iblock')) {
    die('Модуль iblock не подключен');
}

$albumId = intval($_GET['id']);
$photos = []; // Здесь получите фотографии альбома из инфоблока по ID

// Пример получения фотографий
$res = CIBlockElement::GetList([], ['IBLOCK_ID' => 37, 'PROPERTY_ALBUM_ID' => $albumId], false, false, ['ID', 'NAME', 'PREVIEW_PICTURE']);
while ($item = $res->Fetch()) {
    $photos[] = CFile::ResizeImageGet($item['PREVIEW_PICTURE'], ['width' => 600, 'height' => 600], BX_RESIZE_IMAGE_PROPORTIONAL_ALT)['src'];
}

// Генерируем HTML для слайдера
foreach ($photos as $photo) {
    echo '<div class="photo-slider-item"><img src="' . $photo . '" alt=""></div>';
}
?>
