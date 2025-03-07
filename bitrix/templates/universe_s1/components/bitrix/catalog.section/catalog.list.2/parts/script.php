<?php if (defined('B_PROLOG_INCLUDED') && B_PROLOG_INCLUDED === true) ?>
<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var string $sTemplateId
 * @var string $sTemplateContainer
 * @var array $arVisual
 * @var array $arNavigation
 * @var CBitrixComponent $component
 * @var CBitrixComponentTemplate $this
 */

if ($arResult['BASE'])
    CJSCore::Init(array('currency'));

$oSigner = new \Bitrix\Main\Security\Sign\Signer;
$sSignedTemplate = $oSigner->sign($templateName, 'catalog.section');
$sSignedParameters = $oSigner->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');

?>
    <script type="text/javascript">
        template.load(function (data) {
            var app = this;
            var $ = this.getLibrary('$');
            var _ = this.getLibrary('_');
            var root = data.nodes;
            var properties = root.data('properties');
            var items;
            var component;
            var order;
            var request;
            var quickViewShow;
            var quickItemsId = [];
            var quickItems = Object.create(null);
            var arOfferId = $('[data-role="items"]', root)[0].dataset.filtered;
            var filterApply = arOfferId.length > 0;
            var directoryProperty = '<?= $arParams['OFFERS_PROPERTY_PICTURE_DIRECTORY'] ?>';
            var offerVariableSelect = '<?= $arParams['OFFERS_VARIABLE_SELECT'] ?>';
            var lazyLoadUse = '<?= $arParams['LAZYLOAD_USE'] === 'Y' ? 'true' : 'false' ?>';

            if (!!directoryProperty)
                directoryProperty = 'P_' + directoryProperty;

            <?php if ($arResult['QUICK_VIEW']['USE']) { ?>
            quickViewShow = function (dataItem, quickItemsId) {
                app.api.components.show({
                    'component': 'bitrix:catalog.element',
                    'template': dataItem.template,
                    'parameters': dataItem.parameters,
                    'settings': {
                        'parameters': {
                            'className': 'popup-window-quick-view',
                            'width': null
                        }
                    }
                }).then(function (popup) {
                    <?php if ($arResult['QUICK_VIEW']['SLIDE']['USE']) { ?>
                    var container = $(popup.contentContainer);

                    var indexItem = quickItemsId.indexOf(dataItem.parameters.ELEMENT_ID);
                    var prevItemId = quickItemsId[indexItem - 1];
                    var nextItemId = quickItemsId[indexItem + 1];

                    if (prevItemId === undefined)
                        prevItemId = 0;

                    if (nextItemId === undefined)
                        nextItemId = 0;

                    var load = container.find('.popup-load-container');

                    load.css('display', 'none');

                    container.append('<div class="popup-load-container"><div class="popup-load-whirlpool"></div></div>');

                    if (prevItemId !== 0 || nextItemId !== 0) {
                        container.append('<div class="popup-button btn-prev intec-cl-background-hover" data-role="quickView.button" data-id="' + prevItemId + '">' +
                            '<i class="far fa-angle-left"></i>' +
                            '</div>');
                        container.append('<div class="popup-button btn-next intec-cl-background-hover" data-role="quickView.button" data-id="' + nextItemId + '">' +
                            '<i class="far fa-angle-right"></i>' +
                            '</div>');
                    }
                    <?php } ?>
                });
            };

            <?php if ($arResult['QUICK_VIEW']['SLIDE']['USE']) { ?>
            $('body').on('click', '[data-role="quickView.button"]', function () {
                var item = $(this);
                var id = item.data('id');

                item.parent().find('.popup-load-container').css('display', 'block');

                quickViewShow(quickItems[id], quickItemsId);
            });
            <?php } ?>
            <?php } ?>

            <?php if ($arResult['FORMS']['ORDER']['SHOW']) { ?>
            order = function (data) {
                var options = <?= JavaScript::toObject([
                    'id' => $arResult['FORMS']['ORDER']['ID'],
                    'template' => $arResult['FORMS']['ORDER']['TEMPLATE'],
                    'parameters' => [
                        'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'-form',
                        'CONSENT_URL' => $arResult['URL']['CONSENT']
                    ],
                    'settings' => [
                        'title' => Loc::getMessage('C_CATALOG_SECTION_CATALOG_LIST_2_FORM_TITLE')
                    ]
                ]) ?>;

                options.fields = {};

                <?php if (!empty($arResult['FORMS']['ORDER']['PROPERTIES']['PRODUCT'])) { ?>
                options.fields[<?= JavaScript::toObject($arResult['FORMS']['ORDER']['PROPERTIES']['PRODUCT']) ?>] = data.name;
                <?php } ?>

                app.api.forms.show(options);
                app.metrika.reachGoal('forms.open');
                app.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arResult['FORMS']['ORDER']['ID'].'.open') ?>);
            };
            <?php } ?>
            <?php if ($arResult['FORMS']['REQUEST']['SHOW']) { ?>
            request = function (data) {
                var options = <?= JavaScript::toObject([
                    'id' => $arResult['FORMS']['REQUEST']['ID'],
                    'template' => $arResult['FORMS']['REQUEST']['TEMPLATE'],
                    'parameters' => [
                        'AJAX_OPTION_ADDITIONAL' => $sTemplateId.'-form',
                        'CONSENT_URL' => $arResult['URL']['CONSENT']
                    ],
                    'settings' => [
                        'title' => $arVisual['BUTTONS']['REQUEST']['TEXT']
                    ]
                ]) ?>;

                options.fields = {};

                <?php if (!empty($arResult['FORMS']['REQUEST']['PROPERTIES']['PRODUCT'])) { ?>
                options.fields[<?= JavaScript::toObject($arResult['FORMS']['REQUEST']['PROPERTIES']['PRODUCT']) ?>] = data.name;
                <?php } ?>

                app.api.forms.show(options);
                app.metrika.reachGoal('forms.open');
                app.metrika.reachGoal(<?= JavaScript::toObject('forms.'.$arResult['FORMS']['REQUEST']['ID'].'.open') ?>);
            };
            <?php } ?>

            root.update = function () {
                var handled = [];

                if (!_.isNil(items))
                    handled = items.handled;

                items = $('[data-role="item"]', root);
                items.handled = handled;
                items.each(function () {
                    var item = $(this);
                    var data = item.data('data');
                    var entity = data;
                    var offerProps = item.data('properties');

                    quickItems[data.quickView.parameters.ELEMENT_ID] = data.quickView;
                    quickItemsId.push(data.quickView.parameters.ELEMENT_ID);

                    if (handled.indexOf(this) > -1)
                        return;

                    handled.push(this);
                    item.offers = new app.classes.catalog.Offers({
                        'properties': properties.length !== 0 ? properties : data.properties,
                        'list': data.offers
                    });

                    item.gallery = $('[data-role="item.gallery"]', item);
                    item.counter = $('[data-role="item.counter"]', item);
                    item.price = $('[data-role="item.price"]', item);
                    item.timer = $('[data-role="timer-holder"]', item);
                    item.price.measure = $('[data-role="price.measure"]', item.price);
                    item.price.base = $('[data-role="item.price.base"]', item.price);
                    item.price.discount = $('[data-role="item.price.discount"]', item.price);
                    item.price.percent = $('[data-role="item.price.percent"]', item.price);
                    item.price.total = $('[data-role="item.price.total"]', item);
                    item.order = $('[data-role="item.order"]', item);
                    item.request = $('[data-role="item.request"]', item);
                    item.quantity = app.ui.createControl('numeric', {
                        'node': item.counter,
                        'bounds': {
                            'minimum': entity.quantity.ratio,
                            'maximum': entity.quantity.trace && !entity.quantity.zero ? entity.quantity.value : false
                        },
                        'step': entity.quantity.ratio
                    });
                    item.links = $('[data-role="offer.link"]', item);

                    <?php if ($arResult['QUICK_VIEW']['USE']) { ?>
                    item.quickView = $('[data-role="quick.view"]', item);

                    item.quickView.on('click', function () {
                        quickViewShow(data.quickView, quickItemsId);
                    });
                    <?php } ?>

                    item.update = function () {
                        var price = null;

                        item.attr('data-available', entity.available ? 'true' : 'false');
                        _.each(entity.prices, function (object) {
                            if (object.quantity.from === null || item.quantity.get() >= object.quantity.from)
                                price = object;
                        });

                        if (price !== null) {
                            <?php if ($arResult['BASE'] && $arVisual['PRICE']['RECALCULATION']) { ?>
                            BX.Currency.setCurrencyFormat(price.currency.CURRENCY, price.currency);

                            price.total = price.discount.value * item.quantity.get();
                            price.total = price.total.toFixed(price.currency.DECIMALS);
                            price.total = BX.Currency.currencyFormat(price.total, price.currency.CURRENCY, true);
                            <?php } ?>

                            item.price.attr('data-discount', price.discount.use ? 'true' : 'false');
                            item.price.attr('data-measure', price.discount.measure !== null ? 'true' : 'false');
                            item.price.attr('data-range', entity.price.range ? 'true' : 'false');
                            item.price.measure.text(price.discount.measure);
                            item.price.base.html(price.base.display);
                            item.price.discount.html(price.discount.display);
                            item.price.percent.text('-' + price.discount.percent + '%');
                            item.price.total.html(price.total);
                        } else {
                            item.price.attr('data-discount', 'false');
                            item.price.attr('data-measure', 'false');
                            item.price.attr('data-range', 'false');
                            item.price.base.html(null);
                            item.price.discount.html(null);
                            item.price.percent.text(null);
                        }

                        item.price.attr('data-show', price !== null ? 'true' : 'false');
                        item.quantity.configure({
                            'bounds': {
                                'minimum': entity.quantity.ratio,
                                'maximum': entity.quantity.trace && !entity.quantity.zero ? entity.quantity.value : false
                            },
                            'step': entity.quantity.ratio
                        });

                        item.find('[data-offer]').css('display', '');

                        if (entity !== data) {
                            item.find('[data-offer=' + entity.id + ']').css('display', 'block');
                            item.find('[data-offer="false"]').css('display', 'none');

                            if (item.gallery.filter('[data-offer="' + entity.id + '"]').length === 0)
                                item.gallery.filter('[data-offer="false"]').css('display', 'block');
                        }

                        item.find('[data-basket-id]')
                            .data('basketQuantity', item.quantity.get())
                            .attr('data-basket-quantity', item.quantity.get());

                        <?php if ($arVisual['TIMER']['SHOW']) { ?>
                            timerUpdate(item.timer, entity.id);
                        <?php } ?>
                    };

                    item.update();

                    <?php if ($arResult['FORMS']['ORDER']['SHOW']) { ?>
                        item.order.on('click', function () {
                            order(data);
                        });
                    <?php } ?>
                    <?php if ($arResult['FORMS']['REQUEST']['SHOW']) { ?>
                    item.request.on('click', function () {
                        request(data);
                    });
                    <?php } ?>

                    item.quantity.on('change', function () {
                        item.update();

                        <?php if ($arVisual['COUNTER']['MESSAGE']['MAX']['SHOW']) { ?>
                            var alertElem = $('[data-role="max-message"]', item);
                            var closeIcon = $('[data-role="max-message-close"]', alertElem);

                            if (!item.offers.isEmpty()) {
                                var currentOffer = item.offers.getCurrent();

                                if (currentOffer.available && !currentOffer.quantity.zero && currentOffer.quantity.trace && currentOffer.quantity.value > 0) {
                                    if (item.quantity.get() >= entity.quantity.value) {
                                        $('[data-role="max-message"]', item).fadeIn();
                                    }
                                }
                            } else {
                                if (item.data('available') && !data.quantity.zero && data.quantity.trace && data.quantity.value > 0) {
                                    if (item.quantity.get() >= entity.quantity.value) {
                                        $('[data-role="max-message"]', item).fadeIn();
                                    }
                                }
                            }

                            closeIcon.on('click', function (event) {
                                event.stopPropagation();
                                $('[data-role="max-message"]', item).fadeOut();
                            });

                            $('[data-action="decrement"]', item).on('click', function () {
                                $('[data-role="max-message"]', item).fadeOut();
                            });
                        <?php } ?>
                    });

                    if (!item.offers.isEmpty()) {
                        item.properties = $('[data-role="item.property"]', item);
                        item.properties.values = $('[data-role="item.property.value"]', item.properties);
                        item.properties.attr('data-visible', 'false');
                        item.properties.each(function () {
                            var self = $(this);
                            var property = self.data('property');
                            var values = self.find(item.properties.values);

                            values.each(function () {
                                var self = $(this);
                                var value = self.data('value');

                                self.on('click', function () {
                                    item.offers.setCurrentByValue(property, value);
                                });
                            });
                        });

                        _.each(item.offers.getList(), function (offer) {
                            if (!!directoryProperty) {
                                item.properties.each(function () {
                                    var self = $(this);
                                    var values = self.find(item.properties.values);

                                    values.each(function () {
                                        var value = $(this);

                                        if (self.data('property') === directoryProperty && offer.values[directoryProperty] == value.data('value') && !!offer.img) {
                                            value.find('[data-role="item.property.value.image"]').attr('style', 'background-image: url(' + offer.img + ')');

                                            if (lazyLoadUse === 'true') {
                                                value.find('[data-role="item.property.value.image"]').attr('data-original', offer.img);
                                            }
                                        }
                                    });
                                });
                            }

                            _.each(offer.values, function (value, key) {
                                if (value == 0)
                                    return;

                                item.properties
                                    .filter('[data-property=' + key + ']')
                                    .attr('data-visible', 'true');
                            });
                        });

                        item.offers.on('change', function (event, offer, values) {
                            entity = offer;

                            $('[data-role="max-message"]', item).fadeOut();

                            if (!!offerVariableSelect && item.links.length !== 0) {
                                var currentUrl = new URL(item.links[0].href);
                                var getParamsUrl = currentUrl.searchParams;

                                getParamsUrl.set(offerVariableSelect, offer.id);
                                currentUrl.searchParams = getParamsUrl;

                                item.links.each(function () {
                                    $(this)[0].setAttribute('href', currentUrl.pathname + currentUrl.search);
                                });
                            }

                            _.each(values, function (values, state) {
                                _.each(values, function (values, property) {
                                    property = item.properties.filter('[data-property="' + property + '"]');

                                    _.each(values, function (value) {
                                        value = property.find(item.properties.values).filter('[data-value="' + value + '"]');
                                        value.attr('data-state', state);
                                    });
                                });
                            });

                            item.update();
                        });

                        var offerCurrent;

                        _.each(item.offers.getList(), function (offer) {
                            if (filterApply && arOfferId.includes(offer.id)) {
                                offerCurrent = offer;
                            } else if (!offerCurrent || Number(offerCurrent.sort) > Number(offer.sort)) {
                                offerCurrent = offer;
                            }
                        });

                        item.offers.setCurrentById(offerCurrent.id);
                    }

                });
            };

            BX.message(<?= JavaScript::toObject([
                'BTN_MESSAGE_LAZY_LOAD' => '',
                'BTN_MESSAGE_LAZY_LOAD_WAITER' => ''
            ]) ?>);

            component = new JCCatalogSectionComponent(<?= JavaScript::toObject([
                'siteId' => SITE_ID,
                'componentPath' => $componentPath,
                'navParams' => $arNavigation,
                'deferredLoad' => false,
                'initiallyShowHeader' => false,
                'bigData' => $arResult['BIG_DATA'],
                'lazyLoad' => $arVisual['NAVIGATION']['LAZY']['BUTTON'],
                'loadOnScroll' => $arVisual['NAVIGATION']['LAZY']['SCROLL'],
                'template' => $sSignedTemplate,
                'parameters' => $sSignedParameters,
                'ajaxId' => $arParams['AJAX_ID'],
                'container' => $sTemplateContainer
            ], true) ?>);

            component.processItems = (function () {
                var action = component.processItems;

                return function () {
                    var result = action.apply(this, arguments);

                    root.update();
                    app.api.basket.update();

                    return result;
                };
            })();

            function timerUpdate(timer, id){

                var timerParameters = <?= JavaScript::toObject($arResult['TIMER']['PROPERTIES']) ?>;

                if (!!timerParameters) {
                    timerParameters.parameters.ELEMENT_ID = id;
                    timerParameters.parameters.RANDOMIZE_ID = 'Y';
                    timerParameters.parameters.AJAX_MODE = 'N';

                    app.api.components.get(timerParameters).then(function (content) {
                        timer.html(content);
                    });
                }
            }

            root.update();
        }, {
            'name': '[Component] bitrix:catalog.section (catalog.list.2)',
            'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>,
            'loader': {
                'name': 'lazy'
            }
        });
    </script>
<?php

unset($sSignedParameters);
unset($sSignedTemplate);
unset($oSigner);