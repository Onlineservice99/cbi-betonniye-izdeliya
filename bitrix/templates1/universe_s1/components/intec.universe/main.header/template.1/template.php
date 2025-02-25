<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die() ?>
<?php

use Bitrix\Main\Loader;
use intec\Core;
use intec\core\bitrix\Component;
use intec\core\bitrix\component\InnerTemplate;
use intec\core\helpers\Html;
use intec\core\helpers\JavaScript;

/**
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

/** @var InnerTemplate[] $arTemplates */
$arTemplates = $arResult['TEMPLATES'];
$sTemplateId = Html::getUniqueId(null, Component::getUniqueId($this));
$arData = [
    'id' => $sTemplateId,
    'folder' => $templateFolder
];
$sSiteUrl = Core::$app->request->getHostInfo().SITE_DIR;

$arVisual = $arResult['VISUAL'];

$this->setFrameMode(true);

?>
<?= Html::beginTag('div', [
    'id' => $sTemplateId,
    'class' => Html::cssClassFromArray([
        'vcard' => true,
        'widget' => [
            '' => true,
            'transparent' => $arVisual['TRANSPARENCY']
        ],
        'c-header' => [
            '' => true,
            'template-1' => true
        ]
    ], true),
    'data' => [
        'transparent' => $arVisual['TRANSPARENCY'] ? 'true' : 'false'
    ]
]) ?>
    <div class="widget-content">
        <div style="display: none;">
            <span class="url">
                <span class="value-title" title="<?= $sSiteUrl ?>"></span>
            </span>
            <span class="fn org">
                <?= $arResult['COMPANY_NAME'] ?>
            </span>
            <img class="photo" src="<?= $sSiteUrl.'include/logotype.png' ?>" alt="<?= $arResult['COMPANY_NAME'] ?>" />
        </div>
        <?php if (!empty($arTemplates['DESKTOP'])) { ?>
            <div class="widget-view widget-view-desktop">
                <?php $arData['type'] = 'DESKTOP' ?>
                <?php $arData['selector'] = '.widget-view.widget-view-desktop' ?>
                <?= $arTemplates['DESKTOP']->render(
                    $arParams,
                    $arResult,
                    $arData
                ) ?>
            </div>
            <div class="widget-overlay" data-role="overlay-desktop"></div>
        <?php } ?>
        <?php if (!defined('EDITOR') && !empty($arTemplates['FIXED'])) { ?>
            <div class="widget-view widget-view-fixed" data-role="top-menu">
                <?php $arData['type'] = 'FIXED' ?>
                <?php $arData['selector'] = '.widget-view.widget-view-fixed' ?>
                <?= $arTemplates['FIXED']->render(
                    $arParams,
                    $arResult,
                    $arData
                ) ?>
                <div class="widget-overlay" data-role="overlay-fixed"></div>
            </div>
        <?php } ?>
        <?php if (!defined('EDITOR') && !empty($arTemplates['MOBILE'])) { ?>
            <?php if ($arResult['REGIONALITY']['USE']) { ?>
                <div data-role="header-mobile-region-select"></div>
            <?php } ?>
            <?= Html::beginTag('div', [
                'class' => Html::cssClassFromArray([
                    'widget-view' => true,
                    'widget-view-mobile' => true
                ], true)
            ]) ?>
                <?php $arData['type'] = 'MOBILE' ?>
                <?php $arData['selector'] = '.widget-view.widget-view-mobile' ?>
                <?= $arTemplates['MOBILE']->render(
                    $arParams,
                    $arResult,
                    $arData
                ) ?>
            <?= Html::endTag('div') ?>
        <?php } ?>
        <?php if (!defined('EDITOR') && (!empty($arTemplates['FIXED']) || !empty($arTemplates['MOBILE']))) { ?>
            <script type="text/javascript">
                template.load(function (data) {
                    var _ = this.getLibrary('_');
                    var $ = this.getLibrary('$');

                    var root = data.nodes;
                    var area = $(window);
                    var parts = {
                        'desktop': {
                            'node': $('.widget-view.widget-view-desktop', root)
                        }
                    };

                    <?php if (!empty($arTemplates['FIXED'])) { ?>
                        parts.fixed = {
                            'isDisplay': false,
                            'node': undefined
                        };

                        parts.fixed.handle = function () {
                            var self = parts.fixed;
                            var bound = 0;

                            if (parts.desktop.node.is(':visible')) {
                                bound += parts.desktop.node.height();
                                bound += parts.desktop.node.offset().top;
                            }

                            if (area.scrollTop() > bound) {
                                self.show();
                            } else {
                                self.hide();
                            }
                        };

                        parts.fixed.handleThrottle = _.throttle(parts.fixed.handle, 250, {
                            'leading': false
                        });

                        parts.fixed.initialize = function () {
                            var self = parts.fixed;

                            self.node = $('.widget-view.widget-view-fixed', root);
                            self.node.css({
                                'display': 'none',
                                'top': -self.node.height()
                            });

                            self.handle();
                        };

                        parts.fixed.hide = function () {
                            var self = parts.fixed;

                            if (!self.isDisplay)
                                return;

                            self.isDisplay = false;
                            self.node.stop().animate({
                                'top': -self.node.height()
                            }, 500, function () {
                                self.node.css({
                                    'display': 'none'
                                });
                            });
                        };

                        parts.fixed.show = function () {
                            var self = parts.fixed;

                            if (self.isDisplay)
                                return;

                            self.isDisplay = true;
                            self.node.css({
                                'display': 'block'
                            }).stop().animate({
                                'top': 0
                            }, 500);
                        };
                    <?php } ?>

                    <?php if (!empty($arTemplates['MOBILE']) && $arResult['MOBILE']['FIXED']) { ?>
                        parts.mobile = {
                            'isDisplay': true,
                            'isFixed': false,
                            'scroll': 0,
                            'stub': undefined
                        };

                        parts.mobile.fix = function () {
                            var self = parts.mobile;

                            if (!self.isFixed) {
                                self.isFixed = true;

                                self.stub = $('<div></div>');
                                self.stub.css({
                                    'height': self.node.height()
                                });

                                self.node.after(self.stub);
                                self.node.addClass('widget-view-mobile-fixed');
                                self.hide(false);
                            }
                        };

                        parts.mobile.handle = function (event) {
                            var self = parts.mobile;
                            var bound = 0;
                            var scroll = area.scrollTop();

                            if (self.node.is(':visible')) {
                                if (self.stub !== undefined) {
                                    bound += self.stub.offset().top;
                                } else {
                                    bound += self.node.offset().top;
                                }

                                if (scroll > bound) {
                                    self.fix();
                                    self.refresh();

                                    <?php if ($arResult['MOBILE']['HIDDEN']) { ?>
                                        if (event && event.type === 'scroll') {
                                            if (scroll > self.scroll) {
                                                if (scroll > (bound + self.node.height())) {
                                                    self.hide(true);
                                                } else {
                                                    self.show(true);
                                                }
                                            } else {
                                                self.show(true);
                                            }
                                        } else {
                                            self.show(true);
                                        }

                                        self.scroll = scroll;
                                    <?php } else { ?>
                                        self.show(true);
                                    <?php } ?>
                                } else {
                                    self.unfix();
                                }
                            } else {
                                self.unfix();
                            }
                        };

                        parts.mobile.handleThrottle = _.throttle(parts.mobile.handle, 100, {
                            'leading': false
                        });

                        parts.mobile.hide = function (animate) {
                            var self = parts.mobile;

                            if (!self.isDisplay)
                                return;

                            self.isDisplay = false;

                            if (animate) {
                                self.node.stop().animate({
                                    'top': -self.node.height()
                                }, {
                                    'duration': 250,
                                    'complete': function () {
                                        self.node.css({
                                            'top': -self.node.height()
                                        });
                                    }
                                });
                            } else {
                                self.node.stop().css('top', -self.node.height());
                            }
                        };

                        parts.mobile.initialize = function () {
                            var self = parts.mobile;

                            self.node = $('.widget-view.widget-view-mobile', root);
                            self.scroll = area.scrollTop();
                            self.handle();
                        };

                        parts.mobile.refresh = function () {
                            var self = parts.mobile;

                            if (self.stub !== undefined) {
                                self.stub.css({
                                    'height': self.node.height()
                                });
                            }
                        };

                        parts.mobile.show = function (animate) {
                            var self = parts.mobile;

                            if (self.isDisplay)
                                return;

                            self.isDisplay = true;

                            if (animate) {
                                self.node.stop().animate({
                                    'top': 0
                                }, {
                                    'duration': 250,
                                    'complete': function () {
                                        self.node.css({
                                            'top': ''
                                        });
                                    }
                                });
                            } else {
                                self.node.stop().css('top', '');
                            }
                        };

                        parts.mobile.unfix = function () {
                            var self = parts.mobile;

                            if (self.isFixed) {
                                self.isFixed = false;

                                self.stub.remove();
                                self.stub = undefined;

                                self.node.removeClass('widget-view-mobile-fixed');
                                self.show(false);
                            }
                        };
                    <?php } ?>

                    <?php if (!empty($arTemplates['FIXED']) && !empty($arTemplates['MOBILE']) && $arResult['MOBILE']['FIXED']) { ?>
                        parts.fixed.initialize();
                        parts.mobile.initialize();

                        area.on('resize scroll', function (event) {
                            parts.fixed.handleThrottle(event);
                            parts.mobile.handleThrottle(event);
                        });
                    <?php } else if (!empty($arTemplates['FIXED'])) { ?>
                        parts.fixed.initialize();

                        area.on('resize scroll', parts.fixed.handleThrottle);
                    <?php } else if (!empty($arTemplates['MOBILE']) && $arResult['MOBILE']['FIXED']) { ?>
                        parts.mobile.initialize();

                        area.on('resize scroll', parts.mobile.handleThrottle);
                    <?php } ?>
                }, {
                    'name': '[Component] intec.universe:main.header (template.1)',
                    'nodes': <?= JavaScript::toObject('#'.$sTemplateId) ?>
                });
            </script>
        <?php } ?>
        <?php if (!empty($arTemplates['BANNER'])) { ?>
            <div class="widget-banner">
                <?php $arData['type'] = 'BANNER' ?>
                <?= $arTemplates['BANNER']->render(
                    $arParams,
                    $arResult,
                    $arData
                ) ?>
            </div>
        <?php } ?>
    </div>
