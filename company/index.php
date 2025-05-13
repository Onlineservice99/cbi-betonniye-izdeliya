<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->SetTitle("О компании");


?>
<style>
:root {
	--primary: #2d6e6e;
	--secondary: #f5f5f5;
	--accent: #ffd700;
}

body {
	font-family: 'Segoe UI', sans-serif;
	line-height: 1.6;
	color: #333;
}

.container {
	max-width: 1200px;
	margin: 0 auto;
	padding: 0 20px;
}

.section {
	padding: 20px 20px;
}

.section-title {
	color: var(--primary);
	font-size: 2.5rem;
	text-align: center;
	position: relative;
	margin-bottom: 40px;
	display: flex;
    flex-direction: column;
}

.section-title::after {
	content: '';
	display: block;
	width: 80px;
	height: 3px;
	background: var(--primary);
	margin: 15px auto;
}

.grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(315px, 1fr));
	gap: 30px;
}

.card {
	background: var(--secondary);
	padding: 25px;
	border-radius: 10px;
	box-shadow: 0 4px 10px rgba(0,0,0,0.1);
	transition: transform 0.3s ease;
	margin-bottom: 10px;
}

.card:hover {
	transform: translateY(-5px);
}

.feature {
	text-align: center;
	padding: 40px;
	border-radius: 10px;
	transition: background 0.3s ease;
}

.feature:hover {
	background: var(--primary);
	color: white;
}

.feature-icon {
	font-size: 2.5rem;
	margin-bottom: 20px;
}

.feature-icon h3{
    font-size: 1.7em !important;
}

.feature-icon p{
	font-size: 19px !important;
}

.button {
	background: var(--primary);
	color: white;
	padding: 12px 30px;
	border-radius: 25px;
	display: inline-block;
	transition: background 0.3s ease;
}

.button:hover {
	background: #255e5e;
}

.partners {
	display: flex;
	flex-wrap: wrap;
	gap: 70px;
	justify-content: center;
	padding: 30px;
}

.partner-logo {
	height: 120px;
	filter: grayscale(1);
	transition: filter 0.3s ease;
}

.partner-logo:hover {
	filter: grayscale(0);
}

.timeline {
	position: relative;
	padding: 40px 20px;
}

.timeline::before {
	content: '';
	position: absolute;
	left: 50%;
	top: 0;
	transform: translateX(-50%);
	width: 2px;
	height: 100%;
	background: var(--primary);
}

.timeline-item {
	position: relative;
	margin-bottom: 50px;
}

.timeline-item:last-child {
	margin-bottom: 0;
}

.timeline-content {
	width: 45%;
	padding: 20px;
	background: var(--secondary);
	border-radius: 10px;
	box-shadow: 0 4px 10px rgba(0,0,0,0.1);
	margin-bottom: 9px;
}

.timeline-item:nth-child(odd) .timeline-content {
	margin-left: 55%;
}

.timeline-item:nth-child(even) .timeline-content {
	margin-right: 50%;
}

.timeline-dot {
	position: absolute;
	left: 50%;
	top: 0;
	transform: translate(-50%, -50%);
	width: 20px;
	height: 20px;
	background: var(--primary);
	border-radius: 50%;
	border: 3px solid var(--secondary);
}

@media (max-width: 768px) {
	.timeline::before {
		left: 40px;
	}

	.timeline-content {
		width: 100%;
		margin-left: 0;
		margin-right: 0;
	}

	.timeline-item:nth-child(odd) .timeline-content {
		margin-left: 0;
	}

	.timeline-item:nth-child(even) .timeline-content {
		margin-right: 0;
	}

	.timeline-dot {
		left: 20px;
	}
}

/* Стили для заголовка */
.section-title-wrapper {
    text-align: center;
    padding: 0px 00px 40px 0px;
    position: relative;
    z-index: 2;
}



.divider-line {
    width: 100px;
    height: 3px;
    background: #2d6e6e;
    margin: 15px auto;
    position: relative;
}

.divider-line::before,
.divider-line::after {
    content: '';
    position: absolute;
    top: 0;
    width: 50px;
    height: 1px;
    background: #ddd;
}

.divider-line::before {
    left: -70px;
}

