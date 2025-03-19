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
<!-- Кнопка отзывов -->
<div id="rews-circle">
    <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" enable-background="new 0 0 53 53" width="50" height="50" viewBox="0 0 53 53">
        <g id="_x39_1" fill="#ffffff">
            <path d="m7.5009766 50.5h37.9970703c2.7568359 0 5-2.2426758 5-4.9995117.0000381-1.5091934.0008163-31.7683067.0009766-38.0009766 0-2.7568359-2.2431641-4.9995117-5-4.9995117h-37.9970704c-2.7638831 0-5.0009765 2.2502542-5.0009765 5.0029297v37.9975586c0 2.7568359 2.243164 4.9995117 5 4.9995117zm37.9970703-2h-37.9970703c-1.6542969 0-3-1.3457031-3-2.9995117v-33.6411133h43.9970703v33.6411133c0 1.6538086-1.3457031 2.9995117-3 2.9995117zm-40.9960938-41.0004883c0-1.6540413 1.3486047-2.9960938 2.9990234-2.9960938h37.9970703c1.6542969 0 3 1.3457031 3 2.9995117v2.3564454h-43.9960937z"/><path d="m8.4990234 30.9790039h7.5566406c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1h-7.5566406c-.5527344 0-1 .4477539-1 1s.4472657 1 1 1z"/><path d="m8.4990234 16.8588867h7.5566406c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1h-7.5566406c-.5527344 0-1 .4477539-1 1s.4472657 1 1 1z"/><path d="m8.4990234 21.565918h7.5566406c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1h-7.5566406c-.5527344 0-1 .4477539-1 1s.4472657 1 1 1z"/><path d="m8.4990234 26.2724609h7.5566406c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1h-7.5566406c-.5527344 0-1 .4477539-1 1s.4472657 1 1 1z"/><path d="m44.4941406 28.9790039h-7.5566406c-.5527344 0-1 .4477539-1 1s.4472656 1 1 1h7.5566406c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1z"/><path d="m44.4941406 14.8588867h-7.5566406c-.5527344 0-1 .4477539-1 1s.4472656 1 1 1h7.5566406c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1z"/><path d="m44.4941406 19.565918h-7.5566406c-.5527344 0-1 .4477539-1 1s.4472656 1 1 1h7.5566406c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1z"/><path d="m44.4941406 24.2724609h-7.5566406c-.5527344 0-1 .4477539-1 1s.4472656 1 1 1h7.5566406c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1z"/><path d="m10.1181641 6.1796875h-.3955078c-.5527344 0-1 .4477539-1 1s.4472656 1 1 1h.3955078c.5527344 0 1-.4477539 1-1s-.4472657-1-1-1z"/><path d="m14.0283203 6.1796875h-.3955078c-.5527344 0-1 .4477539-1 1s.4472656 1 1 1h.3955078c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1z"/><path d="m17.9394531 6.1796875h-.3955078c-.5527344 0-1 .4477539-1 1s.4472656 1 1 1h.3955078c.5527344 0 1-.4477539 1-1s-.4472656-1-1-1z"/><path d="m41.5849609 6.1796875h-17.4013671c-.5527344 0-1 .4477539-1 1s.4472656 1 1 1h17.4013672c.5527344 0 1-.4477539 1-1s-.4472657-1-1.0000001-1z"/><path d="m29.2949219 23.2177734h-.3632813c-.1513672 0-.3007813.0341797-.4365234.1005859-1.2099609.5864258-2.7490234.5932617-3.9902344-.0019531-.1347656-.0649414-.2832031-.0986328-.4326172-.0986328h-.3701324c-2.3857269 0-4.3261566 1.9438477-4.3261566 4.3334961v1.5703125c0 .3720703.2070313.7138672.5371094.8862305 4.3669662 2.2829094 8.7982769 2.2914696 13.1708984-.0004883.3300781-.1728516.5361328-.5136719.5361328-.8857422v-1.5703125c0-2.3896484-1.9404297-4.3334961-4.3251953-4.3334961zm2.3251953 5.2861329c-3.4384766 1.6357422-6.7998047 1.6347656-10.2441406-.0009766v-.9516602c0-1.2866211 1.0439453-2.3334961 2.3261566-2.3334961h.152359c1.6591797.7250977 3.6513672.722168 5.2958984 0h.1445313c1.2822113 0 2.3251953 1.046875 2.3251953 2.3334961z"/><path d="m26.5029297 22.3740234c2.0683594 0 3.7509766-1.6884766 3.7509766-3.7636719 0-2.0683594-1.6826172-3.7514648-3.7509766-3.7514648-2.0761719 0-3.7646484 1.6831055-3.7646484 3.7514648 0 2.0751954 1.6884765 3.7636719 3.7646484 3.7636719zm0-5.5151367c.9658203 0 1.7509766.7856445 1.7509766 1.7514648 0 .9726563-.7851563 1.7636719-1.7509766 1.7636719-.9726563 0-1.7646484-.7910156-1.7646484-1.7636719 0-.9658202.7919921-1.7514648 1.7646484-1.7514648z"/><path d="m17.8154297 37.4658203-2.1875-.3183594-.9794922-1.9819336c-.2548828-.5151367-.7705078-.8349609-1.3447266-.8349609s-1.0898438.3198242-1.3447266.8354492l-.9785156 1.980957-2.1962891.3188477c-.5693358.0830078-1.0341796.4741211-1.211914 1.0214844-.1767578.5473633-.03125 1.1367188.3798685 1.5375977l1.5879049 1.5463867-.3720703 2.1762695c-.0957031.5664063.1328125 1.1279297.5986328 1.4658203.4704514.3410339 1.0749359.3782425 1.5761719.1142578l1.9609375-1.027832 1.9580078 1.0263672c.5087891.2675781 1.1171875.222168 1.5800781-.1171875.4648438-.3393555.6923828-.9023438.59375-1.4677734l-.3769531-2.1708984 1.5869141-1.5458984c.4121094-.4018555.5576172-.9912109.3798828-1.5380859s-.6416015-.9379885-1.2099609-1.020508zm-2.3388672 2.8544922c-.3544922.3432617-.5166016.8393555-.4345703 1.3266602.0174341.1001778.2674341 1.5367012.25 1.4365234l-1.2919922-.6767578c-.4394531-.2304688-.9599609-.2275391-1.3916016 0l-1.2978516.6801758.2460938-1.4404297c.0820313-.4868164-.0810547-.9824219-.4326172-1.324707l-1.0498047-1.0219727 1.4521484-.2109375c.4873047-.0698242.9101563-.3759766 1.1308594-.8203125l.6464844-1.309082.6455078 1.3066406c.21875.4448242.6416016.7524414 1.1298828.8227539l1.4453125.2104492z"/><path d="m31.0126953 37.4658203-2.1875-.3183594-.9794922-1.9819336c-.2548828-.5151367-.7705078-.8349609-1.3447266-.8349609s-1.0898438.3198242-1.3447266.8354492l-.9785156 1.980957-2.1962891.3188477c-.5693359.0830078-1.0341797.4741211-1.2119141 1.0214844-.1767578.5473633-.03125 1.1367188.3798828 1.5375977l1.5878906 1.5463867-.3720703 2.1762695c-.1595116.9440498.5800476 1.7529297 1.4775391 1.7529297.2382813 0 .4775391-.0571289.6972656-.1728516l1.9609375-1.027832 1.9580078 1.0263672c.5097656.2675781 1.1171875.222168 1.5800781-.1171875.4648438-.3393555.6923828-.9023438.59375-1.4677734l-.3769531-2.1708984 1.5869141-1.5458984c.4121094-.4018555.5576172-.9912109.3798828-1.5380859s-.6416014-.9379885-1.2099608-1.020508zm-2.3388672 2.8544922c-.3544922.3432617-.5166016.8393555-.4345703 1.3266602.0174351.1001778.2674351 1.5367012.25 1.4365234l-1.2919922-.6767578c-.4355469-.2285156-.9570313-.2285156-1.3925781 0l-1.296875.6796875.2460938-1.4399414c.0820313-.4868164-.0810547-.9824219-.4326172-1.324707l-1.0498047-1.0219727 1.4521484-.2109375c.4873047-.0698242.9101563-.3759766 1.1308594-.8203125l.6464844-1.309082.6455078 1.3066406c.21875.4448242.6416016.7524414 1.1298828.8227539l1.4453125.2104492z"/><path d="m44.2099609 37.4658203-2.1875-.3183594-.9794922-1.9819336c-.2548828-.5151367-.7705078-.8349609-1.3447266-.8349609s-1.0898438.3198242-1.3447266.8354492l-.9785155 1.9809571-2.1962891.3188477c-.5693359.0830078-1.0341797.4741211-1.2119141 1.0214844-.1767578.5473633-.03125 1.1367188.3798828 1.5375977l1.5878906 1.5463867-.3720702 2.1762694c-.1595116.9440498.5800476 1.7529297 1.4775391 1.7529297.2382813 0 .4775391-.0571289.6972656-.1728516l1.9609375-1.027832 1.9580078 1.0263672c.5097656.2675781 1.1162109.222168 1.5800781-.1171875.4648438-.3393555.6923828-.9023438.59375-1.4677734l-.3769531-2.1708984 1.5869141-1.5458984c.4120941-.4018555.5576172-.9912109.3798828-1.5380859s-.6416016-.9379885-1.209961-1.020508zm-2.3388671 2.8544922c-.3544922.3432617-.5166016.8393555-.4345703 1.3266602.0174332.1001778.2674332 1.5367012.25 1.4365234l-1.2919922-.6767578c-.4355469-.2285156-.9570313-.2285156-1.3925781 0l-1.296875.6796875.2460938-1.4399414c.0820313-.4868164-.0810547-.9824219-.4326172-1.324707l-1.0498048-1.0219727 1.4521484-.2109375c.4873047-.0698242.9101563-.3759766 1.1308594-.8203125l.6464844-1.309082.6455078 1.3066406c.21875.4448242.6416016.7524414 1.1298828.8227539l1.4453125.2104492z"/>
        </g>
    </svg>
    <?/*<img src="./images/rews-icons.png" alt="Отзывы">*/?>