<?= Html::endTag('div') ?>
<style>
	#whatsapp-circle {
		position: fixed;
		bottom: 160px;
		right: 20px;
		width: 80px;
		height: 80px;
		background-color: #25D366;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
		z-index: 1000;
		transition: transform 0.2s ease;
		cursor: pointer;
	}
	@media(max-width:720px){
		#whatsapp-circle{bottom: 126px;}
	}
	#whatsapp-circle:hover {
		transform: scale(1.1);
	}

	#whatsapp-circle img {
		width: 30px;
		height: 30px;
	}
</style>

<div id="whatsapp-circle">
	<a href="https://wa.me/79201279887" target="_blank" style="display: flex;">
		<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0,0,256,256">
			<g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(10.66667,10.66667)"><path d="M12.01172,2c-5.506,0 -9.98823,4.47838 -9.99023,9.98438c-0.001,1.76 0.45998,3.47819 1.33398,4.99219l-1.35547,5.02344l5.23242,-1.23633c1.459,0.796 3.10144,1.21384 4.77344,1.21484h0.00391c5.505,0 9.98528,-4.47937 9.98828,-9.98437c0.002,-2.669 -1.03588,-5.17841 -2.92187,-7.06641c-1.886,-1.887 -4.39245,-2.92673 -7.06445,-2.92773zM12.00977,4c2.136,0.001 4.14334,0.8338 5.65234,2.3418c1.509,1.51 2.33794,3.51639 2.33594,5.65039c-0.002,4.404 -3.58423,7.98633 -7.99023,7.98633c-1.333,-0.001 -2.65341,-0.3357 -3.81641,-0.9707l-0.67383,-0.36719l-0.74414,0.17578l-1.96875,0.46484l0.48047,-1.78516l0.2168,-0.80078l-0.41406,-0.71875c-0.698,-1.208 -1.06741,-2.58919 -1.06641,-3.99219c0.002,-4.402 3.58528,-7.98437 7.98828,-7.98437zM8.47656,7.375c-0.167,0 -0.43702,0.0625 -0.66602,0.3125c-0.229,0.249 -0.875,0.85208 -0.875,2.08008c0,1.228 0.89453,2.41503 1.01953,2.58203c0.124,0.166 1.72667,2.76563 4.26367,3.76563c2.108,0.831 2.53614,0.667 2.99414,0.625c0.458,-0.041 1.47755,-0.60255 1.68555,-1.18555c0.208,-0.583 0.20848,-1.0845 0.14648,-1.1875c-0.062,-0.104 -0.22852,-0.16602 -0.47852,-0.29102c-0.249,-0.125 -1.47608,-0.72755 -1.70508,-0.81055c-0.229,-0.083 -0.3965,-0.125 -0.5625,0.125c-0.166,0.25 -0.64306,0.81056 -0.78906,0.97656c-0.146,0.167 -0.29102,0.18945 -0.54102,0.06445c-0.25,-0.126 -1.05381,-0.39024 -2.00781,-1.24024c-0.742,-0.661 -1.24267,-1.47656 -1.38867,-1.72656c-0.145,-0.249 -0.01367,-0.38577 0.11133,-0.50977c0.112,-0.112 0.24805,-0.2915 0.37305,-0.4375c0.124,-0.146 0.167,-0.25002 0.25,-0.41602c0.083,-0.166 0.04051,-0.3125 -0.02149,-0.4375c-0.062,-0.125 -0.54753,-1.35756 -0.76953,-1.85156c-0.187,-0.415 -0.3845,-0.42464 -0.5625,-0.43164c-0.145,-0.006 -0.31056,-0.00586 -0.47656,-0.00586z"></path></g></g>
		</svg>
	</a>
</div>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		const whatsappCircle = document.getElementById('whatsapp-circle');
		whatsappCircle.style.opacity = '0';

		setTimeout(function() {
			whatsappCircle.style.opacity = '1';
			whatsappCircle.style.transition = 'opacity 0.5s ease';
		}, 2000);
	});
</script>