.divider-line::after {
    right: -70px;
}

/* Контейнер изображения */
.image-card-container {
    position: relative;
    max-width: 100%;
    margin: 0 auto;
    overflow: hidden;
}

/* Карточка поверх изображения */
.overlay-card {
	position: absolute;
    top: 13%;
    left: 8%;
    /* transform: translateX(-50%) translateY(-50%); */
    background: #2d6e6e;
    color: white;
    max-width: 350px;
    padding: 30px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    transition: all 0.3s ease;
    z-index: 2;
}

.overlay-card:hover {
	transform: scale(1.02); /* Увеличение секции на 2% */
}

.card-title {
    color: white;
    font-size: 1.5rem;
    margin-bottom: 15px;
	margin-top: 0px;
}

.card-text {
    color: rgba(255,255,255,0.8);
    font-size: 16px;
    line-height: 25px;
    margin-bottom: 20px;
}
.intec-content-wrapper .grid>.card p,
.card-text,
.timeline-item .timeline-content p,
.intec-content .intec-content-wrapper .card>p,
.intec-content-wrapper .grid .feature>p{
    font-size: 16px;
    line-height: 25px;
    font-family: inherit;
}

.card-button {
    background: white;
    color: #2d6e6e;
    padding: 10px 25px;
    border-radius: 25px;
}

.card-button:hover {
    background: rgba(255,255,255,0.8);
    transform: translateY(-2px);
}
.img-comp{
	width:100% !important; 
	height:600px !important; 
	display: block;     
	object-fit: cover;
}
/* Адаптивность */
@media (max-width: 768px) {
    .overlay-card {width: 223px;height: auto;top:27%;padding: 12px;text-align:center;}
	.img-comp{height:400px !important;}
	.card-content p{display:none;}
	.card-title {margin-bottom: 0px;}
}
@media(max-width: 740px){
    .intec-content .intec-content-wrapper{
        margin: 0;
    }
    .intec-content {
        max-width: 100%;
        min-width: 280px;
        box-sizing: border-box;
    }
    .grid{
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    }
}
@media(min-width: 1200px){
    .intec-content-wrapper .grid>.card p,
    .card-text,
    .timeline-item .timeline-content p,
    .intec-content .intec-content-wrapper .card>p,
    .intec-content-wrapper .grid .feature>p{
        font-size: 18px;
        line-height: 27px;
    } 
}

</style>


<section class="elementor-section elementor-top-section elementor-element" style="position: relative;margin-bottom:60px;">
	<div class="intec-content">
		<div class="intec-content-wrapper" style="position: relative;">
			<!-- Заголовок с линиями -->
			<div class="section-title-wrapper">
				<h2 class="section-title" data-aos="fade-up">Наше производство</h2>
				<?/*<div class="divider-line" data-aos="fade-up" data-aos-delay="100"></div>*/?>
			</div>

			<!-- Контейнер слайдера -->
			<div class="swiper-container image-card-container" data-aos="zoom-in">
				<div class="swiper-wrapper">
					<!-- Слайды -->
					<div class="swiper-slide">
						<img src="/upload/iblock/d1e/r8tstoa2cglc4ycpz8ux6pefc5701d5u.jpg" class="img-comp">
					</div>
					<div class="swiper-slide">
						<img src="/upload/iblock/07d/iowmruwrwytki4foq61lrh5s8gnz17wp.jpg" class="img-comp">
					</div>
					<!-- <div class="swiper-slide">
						<img src="/upload/iblock/db2/zcg1yq9qce8751p90wzxlklg5ve7njez.jpg" class="img-comp">
					</div>
					<div class="swiper-slide">
						<img src="/upload/iblock/392/wf9t0xruokttvva33hvubtswkpdft622.jpg" class="img-comp">
					</div> -->

					<div class="swiper-slide">
						<img src="/company/img/slider/1.jpg" class="img-comp">
					</div>
					<div class="swiper-slide">
						<img src="/company/img/slider/2.jpg" class="img-comp">
					</div>
					<div class="swiper-slide">
						<img src="/company/img/slider/3.jpg" class="img-comp">
					</div>
					<div class="swiper-slide">
						<img src="/company/img/slider/4.jpg" class="img-comp">
					</div>
					
					<?/* Заменили 4 фотки, на которые выше
					<div class="swiper-slide">
						<img src="/upload/iblock/a36/bq4wahvngv5aj2vbqvv0p1yu6a3onlbe.jpg" class="img-comp">
					</div>
					<div class="swiper-slide">
						<img src="/upload/iblock/925/h1t4mtzveftss4qoo27zg8fucsxg8amp.jpg" class="img-comp">
					</div>
					<div class="swiper-slide">
						<img src="/upload/iblock/e1a/7ndq0l6mmn8b7uh6nmodoou202vxsupp.jpg" class="img-comp">
					</div>
					<div class="swiper-slide">
						<img src="/upload/iblock/5d3/974yxx4kbvu152ezm9q04e03fkiopm4p.jpg" class="img-comp">
					</div>
					*/?>

					<!-- <div class="swiper-slide">
						<img src="/upload/iblock/d1e/r8tstoa2cglc4ycpz8ux6pefc5701d5u.jpg" class="img-comp">
					</div> -->
				</div>

				<!-- Навигационные стрелки -->
				<div class="swiper-button-next" style="color: #2d6e6e;"></div>
				<div class="swiper-button-prev" style="color: #2d6e6e;"></div>
				
				<!-- Пагинация -->
				<div class="swiper-pagination"></div>
			</div>

			<!-- Карточка поверх изображения -->
			<div class="overlay-card">
				<div class="card-content">
					<h3 class="card-title">Инновационные технологии</h3>
					<p class="card-text">
						Производство с использованием немецкого оборудования 
						FRIMA и автоматизированных линий
					</p>
					<!--<a href="#" class="card-button">Подробнее</a>-->
				</div>
			</div>
		</div>
	</div>