</div>

<!-- Блок с картой -->
<div class="map-widget">
    <div class="map-widget-content">
        <iframe src="https://yandex.ru/maps-reviews-widget/223666760898?comments" 
                class="map-iframe"
                allowfullscreen>
        </iframe>
        <a href="https://yandex.ru/maps/org/tsbi/223666760898/" 
           target="_blank" 
           class="map-widget-link">
            ЦБИ на карте Рыбинска — Яндекс Карты
        </a>
        <button class="map-widget-close">×</button>
    </div>
</div>

<style>
/* Кнопка отзывов */
#rews-circle {
    position: fixed;
    bottom: 250px;
    right: 20px;
    width: 80px;
    height: 80px;
    background: #2d6e6e;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    z-index: 1002;
    cursor: pointer;
    transition: all 0.3s ease;
}

#rews-circle:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(0,0,0,0.3);
}

#rews-circle img {
    width: 35px;
    height: 35px;
    transition: transform 0.3s ease;
}

#rews-circle:hover img {
    transform: rotate(-15deg);
}

/* Блок карты */
.map-widget {
    position: fixed;
    top: 0;
    right: -100%;
    width: 100%;
    max-width: 560px;
    height: 100vh;
    background: white;
    z-index: 99999;
    transition: right 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
    box-shadow: -4px 0 20px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
}

