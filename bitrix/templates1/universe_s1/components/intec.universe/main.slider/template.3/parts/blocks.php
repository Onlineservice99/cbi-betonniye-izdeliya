<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use intec\core\helpers\ArrayHelper;
use intec\core\helpers\Html;

/**
 * @var array $arVisual
 */

?>
<style>
.scroll-container {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 100%;
}
.scroll-container-two{
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 100%;
}
.widget-blocks-items {
    display: flex;
    transition: transform 0.3s ease;
    width: 100%; 
    margin: 0;
    padding: 0; 
}

.widget-block {
    flex: 0 0 100%;
    box-sizing: border-box;
    list-style: none;
    min-width: 50%; 
}

.scroll-prev, .scroll-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 10;
    background: rgba(0,0,0,0.5);
    color: white;
    border: none;
    padding: 10px;
    font-size: 18px;
}

.scroll-prev {
    left: 10px;
}

.scroll-next {
    right: 10px;
}
</style>
<?php return function (&$arBlocks) use (&$arVisual) { ?>
    <?php global $APPLICATION; ?>
    <?php $iBlocksCount = count($arBlocks) ?>
    <?= Html::beginTag('div', [
        'class' => '',
        'style' => [
            'display' => 'flex'
        ]
    ]) ?>
       <?= Html::beginTag('div', [
            'class' => 'widget-blocks',
            'style' => [
                'height' => !empty($arVisual['BLOCKS']['HEIGHT']) ? $arVisual['BLOCKS']['HEIGHT'].'px' : null,
                'width' => '50%'
            ]
        ]) ?>
            <?= Html::beginTag('div', ['class' => 'scroll-container']) ?>
                <?= Html::beginTag('div', [
                    'class' => 'widget-blocks-items',
                    'data' => [
                        'count' => $iBlocksCount,
                        'effect-scale' => $arVisual['BLOCKS']['EFFECT']['SCALE'] ? 'true' : 'false'
                    ]
                ]) ?>
                    <?php foreach ($arBlocks as $arItem) {
                        
                        $arData = $arItem['DATA'];

                        $sTag = !empty($arData['LINK']['VALUE']) ? 'a' : 'div';
                        $sPicture = $arItem['PREVIEW_PICTURE'];

                        if (empty($sPicture))
                            $sPicture = $arItem['DETAIL_PICTURE'];

                        if (!empty($sPicture)) {
                            $sPicture = CFile::ResizeImageGet($sPicture, [
                                'width' => 1024,
                                'height' => 1024
                            ], BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

                            if (!empty($sPicture))
                                $sPicture = $sPicture['src'];
                        }

                        if (empty($sPicture))
                            $sPicture = SITE_TEMPLATE_PATH.'/images/picture.missing.png';

                        $arGrid = [
                            '1' => $arVisual['BLOCKS']['POSITION'] === 'right',
                            '1024' => true,
                            '768-' . $arItem['DATA']['WIDTH'] => true
                        ];

                        if ($arVisual['BLOCKS']['POSITION'] === 'bottom')
                            $arGrid = ArrayHelper::merge([
                                $iBlocksCount => true
                            ], $arGrid);

                    ?>
                        <?= Html::beginTag('div', [
                            'class' => Html::cssClassFromArray([
                                'widget-block' => true,
                                'intec-grid-item' => $arGrid
                            ], true)
                        ]) ?>
                            <?= Html::beginTag($sTag, [
                                'href' => $sTag === 'a' ? $arData['LINK']['VALUE'] : null,
                                'class' => 'widget-block-wrapper',
                                'data-half' => $arItem['DATA']['WIDTH'] == 2 ? 'true' : 'false',
                                'target' => $sTag === 'a' && $arData['LINK']['BLANK'] ? '_blank' : null
                            ]) ?>
                                <?= Html::tag('div', '', [
                                    'class' => 'widget-block-picture',
                                    'data' => [
                                        'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                                        'original' => $arVisual['LAZYLOAD']['USE'] ? $sPicture : null
                                    ],
                                    'style' => [
                                        'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$sPicture.'\')' : null
                                    ]
                                ]) ?>
                                <?php if ($arVisual['BLOCKS']['EFFECT']['FADE']) { ?>
                                    <div class="widget-block-fade"></div>
                                <?php } ?>
                                <div class="widget-block-text">
                                    <?php if (!empty($arItem['PREVIEW_TEXT'])) { ?>
                                        <div class="widget-block-description">
                                            <?= $arItem['PREVIEW_TEXT'] ?>
                                        </div>
                                    <?php } ?>
                                    <div class="widget-block-header">
                                        <?= $arItem['NAME'] ?>
                                    </div>
                                </div>
                            <?= Html::endTag($sTag) ?>
                        <?= Html::endTag('div') ?>
                    <?php } ?>
                <?= Html::endTag('div') ?>
                <?= Html::tag('button', '←', ['class' => 'scroll-prev']) ?>
                <?= Html::tag('button', '→', ['class' => 'scroll-next']) ?>
            <?= Html::endTag('div') ?>
           <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const container = document.querySelector('.scroll-container');
                    const inner = container.querySelector('.widget-blocks-items');
                    const scrollNext = container.querySelector('.scroll-next');
                    const scrollPrev = container.querySelector('.scroll-prev');

                    if (!container || !inner || !scrollNext || !scrollPrev) return;

                    const itemWidth = inner.querySelector('.widget-block').offsetWidth;
                    let scrollPosition = 0;
                    const itemsPerScroll = 1;

                    function updateArrowsVisibility() {
                        const maxScroll = inner.scrollWidth - inner.clientWidth;
                        // Скрываем/показываем стрелки в зависимости от текущей позиции
                        scrollPrev.style.display = scrollPosition > 0 ? 'block' : 'none';
                        scrollNext.style.display = scrollPosition < maxScroll ? 'block' : 'none';
                    }

                    // Инициализация видимости стрелок
                    updateArrowsVisibility();

                    scrollNext.addEventListener('click', () => {
                        const maxScroll = inner.scrollWidth - inner.clientWidth;
                        scrollPosition = Math.min(scrollPosition + itemWidth * itemsPerScroll, maxScroll);
                        inner.style.transform = `translateX(-${scrollPosition}px)`;
                        updateArrowsVisibility();
                    });

                    scrollPrev.addEventListener('click', () => {
                        scrollPosition = Math.max(scrollPosition - itemWidth * itemsPerScroll, 0);
                        inner.style.transform = `translateX(-${scrollPosition}px)`;
                        updateArrowsVisibility();
                    });
                });
            </script>
        <?= Html::endTag('div') ?>
        <?php
        // Получаем элементы инфоблока с ID = 43
        $iblockId = 43;

        $arFilter = ['IBLOCK_ID' => $iblockId, 'ACTIVE' => 'Y'];
        $arSelect = [
            'ID', 'NAME', 'PREVIEW_TEXT', 'DETAIL_TEXT',
            'PREVIEW_PICTURE', 'DETAIL_PICTURE',
            'PROPERTY_LINK', 'PROPERTY_WIDTH'
        ];

        $rsItems = CIBlockElement::GetList(['SORT' => 'ASC'], $arFilter, false, false, $arSelect);
        $arBlocks = [];

        while ($arItem = $rsItems->GetNext()) {
            $arItem['DATA'] = [
                'LINK' => [
                    'VALUE' => $arItem['PROPERTY_LINK_VALUE'] ?? '',
                    'BLANK' => false
                ],
                'WIDTH' => $arItem['PROPERTY_WIDTH_VALUE'] ?? 1
            ];
            $arBlocks[] = $arItem;
        }

        // Теперь используем $arBlocks в цикле
        ?>
        <?= Html::beginTag('div', [
            'class' => 'widget-blocks',
            'style' => [
                'height' => !empty($arVisual['BLOCKS']['HEIGHT']) ? $arVisual['BLOCKS']['HEIGHT'].'px' : null,
                'width' => '50%'
            ]
        ]) ?>
            <?= Html::beginTag('div', ['class' => 'scroll-container-two']) ?>
                <?= Html::beginTag('div', [
                    'class' => 'widget-blocks-items',
                    'data' => [
                        'count' => $iBlocksCount,
                        'effect-scale' => $arVisual['BLOCKS']['EFFECT']['SCALE'] ? 'true' : 'false'
                    ]
                ]) ?>
                <?php foreach ($arBlocks as $arItem) {
                    
                    $arData = $arItem['DATA'];

                    $sTag = !empty($arData['LINK']['VALUE']) ? 'a' : 'div';
                    $sPicture = $arItem['PREVIEW_PICTURE'];

                    if (empty($sPicture))
                        $sPicture = $arItem['DETAIL_PICTURE'];

                    if (!empty($sPicture)) {
                        $sPicture = CFile::ResizeImageGet($sPicture, [
                            'width' => 1024,
                            'height' => 1024
                        ], BX_RESIZE_IMAGE_PROPORTIONAL_ALT);

                        if (!empty($sPicture))
                            $sPicture = $sPicture['src'];
                    }

                    if (empty($sPicture))
                        $sPicture = SITE_TEMPLATE_PATH.'/images/picture.missing.png';

                    $arGrid = [
                        '1' => $arVisual['BLOCKS']['POSITION'] === 'right',
                        '1024' => true,
                        '768-' . $arItem['DATA']['WIDTH'] => true
                    ];

                    if ($arVisual['BLOCKS']['POSITION'] === 'bottom')
                        $arGrid = ArrayHelper::merge([
                            $iBlocksCount => true
                        ], $arGrid);

                ?>
                    <?= Html::beginTag('div', [
                        'class' => Html::cssClassFromArray([
                            'widget-block' => true,
                            'intec-grid-item' => $arGrid
                        ], true)
                    ]) ?>
                        <?= Html::beginTag($sTag, [
                            'href' => $sTag === 'a' ? $arData['LINK']['VALUE'] : null,
                            'class' => 'widget-block-wrapper',
                            'data-half' => $arItem['DATA']['WIDTH'] == 2 ? 'true' : 'false',
                            'target' => $sTag === 'a' && $arData['LINK']['BLANK'] ? '_blank' : null
                        ]) ?>
                            <?= Html::tag('div', '', [
                                'class' => 'widget-block-picture',
                                'data' => [
                                    'lazyload-use' => $arVisual['LAZYLOAD']['USE'] ? 'true' : 'false',
                                    'original' => $arVisual['LAZYLOAD']['USE'] ? $sPicture : null
                                ],
                                'style' => [
                                    'background-image' => !$arVisual['LAZYLOAD']['USE'] ? 'url(\''.$sPicture.'\')' : null
                                ]
                            ]) ?>
                            <?php if ($arVisual['BLOCKS']['EFFECT']['FADE']) { ?>
                                <div class="widget-block-fade"></div>
                            <?php } ?>
                            <div class="widget-block-text">
                                <?php if (!empty($arItem['PREVIEW_TEXT'])) { ?>
                                    <div class="widget-block-description">
                                        <?= $arItem['PREVIEW_TEXT'] ?>
                                    </div>
                                <?php } ?>
                                <div class="widget-block-header">
                                    <?= $arItem['NAME'] ?>
                                </div>
                            </div>
                        <?= Html::endTag($sTag) ?>
                    <?= Html::endTag('div') ?>
                <?php } ?>
                <?= Html::endTag('div') ?>
                <?= Html::tag('button', '←', ['class' => 'scroll-prev']) ?>
                <?= Html::tag('button', '→', ['class' => 'scroll-next']) ?>
            <?= Html::endTag('div') ?>
           <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const container = document.querySelector('.scroll-container-two');
                    const inner = container.querySelector('.widget-blocks-items');
                    const scrollNext = container.querySelector('.scroll-next');
                    const scrollPrev = container.querySelector('.scroll-prev');

                    if (!container || !inner || !scrollNext || !scrollPrev) return;

                    const itemWidth = inner.querySelector('.widget-block').offsetWidth;
                    let scrollPosition = 0;
                    const itemsPerScroll = 1;

                    function updateArrowsVisibility() {
                        const maxScroll = inner.scrollWidth - inner.clientWidth;
                        // Скрываем/показываем стрелки в зависимости от текущей позиции
                        scrollPrev.style.display = scrollPosition > 0 ? 'block' : 'none';
                        scrollNext.style.display = scrollPosition < maxScroll ? 'block' : 'none';
                    }

                    // Инициализация видимости стрелок
                    updateArrowsVisibility();

                    scrollNext.addEventListener('click', () => {
                        const maxScroll = inner.scrollWidth - inner.clientWidth;
                        scrollPosition = Math.min(scrollPosition + itemWidth * itemsPerScroll, maxScroll);
                        inner.style.transform = `translateX(-${scrollPosition}px)`;
                        updateArrowsVisibility();
                    });

                    scrollPrev.addEventListener('click', () => {
                        scrollPosition = Math.max(scrollPosition - itemWidth * itemsPerScroll, 0);
                        inner.style.transform = `translateX(-${scrollPosition}px)`;
                        updateArrowsVisibility();
                    });
                });
            </script>
        <?= Html::endTag('div') ?>
    <?= Html::endTag('div') ?>
        
<?php } ?>