</section>

<script>
    $(document).ready(function(){


        // Инициализация слайдера
        const productionSlider = new Swiper('.image-card-container', {
            loop: true,
            speed: 600,
            autoplay: {
                delay: 5000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                768: {
                    allowTouchMove: true,
                }
            }
        });

    })
</script>


<style>
/* Стили для слайдера */


.swiper-pagination-bullet {
    background: #2d6e6e !important;
    opacity: 0.5;
}

.swiper-pagination-bullet-active {
    opacity: 1 !important;
}

.swiper-button-next,
.swiper-button-prev {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    transition: background 0.3s;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: rgba(255, 255, 255, 1);
}
.swiper-button-next:after, .swiper-rtl .swiper-button-prev:after, .swiper-button-prev:after, .swiper-rtl .swiper-button-next:after {font-size: 20px !important;}
</style>
<section class="section" style="background: var(--secondary); background-size: cover; color: white;">
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<div class="section-title" data-aos="fade-up">
				ООО "ЦБИ"
			</div>
			<div class="grid" data-aos="fade-up" data-aos-delay="200">
				<div class="card" style="background: var(--primary);">
					<h3 style="margin-top: 0px;">20 лет опыта</h3>
					<p>С 2004 года создаем качественные строительные материалы</p>
				</div>
				<div class="card" style="background: var(--primary);">
					<h3 style="margin-top: 0px;">Инновации</h3>
					<p>Технология ColorMix для уникальных цветовых решений</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- История компании -->
<section class="section timeline" data-aos="fade-up">
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<div style="display: flex;justify-content: center;">
				<div class="section-title" style="width: max-content;background: #ffffff;">
					Наша история
				</div>
			</div>
			
			<div class="timeline-item">
				<div class="timeline-dot"></div>
				<div class="timeline-content">
					<h3 style="margin-top: 0px;">2004</h3>
					<p>Начало производства с вибролитой тротуарной плитки и садовых бордюров</p>
				</div>
			</div>
			
			<div class="timeline-item">
				<div class="timeline-dot"></div>
				<div class="timeline-content">
					<h3 style="margin-top: 0px;">2024</h3>
					<p>Официальная регистрация ООО "ЦБИ" как крупного производителя</p>
				</div>
			</div>
			<div class="card" style="background: var(--primary);">
					<p style="margin: 0px;color: #ffffff;">
						ООО «ЦБИ» — это молодая компания, официально основанная в феврале 2024 года. Однако её производственная история началась задолго до этого. В 2004 году компания начала свою деятельность с небольшого производства вибролитой тротуарной плитки и садовых бордюров.<br><br>
						За последние 20 лет она динамично развивалась, постепенно расширяя свои возможности и масштабы. Сегодня ООО «ЦБИ» вышла на уровень крупных производителей, специализирующихся на выпуске тротуарной плитки методом вибропрессования, используя передовые технологии, такие как окраска «ColorMix», позволяющая работать с любыми цветовыми палитрами.
					</p>
			</div>
		</div>
	</div>