.map-widget.active {
    right: 0;
}

.map-widget-content {
    flex: 1;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.map-iframe {
    border: 1px solid #e6e6e6;
    border-radius: 12px;
    width: 100%;
    height: 100%;
}

.map-widget-close {
    position: absolute;
    top: 6px;
    right: 23px;
    font-size: 40px;
    color: #2d6e6e;
    background: none;
    border: none;
    cursor: pointer;
    z-index: 3;
    transition: color 0.3s ease;
}

.map-widget-close:hover {
    color: #255e5e;
}

.map-widget-link {
    position: absolute;
    bottom: 20px;
    left: 0;
    right: 0;
    text-align: center;
    color: #666;
    font-size: 14px;
    padding: 10px;
    z-index: 2;
}

/* Адаптивность */
@media (max-width: 768px) {
    #rews-circle {
        bottom: 218px;
    }
    
    .map-widget {
        max-width: 100%;
        border-radius: 0;
    }
    
    .map-iframe {
        height: 80vh;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Исправленный обработчик клика
    document.getElementById('rews-circle').addEventListener('click', function(e) {
        e.stopPropagation(); // Предотвращаем всплытие события
        const widget = document.querySelector('.map-widget');
        if (!widget.classList.contains('active')) {
            widget.classList.add('active');
            document.body.style.overflow = 'hidden'; // Блокируем скролл
        }
    });
    
    // Закрытие при клике вне области
    document.addEventListener('click', function(e) {
        const widget = document.querySelector('.map-widget');
        const button = document.getElementById('rews-circle');
        
        if (widget.classList.contains('active') && 
            !widget.contains(e.target) && 
            e.target !== button) {
            
            widget.classList.remove('active');
            document.body.style.overflow = ''; // Возвращаем скролл
        }
    });
    
    // Закрытие по кнопке
    document.querySelector('.map-widget-close').addEventListener('click', function(e) {
        e.stopPropagation();
        document.querySelector('.map-widget').classList.remove('active');
        document.body.style.overflow = '';
    });
});
</script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		const whatsappCircle = document.getElementById('rews-circle');
		whatsappCircle.style.opacity = '0';

		setTimeout(function() {
			whatsappCircle.style.opacity = '1';
			whatsappCircle.style.transition = 'opacity 0.5s ease';
		}, 2000);
	});
</script>
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