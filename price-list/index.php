<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');

$APPLICATION->SetTitle("Прайс лист");

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>

.category {margin-bottom: 40px;padding: 20px;background: white;border-radius: 10px;box-shadow: 0 2px 10px rgba(0,0,0,0.1);}
.price-table {margin-top: 20px;}
.color-cell {text-align: center;padding: 10px;border-radius: 5px;margin: 5px 0;}
.gray { background: #e0e0e0; }
.red { background: #ffcdd2; }
.brown { background: #d7ccc8; }
.yellow { background: #fff9c4; }
.black { background: #424242; color: white; }
.orange { background: #ffe0b2; }
.special-note {color: #757575;font-style: italic;}
.price-table img {max-width: 100px;height: auto;display: block;margin: 0 auto;transition: transform 0.3s;}
.price-table img:hover {transform: scale(1.1);}
@media (max-width: 768px) {
	.price-table {overflow-x: auto;}
	.price-table img {max-width: 60px;}
}
table thead tr, table tbody tr, .category h3{text-align:center;}
.custom-td{padding: 0 !important; width: 16.66%;}
.custom-td-img{width: 100%;height: 85px !important;display: block;object-fit: cover;border: none;margin: 0 !important;border-radius: 0;max-width: unset !important;}
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
.save-price{
	text-align:center;
	margin:20px 0px;
}
</style>
<div class="container">
    <!-- Контакты -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-md-6" style="text-align: center;">
            <h4>Адрес:</h4>
            <p>г. Рыбинск, ул. Окружная дорога, дом 24А</p>
        </div>
        <div class="col-md-6" style="text-align: center;">
            <h4>Контакты:</h4>
            <p>8(920) 127-98-87<br>cbi76@mail.ru</p>
        </div>
    </div>
	<div class="save-price" data-aos="fade-up">
		<a href="/price-list/price-list.pdf" 
			class="certificate-link" 
			download="price-list.pdf">
				Скачать прайс-лист
		</a>
	</div>
    <!-- ЛИТЬЁ -->
    <div class="category" data-aos="fade-up">
        <h3>ЛИТЬЁ</h3>
        <div class="price-table table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th class="gray">Серый</th>
                        <th colspan="3" class="red">Красный</th>
                        <th class="brown">Коричневый</th>
                        <th colspan="3" class="yellow">Жёлтый</th>
                        <th class="black">Чёрный</th>
                        <th colspan="2" class="orange">Оранжевый</th>
                    </tr>
                </thead>
                <tbody>
					<!-- ---------------------------- -->
					<tr>
						<td>30х30</td>
						<td class="gray"><img src="/price-list/img/lite/grey.png" alt="Серый"></td>
						<td colspan="3" class="red"><img src="/price-list/img/lite/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/lite/korich.png" alt="Коричневый"></td>
						<td colspan="3" class="yellow"><img src="/price-list/img/lite/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/lite/black.png" alt="Чёрный"></td>
						<td colspan="2" class="orange"><img src="/price-list/img/lite/orang.png" alt="Оранжевый"></td>
					</tr>
					<tr>
						<td>Цена</td>
						<td class="gray">750 руб./м²</td>
						<td colspan="3" class="red">850 руб./м²</td>
						<td class="brown">850 руб./м²</td>
						<td colspan="3" class="yellow">850 руб./м²</td>
						<td class="black">850 руб./м²</td>
						<td colspan="2" class="orange">850 руб./м²</td>
					</tr>
					<!-- ---------------------------- -->
					<tr>
						<td>40х40</td>
						<td class="gray"><img src="/price-list/img/lite/grey.png" alt="Серый"></td>
						<td colspan="3" class="red"><img src="/price-list/img/lite/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/lite/korich.png" alt="Коричневый"></td>
						<td colspan="3" class="yellow"><img src="/price-list/img/lite/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/lite/black.png" alt="Чёрный"></td>
						<td colspan="2" class="orange"><img src="/price-list/img/lite/orang.png" alt="Оранжевый"></td>
					</tr>
					<tr>
						<td>Цена</td>
						<td class="gray">900 руб./м²</td>
						<td colspan="3" class="red">1000 руб./м²</td>
						<td class="brown">1000 руб./м²</td>
						<td colspan="3" class="yellow"> 1000 руб./м²</td>
						<td class="black">1000 руб./м²</td>
						<td colspan="2" class="orange">1000 руб./м²</td>
					</tr>
					<!-- ---------------------------- -->
					<tr>
						<td>50х50</td>
						<td class="gray"><img src="/price-list/img/lite/grey.png" alt="Серый"></td>
						<td colspan="3" class="red"><img src="/price-list/img/lite/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/lite/korich.png" alt="Коричневый"></td>
						<td colspan="3" class="yellow"><img src="/price-list/img/lite/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/lite/black.png" alt="Чёрный"></td>
						<td colspan="2" class="orange"><img src="/price-list/img/lite/orang.png" alt="Оранжевый"></td>
					</tr>
					<tr>
						<td>Цена</td>
						<td class="gray">1050 руб./м²</td>
						<td colspan="3" class="red">1200 руб./м²</td>
						<td class="brown">1200 руб./м²</td>
						<td colspan="3" class="yellow">1200 руб./м²</td>
						<td class="black">1200 руб./м²</td>
						<td colspan="2" class="orange">1200 руб./м²</td>
					</tr>
					<!-- ---------------------------- -->
					<tr>
						<td>60х30<br>флоренция</td>
						<td class="gray"><img src="/price-list/img/lite/60-30/grey.png" alt="Серый"></td>
						<td colspan="3" class="red"><img src="/price-list/img/lite/60-30/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/lite/60-30/korich.png" alt="Коричневый"></td>
						<td colspan="3" class="yellow"><img src="/price-list/img/lite/60-30/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/lite/60-30/black.png" alt="Чёрный"></td>
						<td colspan="2" class="orange"><img src="/price-list/img/lite/60-30/orang.png" alt="Оранжевый"></td>
					</tr>
					<tr>
						<td>Цена</td>
						<td class="gray">950 руб./м²</td>
						<td colspan="3" class="red">1100 руб./м²</td>
						<td class="brown">1100 руб./м²</td>
						<td colspan="3" class="yellow">1100 руб./м²</td>
						<td class="black">1100 руб./м²</td>
						<td colspan="2" class="orange">1100 руб./м²</td>
					</tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Наверша<br>"Медуза"</td>
						<td class="gray"><img src="/price-list/img/lite/meduza/grey.png" alt="Серый"></td>
						<td colspan="3" class="red"><img src="/price-list/img/lite/meduza/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/lite/meduza/korich.png" alt="Коричневый"></td>
						<td colspan="3" class="yellow"><img src="/price-list/img/lite/meduza/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/lite/meduza/black.png" alt="Чёрный"></td>
						<td colspan="2" class="orange"><img src="/price-list/img/lite/meduza/orang.png" alt="Оранжевый"></td>
					</tr>
					<tr>
						<td>Цена</td>
						<td class="gray">600 руб./шт.</td>
						<td colspan="3" class="red">60 руб./шт.</td>
						<td class="brown">600 руб./шт.</td>
						<td colspan="3" class="yellow">600 руб./шт.</td>
						<td class="black">600 руб./шт.</td>
						<td colspan="2" class="orange">600 руб./шт.</td>
					</tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Наверша<br>для забора</td>
						<td class="gray"><img src="/price-list/img/lite/naversha-zabor/grey.png" alt="Серый"></td>
						<td colspan="3" class="red"><img src="/price-list/img/lite/naversha-zabor/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/lite/naversha-zabor/korich.png" alt="Коричневый"></td>
						<td colspan="3" class="yellow"><img src="/price-list/img/lite/naversha-zabor/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/lite/naversha-zabor/black.png" alt="Чёрный"></td>
						<td colspan="2" class="orange"><img src="/price-list/img/lite/naversha-zabor/orang.png" alt="Оранжевый"></td>
					</tr>
					<tr>
						<td>Цена</td>
						<td class="gray">650 руб./шт.</td>
						<td colspan="3" class="red">550 руб./шт.</td>
						<td class="brown">550 руб./шт.</td>
						<td colspan="3" class="yellow">550 руб./шт.</td>
						<td class="black">550 руб./шт.</td>
						<td colspan="2" class="orange">550 руб./шт.</td>
					</tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Ступни</td>
						<td class="gray"><img src="/price-list/img/lite/stupen/grey.png" alt="Серый"></td>
						<td colspan="3" class="red"><img src="/price-list/img/lite/stupen/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/lite/stupen/korich.png" alt="Коричневый"></td>
						<td colspan="3" class="yellow"><img src="/price-list/img/lite/stupen/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/lite/stupen/black.png" alt="Чёрный"></td>
						<td colspan="2" class="orange"><img src="/price-list/img/lite/stupen/orang.png" alt="Оранжевый"></td>
					</tr>
					<tr>
						<td>Цена</td>
						<td class="gray">900 руб./шт.</td>
						<td colspan="3" class="red">900 руб./шт.</td>
						<td class="brown">900 руб./шт.</td>
						<td colspan="3" class="yellow">900 руб./шт.</td>
						<td class="black">900 руб./шт.</td>
						<td colspan="2" class="orange">900 руб./шт.</td>
					</tr>
					<!-- ---------------------------- -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- БОРДЮРНЫЙ КАМЕНЬ -->
    <div class="category" data-aos="fade-up">
        <h3>САДОВЫЙ БОРДЮР</h3>
        <div class="price-table table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th class="gray">Серый</th>
                        <th class="red">Красный</th>
                        <th class="brown">Коричневый</th>
                        <th class="yellow">Жёлтый</th>
                        <th class="black">Чёрный</th>
                        <th class="orange">Оранжевый</th>
                    </tr>
                </thead>
                <tbody>
					<!-- ---------------------------- -->
					<tr>
						<td>Бордюр "50"<br>500*200*50</td>
						<td class="gray"><img src="/price-list/img/bordur/grey.png" alt="Серый"></td>
						<td class="red"></td>
						<td class="brown"></td>
						<td class="yellow"></td>
						<td class="black"></td>
						<td class="orange"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td class="gray">135 руб./шт.</td>
                        <td colspan="5" class="special-note">Обсуждается по факту</td>
                    </tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Бордюр"Б-5"<br>1000*200*80</td>
						<td class="gray"><img src="/price-list/img/bordur/grey.png" alt="Серый"></td>
						<td class="red"></td>
						<td class="brown"></td>
						<td class="yellow"></td>
						<td class="black"></td>
						<td class="orange"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td class="gray">400 руб./шт.</td>
                        <td colspan="5" class="special-note">Обсуждается по факту</td>
                    </tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Бордюр "Б-1"<br>1000*300*150</td>
						<td class="gray"><img src="/price-list/img/bordur/grey.png" alt="Серый"></td>
						<td class="red"></td>
						<td class="brown"></td>
						<td class="yellow"></td>
						<td class="black"></td>
						<td class="orange"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td class="gray">650 руб./шт.</td>
                        <td colspan="5" class="special-note">Обсуждается по факту</td>
                    </tr>
					<!-- ---------------------------- -->                
                </tbody>
            </table>
        </div>
    </div>

	<!-- ТРОТУАРНАЯ ПЛИТКА -->
    <div class="category" data-aos="fade-up">
        <h3>ТРОТУАРНАЯ ПЛИТКА</h3>
        <div class="price-table table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th class="gray">Серый</th>
                        <th class="red">Красный</th>
                        <th class="brown">Коричневый</th>
                        <th class="yellow">Жёлтый</th>
                        <th class="black">Чёрный</th>
                        <th class="orange">Оранжевый</th>
                    </tr>
                </thead>
                <tbody>
					<!-- ---------------------------- -->
					<tr>
						<td>Брусчатка<br>(200*100*60)</td>
						<td class="gray custom-td"><img src="/price-list/img/trotuar/grey.jpg" class="custom-td-img" alt="Серый"></td>
						<td class="red custom-td"><img src="/price-list/img/trotuar/red.png" class="custom-td-img" alt="Красный"></td>
						<td class="brown custom-td"><img src="/price-list/img/trotuar/korich.jpg" class="custom-td-img" alt="Коричневый"></td>
						<td class="yellow custom-td"><img src="/price-list/img/trotuar/ellow.jpg" class="custom-td-img" alt="Жёлтый"></td>
						<td class="black custom-td"><img src="/price-list/img/trotuar/black.png" class="custom-td-img" alt="Чёрный"></td>
						<td class="orange custom-td"><img src="/price-list/img/trotuar/orang.jpg" class="custom-td-img" alt="Оранжевый"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td class="gray">1050 руб./м²</td>
						<td class="red">1250 руб./м²</td>
						<td class="brown">1250 руб./м²</td>
						<td class="yellow">1250 руб./м²</td>
						<td class="black">1250 руб./м²</td>
						<td class="orange">1250 руб./м²</td>
                    </tr>
					<!-- ---------------------------- -->
					<tr>
                        <td>Колор микс</td>
                        <td colspan="6" class="special-note">от 1450 руб./м²</td>
                    </tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Новый город</td>
						<td class="gray custom-td"><img src="/price-list/img/trotuar/gorod/grey.jpg" class="custom-td-img" alt="Серый"></td>
						<td class="red custom-td"><img src="/price-list/img/trotuar/gorod/red.png" class="custom-td-img" alt="Красный"></td>
						<td class="brown custom-td"><img src="/price-list/img/trotuar/gorod/korich.png" class="custom-td-img" alt="Коричневый"></td>
						<td class="yellow custom-td"><img src="/price-list/img/trotuar/gorod/ellow.png" class="custom-td-img" alt="Жёлтый"></td>
						<td class="black custom-td"><img src="/price-list/img/trotuar/gorod/black.png" class="custom-td-img" alt="Чёрный"></td>
						<td class="orange custom-td"><img src="/price-list/img/trotuar/gorod/orang.png" class="custom-td-img" alt="Оранжевый"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td class="gray">1150 руб./м²</td>
						<td class="red">1350 руб./м²</td>
						<td class="brown">1350 руб./м²</td>
						<td class="yellow">1350 руб./м²</td>
						<td class="black">1350 руб./м²</td>
						<td class="orange">1350 руб./м²</td>
                    </tr>
					<!-- ---------------------------- -->     
					<tr>
                        <td>Колор микс</td>
                        <td colspan="6" class="special-note">от 1500 руб./м²</td>
                    </tr>
					<!-- ---------------------------- -->   
					<tr>
						<td>Газонная<br>решетка</td>
						<td class="gray"><img src="/price-list/img/trotuar/reshotka/grey.png" alt="Серый"></td>
						<td class="red"><img src="/price-list/img/trotuar/reshotka/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/trotuar/reshotka/korich.png" alt="Коричневый"></td>
						<td class="yellow"><img src="/price-list/img/trotuar/reshotka/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/trotuar/reshotka/black.png" alt="Чёрный"></td>
						<td class="orange"><img src="/price-list/img/trotuar/reshotka/orang.png" alt="Оранжевый"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td class="gray">1500 руб./м²</td>
						<td class="red">1500 руб./м²</td>
						<td class="brown">1500 руб./м²</td>
						<td class="yellow">1500 руб./м²</td>
						<td class="black">1500 руб./м²</td>
						<td class="orange">1500 руб./м²</td>
                    </tr>
					<!-- ---------------------------- -->      
                </tbody>
            </table>
        </div>
    </div>

	<!-- БЛОКИ -->
    <div class="category" data-aos="fade-up">
        <h3>БЛОКИ</h3>
        <div class="price-table table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th class="gray">Серый</th>
                        <th class="red">Красный</th>
                        <th class="brown">Коричневый</th>
                        <th class="yellow">Жёлтый</th>
                        <th class="black">Чёрный</th>
                        <th class="orange">Оранжевый</th>
                    </tr>
                </thead>
                <tbody>
					<!-- ---------------------------- -->
					<tr>
						<td>Блок<br>двухполый</td>
						<td class="gray"><img src="/price-list/img/block/grey.png" alt="Серый"></td>
						<td class="red"><img src="/price-list/img/block/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/block/korich.png" alt="Коричневый"></td>
						<td class="yellow"><img src="/price-list/img/block/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/block/black.png" alt="Чёрный"></td>
						<td class="orange"><img src="/price-list/img/block/orang.png" alt="Оранжевый"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td class="gray">150 руб./шт</td>
						<td colspan="6" class="special-note">Обсуждается по факту от 500 шт.</td>
                    </tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Блок<br>цельный</td>
						<td class="gray"><img src="/price-list/img/block/seln/grey.png" alt="Серый"></td>
						<td class="red"></td>
						<td class="brown"></td>
						<td class="yellow"></td>
						<td class="black"></td>
						<td class="orange"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td class="gray">280 руб./шт.</td>
                        <td colspan="6" class="special-note"></td>
                    </tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Блок<br>столбовой</td>
						<td class="gray"><img src="/price-list/img/block/stolb/grey.png" alt="Серый"></td>
						<td class="red"><img src="/price-list/img/block/stolb/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/block/stolb/korich.png" alt="Коричневый"></td>
						<td class="yellow"><img src="/price-list/img/block/stolb/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/block/stolb/black.png" alt="Чёрный"></td>
						<td class="orange"><img src="/price-list/img/block/stolb/orang.png" alt="Оранжевый"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td colspan="7" class="special-note">350 руб./шт</td>
                    </tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Блок<br>рядовой</td>
						<td class="gray"><img src="/price-list/img/block/radov/grey.png" alt="Серый"></td>
						<td class="red"><img src="/price-list/img/block/radov/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/block/radov/korich.png" alt="Коричневый"></td>
						<td class="yellow"><img src="/price-list/img/block/radov/ellow.png" alt="Жёлтый"></td>
						<td class="black"><img src="/price-list/img/block/radov/black.png" alt="Чёрный"></td>
						<td class="orange"><img src="/price-list/img/block/radov/orang.png" alt="Оранжевый"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td colspan="7" class="special-note">250 руб./шт</td>
                    </tr>
					<!-- ---------------------------- -->                 
                </tbody>
            </table>
        </div>
    </div>

	<!-- ВОДОСТОКИ -->
    <div class="category" data-aos="fade-up">
        <h3>ВОДОСТОКИ</h3>
        <div class="price-table table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Наименование</th>
                        <th class="gray">Серый</th>
                        <th class="red">Красный</th>
                        <th class="brown">Коричневый</th>
                        <th class="yellow">Жёлтый</th>
                        <th class="black">Чёрный</th>
                        <th class="orange">Оранжевый</th>
                    </tr>
                </thead>
                <tbody>
					<!-- ---------------------------- -->
					<tr>
						<td> Водосток<br>"350*160"</td>
						<td class="gray"><img src="/price-list/img/vodastock/grey.png" alt="Серый"></td>
						<td class="red"><img src="/price-list/img/vodastock/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/vodastock/korich.png" alt="Коричневый"></td>
						<td class="yellow"></td>
						<td class="black"></td>
						<td class="orange"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
                        <td class="gray">100 руб./шт.</td>
						<td class="red">115 руб./шт.</td>
						<td class="brown">115 руб./шт.</td>
                        <td class="yellow"></td>
						<td class="black"></td>
						<td class="orange"></td>
                    </tr>
					<!-- ---------------------------- -->
					<tr>
						<td>Водосток<br>"500*160"</td>
						<td class="gray"><img src="/price-list/img/vodastock/grey.png" alt="Серый"></td>
						<td class="red"><img src="/price-list/img/vodastock/red.png" alt="Красный"></td>
						<td class="brown"><img src="/price-list/img/vodastock/korich.png" alt="Коричневый"></td>
						<td class="yellow"></td>
						<td class="black"></td>
						<td class="orange"></td>
					</tr>
                    <tr>
                        <td>Цена</td>
						<td class="gray">150 руб./шт.</td>
						<td class="red">175 руб./шт.</td>
						<td class="brown">175 руб./шт.</td>
                        <td class="yellow"></td>
						<td class="black"></td>
						<td class="orange"></td>
                    </tr>
					<!-- ---------------------------- -->         
                </tbody>
            </table>
        </div>
    </div>
    <!-- Дополнительные разделы -->
    <div class="category" data-aos="fade-up">
        <h3>Дополнительные товары</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Печь BBQ</h5>
                        <p class="card-text">30 000 руб./шт.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Печь + 2 раб. зоны</h5>
                        <p class="card-text">60  000 руб./шт.</p>
                    </div>
                </div>
            </div>
			<div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Раб.зона/мойка</h5>
                        <p class="card-text">15 000 руб./шт.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<p style="color: #a7a7a7;text-align: center;">*Прайс не является публичной офертой</p>
</div>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>
<?php require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php') ?>