</section>
<!-- Секция сертификатов -->
<section class="section" style="background: #f8f9fa;">
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<div class="intec-container">
				<h2 class="section-title">Сертификаты качества</h2>
				
				<!-- Слайдер сертификатов -->
				<div class="certificates-slider" data-aos="fade-up">
					<!-- Сертификат 1 -->
                    <div class="certificate-item">
                        <!-- Изображение с Fancybox для просмотра -->
                        <a href="/company/img/sertificate1.png" target="_blank">
                            <img src="/company/img/sertificate1.png"
                                 class="certificate-image"
                                 alt="Сертификат соответствия 2020">
                        </a>

                        <!-- Отдельная ссылка для скачивания -->
                        <div class="certificate-caption">
                            <a href="/company/img/sertificate1.png"
                               class="certificate-link"
                               download="sertificate1.png"> <!-- Имя файла для сохранения -->
                                Скачать Сертификат
                            </a>
                        </div>
                    </div>

                    <div class="certificate-item">
                        <!-- Изображение с Fancybox для просмотра -->
                        <a href="/company/img/sertificate2.png" target="_blank">
                            <img src="/company/img/sertificate2.png"
                                 class="certificate-image"
                                 alt="Сертификат соответствия 2020">
                        </a>

                        <!-- Отдельная ссылка для скачивания -->
                        <div class="certificate-caption">
                            <a href="/company/img/sertificate2.png"
                               class="certificate-link"
                               download="sertificate2.png"> <!-- Имя файла для сохранения -->
                                Скачать Сертификат
                            </a>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Стили для сертификатов -->
<style>
.certificates-slider {
    padding: 20px;

    display: flex;
    flex-direction: column;
    gap: 15px;
}

.certificate-item {
    text-align: center;
    max-width: 375px;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}
@media(min-width: 576px){
    .certificates-slider{
        flex-direction: row;

        justify-content: center;
    }
    .certificate-item{
        width: calc( 50% - 5px );
    }
}

.certificate-item:hover {
    transform: translateY(-5px);
}

.certificate-image {
    width: 100%;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
}

.certificate-link {
    color: #2d6e6e;
    font-weight: 600;
    text-decoration: none;
    padding: 8px 15px;
    border: 2px solid #2d6e6e;
    border-radius: 25px;
    display: inline-block;
    transition: all 0.3s;
}

.certificate-link:hover {
    background: #2d6e6e;
    color: white;
    transform: translateY(-2px);
	text-decoration: none;
}

.cert-nav {
    color: #2d6e6e !important;
    font-size: 24px !important;
}

.cert-nav:hover {
    color: #255e5e !important;
}

@media (max-width: 768px) {
    
    .certificate-item {
        padding: 15px;
    }
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

<!-- Продукция -->
<section class="section" style="background: var(--secondary);">
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<div class="section-title">Наша продукция</div>
			<div class="grid" style="margin-bottom: 30px;">
				<div class="card" data-aos="flip-left">
					<h3 style="margin-top: 0px;">Тротуарная плитка</h3>
					<p>Вибропрессование и технология ColorMix</p>
				</div>
				<div class="card" data-aos="flip-left" data-aos-delay="100">
					<h3 style="margin-top: 0px;">Строительные блоки</h3>
					<p>Для частного и коммерческого строительства</p>
				</div>
				<div class="card" data-aos="flip-left" data-aos-delay="200">
					<h3 style="margin-top: 0px;">Архитектурные изделия</h3>
					<p>Уникальные решения из бетона</p>
				</div>
			</div>
			<div class="card" style="background: var(--primary);">
					<p style="margin: 0px;color: #ffffff;">
						ООО «ЦБИ» предлагает широкий ассортимент строительных материалов, таких как фасадная плитка и тротуарная плитка, строительные блоки и поребрики, архитектурные изделия из бетона, используя передовые технологии вибролитья и виброштампования. Это позволяет компании удовлетворять не только стандартные, но и индивидуальные запросы клиентов, предлагая решения, которые полностью соответствуют их потребностям.
					</p>
			</div>
		</div>
	</div>
</section>

<!-- Преимущества -->
<section class="section">
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<div class="section-title">Почему выбирают нас?</div>
			<div class="grid">
				<div class="feature" data-aos="zoom-in">
					<div class="feature-icon">🎨</div>
					<h3 style="font-size: 1.7em !important;">ColorMix Technology</h3>
					<p style="font-size: 19px !important;">Использование технологии «ColorMix» при производстве тротуарной плитки. Эта технология позволяет создавать плитку в актуальных пастельных тонах с возможностью комбинирования различных цветовых решений.</p>
				</div>
				<div class="feature" data-aos="zoom-in" data-aos-delay="100">
					<div class="feature-icon">🔍</div>
					<h3 style="font-size: 1.7em !important;">Контроль качества</h3>
					<p style="font-size: 19px !important;">Контроль на всех этапах производства, начиная от подбора сырья и заканчивая готовой продукцией, что позволяет гарантировать стабильно высокое качество и долгий срок службы материалов.</p>
				</div>
				<div class="feature" data-aos="zoom-in" data-aos-delay="200">
					<div class="feature-icon">🚚</div>
					<h3 style="font-size: 1.7em !important;">Логистика</h3>
					<p style="font-size: 19px !important;">Благодаря развитой логистической системе и наличию продукции на складе, компания обеспечивает быструю отгрузку заказов.</p>
				</div>
				<div class="feature" data-aos="zoom-in" data-aos-delay="200">
					<div class="feature-icon">💰</div>
					<h3 style="font-size: 1.7em !important;">Конкурентные цены</h3>
					<p style="font-size: 19px !important;">Собственное производство дает возможность поддерживать конкурентоспособные цены, сохраняя при этом высокие стандарты. Это делает продукцию доступной для широкого круга клиентов — от частных застройщиков до крупных строительных компаний.</p>
				</div>
				<div class="feature" data-aos="zoom-in" data-aos-delay="200">
					<div class="feature-icon">📦</div>
					<h3 style="font-size: 1.7em !important;">Гибкие заказы</h3>
					<p style="font-size: 19px !important;">Возможность дозаказа недостающих материалов в штучном варианте, в отличие от конкурентов, которые часто требуют закупку только целыми поддонами. Такой подход не только удобен для клиентов, но и позволяет значительно сэкономить, делая сотрудничество с компанией еще более выгодным и привлекательным.</p>
				</div>
				<div class="feature" data-aos="zoom-in" data-aos-delay="200">
					<div class="feature-icon">📜</div>
					<h3 style="font-size: 1.7em !important;">Сертификация ГОСТ</h3>
					<p style="font-size: 19px !important;">Сертификация продукции в соответствие с ГОСТ</p>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Партнеры -->
<section class="section">
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<div class="section-title">Наши партнеры</div>
			<div class="partners" data-aos="fade-up">
				<a href="https://evrosintez.ru/"><img src="/company/img/evro.jpg" alt="Евросинтес" class="partner-logo"></a>
				<a href=""><img src="/company/img/paritet.jpg" alt="ООО Полимер" class="partner-logo"></a>
				<a href=""><img src="/company/img/polimer.jpg" alt="СТ Паритет" class="partner-logo"></a>
				<a href="https://rgport.ru/"><img src="/company/img/port.jpg" alt="Рыбинский порт" class="partner-logo"></a>
			</div>
			<div class="card" style="background: var(--primary);">
					<p style="margin: 0px;color: #ffffff;">
						ООО «ЦБИ» тесно сотрудничает с рядом ключевых партнеров и поставщиков, что позволяет поддерживать высокий уровень производства и обеспечивать качественную продукцию.<br><br>
						Среди основных партнёров компании — Евросинтес, ООО Полимер, ООО СТ Паритет и Рыбинский порт. Эти компании поставляют надёжные и проверенные материалы, а также оборудование, что способствует стабильной работе предприятия и реализации проектов любой сложности.<br><br>
						Сотрудничество с такими ведущими партнёрами позволяет компании использовать современные технологии и материалы, поддерживать высокий стандарт продукции и своевременно выполнять заказы. Надёжные партнёрские отношения играют важную роль в успехе компании и ее способности оставаться конкурентоспособной на рынке.
					</p>
			</div>
		</div>
	</div>
</section>

<!-- Социальная ответственность -->
<section class="section" style="background: var(--secondary);">
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<div class="section-title">Мы заботимся</div>
			<div class="grid">
				<div class="card" data-aos="fade-right">
					<h3 style="margin-top: 0px;">Корпоративная социальная ответственность</h3>
					<p>ООО «ЦБИ» заботится о благополучии сотрудников, обеспечивая их униформой, безопасным оборудованием и при необходимости помогая с жильем. Компания поддерживает сплоченность коллектива через регулярные корпоративные мероприятия и тимбилдинг, что создает позитивную атмосферу и укрепляет командный дух. Такой подход повышает мотивацию и формирует сильную, надежную команду.</p>
				</div>
				<div class="card" data-aos="fade-left">
					<h3 style="margin-top: 0px;">Взаимодействие с общественностью и клиентами</h3>
					<p>ООО «ЦБИ» заботится о благополучии сотрудников, обеспечивая их униформой, безопасным оборудованием и при необходимости помогая с жильем. Компания поддерживает сплоченность коллектива через регулярные корпоративные мероприятия и тимбилдинг, что создает позитивную атмосферу и укрепляет командный дух. Такой подход повышает мотивацию и формирует сильную, надежную команду.</p>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="news-detail-sections widget">
    <div class="news-detail-sections-wrapper intec-content intec-content-visible">
        <div class="news-detail-sections-wrapper-2 intec-content-wrapper" style="padding-top: 30px;">
			<div class="widget-header">
				<div class="intec-grid intec-grid-wrap intec-grid-a-v-center intec-grid-i-8">
					<div class="widget-title-container intec-grid-item">
						<div class="section-title" style="margin-bottom: 0px;">
							Каталог товаров
						</div>                            
					</div>
					<div class="widget-all-container mobile intec-grid-item-auto">                                
						<a class="widget-all-button intec-cl-text-light-hover" href="/catalog/" style="
																										font-size: 12px;
																										font-weight: 500;
																										line-height: 1;
																										color: #808080;
																										text-decoration: none;
																										text-transform: uppercase;
																										letter-spacing: 0.1em;
																									">
							<span>
								Весь каталог
							</span>
						</a>                            
					</div>                                                                    
				</div>
			</div>
			<div class="news-detail-sections-content widget-content">
				<?php $APPLICATION->IncludeComponent(
					'intec.universe:main.sections',
					'template.1',
					array(
						'IBLOCK_ID' => 13,
						'IBLOCK_TYPE' => 'catalogs',
						'SECTIONS' => '',
						'SETTINGS_USE' => 'N',
						'LAZYLOAD_USE' => 'N',
						'LINE_COUNT' => 20,
						'DEPTH' => 1,
						'HEADER_SHOW' => 'N',
						'DESCRIPTION_SHOW' => 'N',
					),
					$component
				) ?>
			</div>
        </div>
    </div>
</div>
<?/*<div>
	<div class="intec-content">
		<div class="intec-content-wrapper">
			<h3>Производство</h3>
			 <?$APPLICATION->IncludeComponent(
	"bitrix:photo.section", 
	"gallery.default.1", 
	array(
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"COLUMNS" => "3",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_ORDER" => "asc",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arrFilter",
		"IBLOCK_ID" => "37",
		"IBLOCK_TYPE" => "content",
		"LAZYLOAD_USE" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Фотографии",
		"PAGE_ELEMENT_COUNT" => "20",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SECTION_CODE" => "",
		"SECTION_ID" => "58",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SETTINGS_USE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"COMPONENT_TEMPLATE" => "gallery.default.1"
	),
	false
);?>
		</div>
	</div>
</div>*/?>
<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php') ?>