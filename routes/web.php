<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
// */

//VEsi
Route::get('/vesi', 'LibraController@list');

{//Vesi shit
  Route::get('make/vesi', function(){


    $data = json_decode('
    {
      "type": "FeatureCollection",
      "name": "финал",
      "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:EPSG::3857" } },
      "features": [
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Vegan superfood", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 351, "Белки(Click to sort Ascending)": 19, "Жиры(Click to sort Ascending)": 7, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "какао-порошок, мака перуанская, зерна канихуа, мука из семян люпина, мука из киноа, амарантовая мука, порошок из мескита, стевия, панела,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 220, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Амарант, премиум мука жмыховая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 344, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 4, "Углеводы(Click to sort Ascending)": 68, "Состав(Click to sort Ascending)": "мука амарантовая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 95, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Ананас кольцами, цукат", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 91, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 18, "Состав(Click to sort Ascending)": "кольца ананаса, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 145, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 580, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 42, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "арахис жареный, шоколадная глазурь белая,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис в кокосовом сиропе", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 636, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 30, "Углеводы(Click to sort Ascending)": 50, "Состав(Click to sort Ascending)": "арахис, пшеничная мука, крахмал, сахар, растительное масло, кокосовый сок, соль,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 95, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис в кунжуте", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 528, "Белки(Click to sort Ascending)": 19, "Жиры(Click to sort Ascending)": 36, "Углеводы(Click to sort Ascending)": 33, "Состав(Click to sort Ascending)": "ядра арахиса, кунжут, сахарная пудра, сахар, патока.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 540, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 38, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "арахис жареный, шоколадная глазурь темная,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис неочищенный", "Страна(Click to sort Ascending)": "Аргентина", "Калории(Click to sort Ascending)": 587, "Белки(Click to sort Ascending)": 27, "Жиры(Click to sort Ascending)": 48, "Углеводы(Click to sort Ascending)": 10, "Состав(Click to sort Ascending)": "арахис в скорлупе.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 27, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Арахис очищенный", "Страна(Click to sort Ascending)": "Аргентина", "Калории(Click to sort Ascending)": 552, "Белки(Click to sort Ascending)": 26, "Жиры(Click to sort Ascending)": 45, "Углеводы(Click to sort Ascending)": 10, "Состав(Click to sort Ascending)": "арахис очищенный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 25, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Банановые чипсы", "Страна(Click to sort Ascending)": "Филиппины", "Калории(Click to sort Ascending)": 487, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 30, "Углеводы(Click to sort Ascending)": 51, "Состав(Click to sort Ascending)": "банан, кокосовое масло, сахар, мед", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 50, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Бананы сушеные Вьетконг", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 339, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 54, "Состав(Click to sort Ascending)": "бананы сушеные,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Белая фасоль", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 237, "Белки(Click to sort Ascending)": 17, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 41, "Состав(Click to sort Ascending)": "белая фасоль", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 105, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Бразильский орех", "Страна(Click to sort Ascending)": "Бразилия", "Калории(Click to sort Ascending)": 656, "Белки(Click to sort Ascending)": 14, "Жиры(Click to sort Ascending)": 66, "Углеводы(Click to sort Ascending)": 12, "Состав(Click to sort Ascending)": "бразильский орех", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Вечерний чай", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: цейлонский черный чай, ягоды брусники, кусочки яблока, цедра лимона и листья мяты.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Витграсс премиум, молотые ростки", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 195, "Белки(Click to sort Ascending)": 22, "Жиры(Click to sort Ascending)": 3, "Углеводы(Click to sort Ascending)": 22, "Состав(Click to sort Ascending)": "молодые зеленые побеги пшеницы,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 140, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Вишня вяленая", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 290, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 73, "Состав(Click to sort Ascending)": "вишня, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 81, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Грецкий орех бабочка", "Страна(Click to sort Ascending)": "Украина", "Калории(Click to sort Ascending)": 654, "Белки(Click to sort Ascending)": 15, "Жиры(Click to sort Ascending)": 65, "Углеводы(Click to sort Ascending)": 7, "Состав(Click to sort Ascending)": "грецкий орех.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Грецкий орех в шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 577, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 43, "Углеводы(Click to sort Ascending)": 38, "Состав(Click to sort Ascending)": "бланшированный грецкий орех, шоколадная глазурь темная,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 115, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Грецкий орех целый Чили", "Страна(Click to sort Ascending)": "Чили", "Калории(Click to sort Ascending)": 656, "Белки(Click to sort Ascending)": 16, "Жиры(Click to sort Ascending)": 61, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "грецкий орех целый", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 81, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Грецкий орех четвертинки", "Страна(Click to sort Ascending)": "Украина", "Калории(Click to sort Ascending)": 648, "Белки(Click to sort Ascending)": 16, "Жиры(Click to sort Ascending)": 65, "Углеводы(Click to sort Ascending)": 10, "Состав(Click to sort Ascending)": "грецкий орех четвертинки", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Гречка зеленая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 296, "Белки(Click to sort Ascending)": 11, "Жиры(Click to sort Ascending)": 3, "Углеводы(Click to sort Ascending)": 56, "Состав(Click to sort Ascending)": "гречка зеленая", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Груша вяленая", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 270, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 63, "Состав(Click to sort Ascending)": "груша, сахар.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 174, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Женьшень Улун (оолонг)", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: чайный лист, корень женьшеня, падуб широколистный, солодка", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Здоровое пищеварение", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный китайский чай, оолонг, душица, мята, имбирь, ромашка, плоды можжевельника, тысячелистник, ягоды малины, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Иван-чай Вологодский с вишней", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "кипрей узколистный ферментированный, листья вишни,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Изюм в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 459, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 22, "Углеводы(Click to sort Ascending)": 67, "Состав(Click to sort Ascending)": "сушеный виноград без косточки, белая шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 55, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Изюм в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 455, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 21, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "сушеный виноград без косточки, темная шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 55, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Изюм светлый", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 232, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 51, "Состав(Click to sort Ascending)": "изюм светлый", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Изюм черный", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 283, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "изюм черный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Инжир горный натуральный", "Страна(Click to sort Ascending)": "Турция", "Калории(Click to sort Ascending)": 213, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 52, "Состав(Click to sort Ascending)": "инжир горный натуральный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 180, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Инжир", "Страна(Click to sort Ascending)": "Турция", "Калории(Click to sort Ascending)": 257, "Белки(Click to sort Ascending)": 3, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "инжир", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 115, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Какао Премиум, порошок натуральный", "Страна(Click to sort Ascending)": "Бразилия", "Калории(Click to sort Ascending)": 417, "Белки(Click to sort Ascending)": 24, "Жиры(Click to sort Ascending)": 11, "Углеводы(Click to sort Ascending)": 53, "Состав(Click to sort Ascending)": "какао-порошок,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Какао-масло натуральное Belcolade", "Страна(Click to sort Ascending)": "Бельгия", "Калории(Click to sort Ascending)": 899, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 100, "Состав(Click to sort Ascending)": "100% натуральное какао-масло,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 18000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Каркаде", "Страна(Click to sort Ascending)": "Россия", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 50, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кедровый орех", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 674, "Белки(Click to sort Ascending)": 14, "Жиры(Click to sort Ascending)": 68, "Углеводы(Click to sort Ascending)": 13, "Состав(Click to sort Ascending)": "кедровый орех", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 230, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кешью в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 574, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 43, "Углеводы(Click to sort Ascending)": 42, "Состав(Click to sort Ascending)": "кешью, белая шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кешью в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 568, "Белки(Click to sort Ascending)": 11, "Жиры(Click to sort Ascending)": 42, "Углеводы(Click to sort Ascending)": 39, "Состав(Click to sort Ascending)": "кешью, темная шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кешью нежареный", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 554, "Белки(Click to sort Ascending)": 18, "Жиры(Click to sort Ascending)": 43, "Углеводы(Click to sort Ascending)": 30, "Состав(Click to sort Ascending)": "кешью.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кешью обжаренный", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 574, "Белки(Click to sort Ascending)": 15, "Жиры(Click to sort Ascending)": 46, "Углеводы(Click to sort Ascending)": 32, "Состав(Click to sort Ascending)": "кешью обжаренный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 140, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Киви вяленый", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 285, "Белки(Click to sort Ascending)": 1, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 85, "Состав(Click to sort Ascending)": "киви, сахар", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Киноа белая Премиум, зерно", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 345, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 6, "Углеводы(Click to sort Ascending)": 69, "Состав(Click to sort Ascending)": "белое киноа, соль, сушёный томат молотый, лук молотый, чёрный перец молотый, панела молотая, кумин, орегано, чеснок молотый, базилик,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Киноа белая Премиум, мука цельнозерновая", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 380, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 5, "Углеводы(Click to sort Ascending)": 71, "Состав(Click to sort Ascending)": "мука из киноа белого,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 260, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Киноа белая Премиум, хлопья с Макой перуанской", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 385, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 4, "Углеводы(Click to sort Ascending)": 78, "Состав(Click to sort Ascending)": "хлопья из бланшированного киноа с сушёной Макой,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 134, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Клубника вяленая", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 290, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 84, "Состав(Click to sort Ascending)": "клубника, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос натуральный сушеный БЕЗ сахара", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 700, "Белки(Click to sort Ascending)": 8, "Жиры(Click to sort Ascending)": 68, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "высушенные кусочки натурального кокоса,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, молоко сухое", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 720, "Белки(Click to sort Ascending)": 12, "Жиры(Click to sort Ascending)": 64, "Углеводы(Click to sort Ascending)": 24, "Состав(Click to sort Ascending)": "сухое кокосовое молоко, мальтодекстрин,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, мука", "Страна(Click to sort Ascending)": "Шри-Ланка", "Калории(Click to sort Ascending)": 466, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 16, "Углеводы(Click to sort Ascending)": 60, "Состав(Click to sort Ascending)": "мука кокосовая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 145, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, сахар", "Страна(Click to sort Ascending)": "Индонезия", "Калории(Click to sort Ascending)": 380, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 95, "Состав(Click to sort Ascending)": "кокосовый сахар,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, стружка 65%", "Страна(Click to sort Ascending)": "Шри-Ланка", "Калории(Click to sort Ascending)": 713, "Белки(Click to sort Ascending)": 7, "Жиры(Click to sort Ascending)": 68, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "стружка кокосовая,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 33, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, стружка низкой жирности", "Страна(Click to sort Ascending)": "Шри-Ланка", "Калории(Click to sort Ascending)": 709, "Белки(Click to sort Ascending)": 7, "Жиры(Click to sort Ascending)": 45, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "стружка кокосовая", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокос Премиум, чипсы натуральные", "Страна(Click to sort Ascending)": "Шри-Ланка", "Калории(Click to sort Ascending)": 700, "Белки(Click to sort Ascending)": 8, "Жиры(Click to sort Ascending)": 68, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "кокосовая стружка,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокосовая стружка medium", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 693, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 65, "Углеводы(Click to sort Ascending)": 14, "Состав(Click to sort Ascending)": "стружка кокосовая,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 25, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кокосовые кубики натуральные", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 470, "Белки(Click to sort Ascending)": 3, "Жиры(Click to sort Ascending)": 23, "Углеводы(Click to sort Ascending)": 30, "Состав(Click to sort Ascending)": "кокос натуральный сушеный,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Компот из сухофруктов", "Страна(Click to sort Ascending)": "Таджикистан", "Калории(Click to sort Ascending)": 205, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 6, "Углеводы(Click to sort Ascending)": 33, "Состав(Click to sort Ascending)": "абрикос сушеный, яблоко сушеное, чернослив с косточкой, груша сушеная, вишня сушеная.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 50, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Амаретто", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Бейлиз", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Бейлиз", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе в зернах Бразилия Сантос Моджиана", "Страна(Click to sort Ascending)": "Бразилия", "Состав(Click to sort Ascending)": "Состав: 100% арабика", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 119, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе в зернах Колумбия Супремо", "Страна(Click to sort Ascending)": "Колумбия", "Состав(Click to sort Ascending)": "Состав: 100% арабика", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 137, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Ваниль", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Ванильно-сливочный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Имбирный лимон", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Ириска", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Ирландский крем", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Мокко-кокос", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе с мятой", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кофе Тирамису", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: натуральная арабика, ароматизатор.", "Категории(Click to sort Ascending)": "Кофе", "Цена(Click to sort Ascending)": 132, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 29800 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кунжут черный", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 565, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 12, "Состав(Click to sort Ascending)": "семена кунжута неочищенные", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кунжут", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 565, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 12, "Состав(Click to sort Ascending)": "кунжут", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Курага", "Страна(Click to sort Ascending)": "Таджикистан", "Калории(Click to sort Ascending)": 232, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 51, "Состав(Click to sort Ascending)": "курага", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 114, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Кэроб молотый без обжарки", "Страна(Click to sort Ascending)": "Алжир", "Калории(Click to sort Ascending)": 230, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 89, "Состав(Click to sort Ascending)": "молотый кэроб,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Леди Совершенство", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: мате, мелисса, оолонг, лимонграсс, гибискус, имбирь, ягоды клюквы, облепихи, яблоко, лепестки роз, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 85, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Лен", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 534, "Белки(Click to sort Ascending)": 18, "Жиры(Click to sort Ascending)": 42, "Углеводы(Click to sort Ascending)": 30, "Состав(Click to sort Ascending)": "лен", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Лукума Суперфуд, напиток", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 337, "Белки(Click to sort Ascending)": 7, "Жиры(Click to sort Ascending)": 3, "Углеводы(Click to sort Ascending)": 78, "Состав(Click to sort Ascending)": "порошок из плодов лукумы, мука киноа клейстеризованная, порошок из мексита, молотая корица,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 190, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мака перуанская Суперфуд, молотый", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 325, "Белки(Click to sort Ascending)": 14, "Жиры(Click to sort Ascending)": 4, "Углеводы(Click to sort Ascending)": 71, "Состав(Click to sort Ascending)": "мука из молотой маки.", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Макадамия", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 718, "Белки(Click to sort Ascending)": 8, "Жиры(Click to sort Ascending)": 76, "Углеводы(Click to sort Ascending)": 14, "Состав(Click to sort Ascending)": "макадамия", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Манго вяленое, цукаты", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 314, "Белки(Click to sort Ascending)": 22, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 82, "Состав(Click to sort Ascending)": "сушеное манго, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мате земляничный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: мате, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 115, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мате классический", "Страна(Click to sort Ascending)": "Аргентина", "Состав(Click to sort Ascending)": "Соста: высушенные и измельчённые листья падуба парагвайского", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 105, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Матча чай Премиум, мелкого помола", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 60, "Белки(Click to sort Ascending)": 1, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 13, "Состав(Click to sort Ascending)": "чай молотый матча,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 305, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Маш", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 300, "Белки(Click to sort Ascending)": 24, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 46, "Состав(Click to sort Ascending)": "маш", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Миндаль в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 564, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 39, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "обжаренный миндаль, шоколадная глазурь белая,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Миндаль в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 564, "Белки(Click to sort Ascending)": 10, "Жиры(Click to sort Ascending)": 39, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "обжаренный миндаль, шоколадная глазурь темная,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Миндаль обжаренный", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 609, "Белки(Click to sort Ascending)": 19, "Жиры(Click to sort Ascending)": 54, "Углеводы(Click to sort Ascending)": 13, "Состав(Click to sort Ascending)": "миндаль обжаренный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 125, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Миндаль сырой", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 575, "Белки(Click to sort Ascending)": 21, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 10, "Состав(Click to sort Ascending)": "миндаль сырой", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мука миндальная", "Страна(Click to sort Ascending)": "Испания", "Калории(Click to sort Ascending)": 602, "Белки(Click to sort Ascending)": 26, "Жиры(Click to sort Ascending)": 55, "Углеводы(Click to sort Ascending)": 13, "Состав(Click to sort Ascending)": "Мука миндальная", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 510, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мука нутовая", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 387, "Белки(Click to sort Ascending)": 22, "Жиры(Click to sort Ascending)": 7, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "Мука нутовая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 170, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 23000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мука фисташковая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 557, "Белки(Click to sort Ascending)": 21, "Жиры(Click to sort Ascending)": 50, "Углеводы(Click to sort Ascending)": 7, "Состав(Click to sort Ascending)": "Мука фисташковая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 350, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мука черемуховая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 101, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 16, "Состав(Click to sort Ascending)": "Мука черемуховая", "Категории(Click to sort Ascending)": "Мука", "Цена(Click to sort Ascending)": 320, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мята Kejo", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 285, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 6, "Углеводы(Click to sort Ascending)": 22, "Состав(Click to sort Ascending)": "листья мяты сушеные,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мята Памирская", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 285, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 6, "Углеводы(Click to sort Ascending)": 22, "Состав(Click to sort Ascending)": "листья мяты сушеные,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Мята сушеная армянская", "Страна(Click to sort Ascending)": "Армения", "Состав(Click to sort Ascending)": "листья и мяты чабреца сушеные", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.03, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Натуральное сушеное манго БЕЗ сахара", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 261, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "высушенное манго без сахара,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Натуральное сушеное помело БЕЗ сахара", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 90, "Белки(Click to sort Ascending)": 1, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 67, "Состав(Click to sort Ascending)": "натуральное сушеное помело", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 170, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Натуральный банан вяленый БЕЗ сахара", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 346, "Белки(Click to sort Ascending)": 4, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 88, "Состав(Click to sort Ascending)": "натуральный банан вяленый.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 155, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Натуральный сушеный ананас БЕЗ сахара", "Страна(Click to sort Ascending)": "Вьетнам", "Калории(Click to sort Ascending)": 275, "Белки(Click to sort Ascending)": 3, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 65, "Состав(Click to sort Ascending)": "натуральный сушеный ананас.", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 180, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Нут крупный", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 390, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 5, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "нут крупный", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Нут стандарт", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 390, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 5, "Углеводы(Click to sort Ascending)": 66, "Состав(Click to sort Ascending)": "нут стандарт", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Озорной фрукт", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: гибискус, яблоко, шиповник, изюм, абрикос, персик, ананас, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 85, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Пекан очищенный", "Страна(Click to sort Ascending)": "Чили", "Калории(Click to sort Ascending)": 691, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 72, "Углеводы(Click to sort Ascending)": 14, "Состав(Click to sort Ascending)": "пекан очищенный", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 205, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Премиум смесь женская antiage", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 303, "Белки(Click to sort Ascending)": 11, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 75, "Состав(Click to sort Ascending)": "порошок из корня маки, порошок из банана, порошок мескита, порошок хуанарпо мачо, какао-порошок, молотый имбирь,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 175, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Премиум смесь\"Иммунитет 7 суперфудов\"", "Страна(Click to sort Ascending)": "Перу", "Калории(Click to sort Ascending)": 317, "Белки(Click to sort Ascending)": 13, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 73, "Состав(Click to sort Ascending)": "порошок мескита (перуанский кэроб), порошок из бразильского ореха, молотая фиолетовая кукуруза, молотый имбирь, порошок из лукумы, порошок из фрукта нони, порошок Камю Камю,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 175, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Рецепт долголетия", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, кусочки ананаса, лепестки сафлора, цедра лимона, ароматизаторы.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Рис Басмати", "Страна(Click to sort Ascending)": "Индия", "Калории(Click to sort Ascending)": 331, "Белки(Click to sort Ascending)": 8, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 74, "Состав(Click to sort Ascending)": "рис басмати", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 105, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Ройбуш классический", "Страна(Click to sort Ascending)": "ЮАР", "Состав(Click to sort Ascending)": "Состав: высушенные и измельчённые листья и побеги аспалатуса линейного", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 115, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Ройбуш черничный", "Страна(Click to sort Ascending)": "ЮАР", "Состав(Click to sort Ascending)": "Состав: высушенные и измельчённые листья и побеги аспалатуса линейного, ароматизатор", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 125, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена подсолнуха н\/о жареные", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 601, "Белки(Click to sort Ascending)": 21, "Жиры(Click to sort Ascending)": 52, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "семена подсолнуха н\/о жареные", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 40, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена подсолнуха н\/о сырые", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 601, "Белки(Click to sort Ascending)": 21, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "семена подсолнуха н\/о сырые", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 35, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена подсолнуха очищенные", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 574, "Белки(Click to sort Ascending)": 30, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 8, "Состав(Click to sort Ascending)": "семена подсолнуха очищенные", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена тыквы н\/о жареные", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 574, "Белки(Click to sort Ascending)": 30, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 8, "Состав(Click to sort Ascending)": "семена тыквы н\/о жареные", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 45, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена тыквы н\/о", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 559, "Белки(Click to sort Ascending)": 30, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "семена тыквы н\/о", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 55, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена тыквы очищенные", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 559, "Белки(Click to sort Ascending)": 30, "Жиры(Click to sort Ascending)": 49, "Углеводы(Click to sort Ascending)": 11, "Состав(Click to sort Ascending)": "семена тыквы очищенные", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 55, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Семена чиа", "Страна(Click to sort Ascending)": "Парагвай", "Калории(Click to sort Ascending)": 486, "Белки(Click to sort Ascending)": 17, "Жиры(Click to sort Ascending)": 31, "Углеводы(Click to sort Ascending)": 8, "Состав(Click to sort Ascending)": "семена чиа", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Соль розовая гималайская, мелкий помол", "Страна(Click to sort Ascending)": "Пакистан", "Калории(Click to sort Ascending)": 5, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 1, "Состав(Click to sort Ascending)": "розовая гималайская соль,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 45, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Соль черная гималайская, мелкий помол", "Страна(Click to sort Ascending)": "Пакистан", "Калории(Click to sort Ascending)": 1, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 0, "Состав(Click to sort Ascending)": "черная гималайская соль,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 45, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Спирулина, порошок", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 350, "Белки(Click to sort Ascending)": 60, "Жиры(Click to sort Ascending)": 8, "Углеводы(Click to sort Ascending)": 15, "Состав(Click to sort Ascending)": "молотые одноклеточные водоросли спирулина,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 140, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Сушеный ананас кубиками микс цукат", "Страна(Click to sort Ascending)": "Тайланд", "Калории(Click to sort Ascending)": 91, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 18, "Состав(Click to sort Ascending)": "ананас, сахар, пищевой краситель,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Топинамбур Премиум, сушеный молотый", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 346, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 73, "Состав(Click to sort Ascending)": "сушеный молотый топинамбур,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 85, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Тыква Премиум, порошок", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 290, "Белки(Click to sort Ascending)": 40, "Жиры(Click to sort Ascending)": 10, "Углеводы(Click to sort Ascending)": 23, "Состав(Click to sort Ascending)": "порошок из семян тыквы,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 215, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Тыква Премиум, с высоким содержанием белка", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 290, "Белки(Click to sort Ascending)": 40, "Жиры(Click to sort Ascending)": 10, "Углеводы(Click to sort Ascending)": 23, "Состав(Click to sort Ascending)": "порошок из семян тыквы,", "Категории(Click to sort Ascending)": "Суперфуды", "Цена(Click to sort Ascending)": 215, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Улун банановый", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: улун, ароматизатор. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Улун Шоколадный", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: улун, ароматизатор. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фасоль белая с черными точками", "Страна(Click to sort Ascending)": "Узбекистан", "Калории(Click to sort Ascending)": 340, "Белки(Click to sort Ascending)": 23, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 60, "Состав(Click to sort Ascending)": "фасоль белая с черными точками", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Финики иранские в коробке", "Страна(Click to sort Ascending)": "Иран", "Калории(Click to sort Ascending)": 292, "Белки(Click to sort Ascending)": 25, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 69, "Состав(Click to sort Ascending)": "финики иранские", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 220, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Финики королевские Экстра", "Страна(Click to sort Ascending)": "Израиль", "Калории(Click to sort Ascending)": 277, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 75, "Состав(Click to sort Ascending)": "финики королевские экстра", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 110, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Финики королевские", "Страна(Click to sort Ascending)": "Израиль", "Калории(Click to sort Ascending)": 294, "Белки(Click to sort Ascending)": 3, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 69, "Состав(Click to sort Ascending)": "плоды финиковой пальмы,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Финики Шоколад", "Страна(Click to sort Ascending)": "Иран", "Калории(Click to sort Ascending)": 282, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 75, "Состав(Click to sort Ascending)": "финики шоколад", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 85, "Единица (сис)(Click to sort Ascending)": 0.3, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фисташки жареные соленые", "Страна(Click to sort Ascending)": "Иран", "Калории(Click to sort Ascending)": 610, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 50, "Углеводы(Click to sort Ascending)": 30, "Состав(Click to sort Ascending)": "обжаренные в скорлупе фисташки, соль,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 125, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фисташки сырые", "Страна(Click to sort Ascending)": "Иран", "Калории(Click to sort Ascending)": 562, "Белки(Click to sort Ascending)": 20, "Жиры(Click to sort Ascending)": 45, "Углеводы(Click to sort Ascending)": 28, "Состав(Click to sort Ascending)": "фисташки сырые", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фруктовая смесь Клубничный зефир", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: гибискус, кусочки яблока, клубники, шиповник, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 77, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук в белом шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 591, "Белки(Click to sort Ascending)": 9, "Жиры(Click to sort Ascending)": 59, "Углеводы(Click to sort Ascending)": 36, "Состав(Click to sort Ascending)": "обжаренный фундук, белая шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук в скорлупе", "Страна(Click to sort Ascending)": "Дагестан", "Калории(Click to sort Ascending)": 650, "Белки(Click to sort Ascending)": 15, "Жиры(Click to sort Ascending)": 61, "Углеводы(Click to sort Ascending)": 9, "Состав(Click to sort Ascending)": "фундук в скорлупе", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук в темном шоколаде", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 577, "Белки(Click to sort Ascending)": 5, "Жиры(Click to sort Ascending)": 41, "Углеводы(Click to sort Ascending)": 39, "Состав(Click to sort Ascending)": "обжаренный фундук, темная шоколадная глазурь,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук обжаренный", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 629, "Белки(Click to sort Ascending)": 14, "Жиры(Click to sort Ascending)": 61, "Углеводы(Click to sort Ascending)": 17, "Состав(Click to sort Ascending)": "очищенные и обжаренные ядра фундука,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Фундук сырой", "Страна(Click to sort Ascending)": "Дагестан", "Калории(Click to sort Ascending)": 651, "Белки(Click to sort Ascending)": 15, "Жиры(Click to sort Ascending)": 62, "Углеводы(Click to sort Ascending)": 9, "Состав(Click to sort Ascending)": "фундук сырой", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Хурма вяленая", "Страна(Click to sort Ascending)": "Армения", "Калории(Click to sort Ascending)": 241, "Белки(Click to sort Ascending)": 1, "Жиры(Click to sort Ascending)": 0, "Углеводы(Click to sort Ascending)": 37, "Состав(Click to sort Ascending)": "вяленая хурма, сахар,", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 240, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Цукаты помело", "Страна(Click to sort Ascending)": "Тайланд", "Состав(Click to sort Ascending)": "помело, сахар 60-65%, диоксид серы, лимонная кислота", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чабрец высокогорный Kejo", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "стебель, лист, цветы чабреца,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чабрец Памир", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "стебель, лист, цветы чабреца,", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 0, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чабрец сушеный армянский", "Страна(Click to sort Ascending)": "Армения", "Состав(Click to sort Ascending)": "листья и стебли чабреца сушеные", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.03, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Азерчай", "Страна(Click to sort Ascending)": "Азербайджан", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 65, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай бронхиальный сбор", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: трава мать-и-мачехи, ежевика, чабрец, подорожник, цветки ромашки, листья подсолнечника, липа, бузина, зверобой", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Годжи-Земляника", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, ягоды Годжи, земляники, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Граф Грей", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный китайский чай, бергамот, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Дяньхун", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый \"Земляника со сливками\"", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: зеленый чай, кусочки земляники, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 67, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый Жасминовый (с бутонами)", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: зеленый листовой чай, цветы жасмина, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый Имбирный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: зеленый чай, имбирь. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 65, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый с мятой", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: зеленый чай ганпаудер, натуральная мята.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый с чабрецом", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: зеленый чай, чабрец. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 45, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай зеленый Фрукты тропиков", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный индийский чай, сушеное манго, ананас, киви, персик, папайя, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 60, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Кокосовый улун (оолонг)", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: улун, ароматизатор. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 69, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Король солнце", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: индийский черный чай, корица, имбирь, лепестки календулы, ароматизатор. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Лапсанг Сушонг", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 130, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Молочный улун (Най Сян Улун)", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 98, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Монастырский", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, мята, душица, липовый цвет, зверобой, корень девясила и шиповник.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 125, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Пуэр То ча", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: китайский чёрный чай Пуэр", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 25, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Пуэр Хайвань мини чаши, Класс А", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 35, "Единица (сис)(Click to sort Ascending)": 1.0, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай с чабрецом", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, чабрец.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 65, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Сенча", "Страна(Click to sort Ascending)": "Китай", "Состав(Click to sort Ascending)": "Состав: Чай сенча", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 47, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Таёжное озеро", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, ягоды клюквы, облепихи, рябины, сосновые почки и плоды можжевельника, листья смородины и крапивы, ароматизаторы.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 120, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Те Гуань инь", "Страна(Click to sort Ascending)": "Китай", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 80, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай Черника в йогурте", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: отборный цейлонский черный чай, ягоды черники, лепестки василька, листья смородины, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 90, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай черный Витаминный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: индийский черный чай, цейлонский черный чай, ягоды и листья смородины, плоды боярышника, шиповник, цедра апельсина, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 81, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай черный Земляника со сливками", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, кусочки земляники, ароматизатор.", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 77, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай черный Имбирный", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "Состав: черный чай, имбирь. ", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 83, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чай черный Шоколадный коктейль", "Страна(Click to sort Ascending)": "Россия", "Состав(Click to sort Ascending)": "черный индийский чай, кусочки молочной карамели,какао-бобов, ягод облепихи и брусники, ароматизатор", "Категории(Click to sort Ascending)": "Чай", "Цена(Click to sort Ascending)": 75, "Единица (сис)(Click to sort Ascending)": 0.05, "Сыпучка(Click to sort Ascending)": 30000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чернослив без косточек", "Страна(Click to sort Ascending)": "Чили", "Калории(Click to sort Ascending)": 261, "Белки(Click to sort Ascending)": 2, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "чернослив без косточек", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.2, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чечевица красная", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 284, "Белки(Click to sort Ascending)": 24, "Жиры(Click to sort Ascending)": 1, "Углеводы(Click to sort Ascending)": 54, "Состав(Click to sort Ascending)": "чечевица красная", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 100, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чечевица", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 319, "Белки(Click to sort Ascending)": 24, "Жиры(Click to sort Ascending)": 2, "Углеводы(Click to sort Ascending)": 53, "Состав(Click to sort Ascending)": "чечевица", "Категории(Click to sort Ascending)": "Крупы и Макаронные изделия", "Цена(Click to sort Ascending)": 70, "Единица (сис)(Click to sort Ascending)": 0.5, "Сыпучка(Click to sort Ascending)": 25500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Чиа черная Премиум, мука жмыховая", "Страна(Click to sort Ascending)": "Россия", "Калории(Click to sort Ascending)": 890, "Белки(Click to sort Ascending)": 0, "Жиры(Click to sort Ascending)": 99, "Состав(Click to sort Ascending)": "мука из семян чиа,", "Категории(Click to sort Ascending)": "2  Список", "Цена(Click to sort Ascending)": 190, "Единица (сис)(Click to sort Ascending)": 0.25, "Сыпучка(Click to sort Ascending)": 28500 }, "geometry": null },
        { "type": "Feature", "properties": { "(Click to sort Ascending)": "Ягоды Годжи", "Страна(Click to sort Ascending)": "Китай", "Калории(Click to sort Ascending)": 343, "Белки(Click to sort Ascending)": 12, "Жиры(Click to sort Ascending)": 7, "Углеводы(Click to sort Ascending)": 58, "Состав(Click to sort Ascending)": "ягоды годжи", "Категории(Click to sort Ascending)": "Сухофрукты", "Цена(Click to sort Ascending)": 150, "Единица (сис)(Click to sort Ascending)": 0.1, "Сыпучка(Click to sort Ascending)": 25000 }, "geometry": null }
      ]
    }');

    $more = array(
      7422 => array('Название' => 'Чабрец сушеный армянский', 'Страна' => 'Армения', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => '', 'Категории' => '2  Список', 'Цена за 1кг' => '2500'),
      7423 => array('Название' => 'Мята сушеная армянская', 'Страна' => 'Армения', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => '', 'Категории' => '2  Список', 'Цена за 1кг' => '2500'),
      14618 => array('Название' => 'Шафран листья (Сафлора)', 'Страна' => 'Индия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Шафран листья (Сафлора)', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '3600'),
      14619 => array('Название' => 'Бадьян', 'Страна' => 'Вьетнам', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Бадьян', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1700'),
      14620 => array('Название' => 'Барбарис красный', 'Страна' => 'Иран', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Барбарис красный', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1700'),
      14621 => array('Название' => 'Барбарис черный', 'Страна' => 'Узбекистан', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Барбарис черный', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '900'),
      14622 => array('Название' => 'Корица китайская', 'Страна' => 'Индонезия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'корица китайская (коричник китайский)', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1500'),
      14623 => array('Название' => 'Анис плоды', 'Страна' => 'Египет', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Анис плоды', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '800'),
      14624 => array('Название' => 'Базилик сушеный', 'Страна' => 'Египет', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Базилик', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14625 => array('Название' => 'Баклажан сушеный', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Баклажан сушеный', 'Категории' => '2  Список', 'Цена за 1кг' => '434'),
      14626 => array('Название' => 'Гвоздика целая', 'Страна' => 'Коморские острова', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Гвоздика целая', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1500'),
      14627 => array('Название' => 'Гвоздика молотая', 'Страна' => 'Коморские острова', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Гвоздика молотая', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '700'),
      14628 => array('Название' => 'Капуста сушеная', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Капуста сушеная', 'Категории' => '2  Список', 'Цена за 1кг' => '300'),
      14629 => array('Название' => 'Кардамон молотый', 'Страна' => 'Гватемала', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Кардамон молотый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1500'),
      14630 => array('Название' => 'Кардамон целый (зерно)', 'Страна' => 'Гватемала', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Кардамон целый (зерно)', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '9200'),
      14631 => array('Название' => 'Карри нежная', 'Страна' => 'Индия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Карри', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14632 => array('Название' => 'Картофель сушеный', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Картофель сушеный', 'Категории' => '2  Список', 'Цена за 1кг' => '300'),
      14633 => array('Название' => 'Лук сушеный белый', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Лук сушеный белый', 'Категории' => '2  Список', 'Цена за 1кг' => '534'),
      14634 => array('Название' => 'Лук сушеный розовый', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Лук сушеный розовый', 'Категории' => '2  Список', 'Цена за 1кг' => '400'),
      14635 => array('Название' => 'Майоран', 'Страна' => 'Египет', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Майоран', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14636 => array('Название' => 'Морковь сушеная', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Морковь сушеная', 'Категории' => '2  Список', 'Цена за 1кг' => '2000'),
      14637 => array('Название' => 'Мускатный орех молотый', 'Страна' => 'Индонезия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Мускатный орех молотый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '700'),
      14638 => array('Название' => 'Мускатный орех целый', 'Страна' => 'Индонезия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Мускатный орех целый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1900'),
      14639 => array('Название' => 'Орегано сушеный', 'Страна' => 'Турция', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Орегано', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14640 => array('Название' => 'Мята сушеная', 'Страна' => 'Египет', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Мята сушеная', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14641 => array('Название' => 'Перец зеленый горошек', 'Страна' => 'Индонезия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец зеленый горошек', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '2300'),
      14642 => array('Название' => 'Перец белый молотый', 'Страна' => 'Вьетнам', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец белый молотый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14643 => array('Название' => 'Перец белый горошек', 'Страна' => 'Вьетнам', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец белый горошек', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1000'),
      14644 => array('Название' => 'Перец душистый молотый', 'Страна' => 'Мексика', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец душистый молотый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '700'),
      14645 => array('Название' => 'Перец душистый горошек', 'Страна' => 'Мексика', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец душистый горошек', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1000'),
      14646 => array('Название' => 'Перец розовый горошек', 'Страна' => 'Индонезия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец розовый горошек', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '2900'),
      14647 => array('Название' => 'Перец черный горошек', 'Страна' => 'Индонезия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец черный горошек', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '800'),
      14648 => array('Название' => 'Перец черный дробленый', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец черный дробленый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '900'),
      14649 => array('Название' => 'Перец черный молотый в/c', 'Страна' => 'Индонезия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец черный молотый в/c', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14650 => array('Название' => 'Петрушка сушеная', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Петрушка сушеная', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14651 => array('Название' => 'Смесь приправ Вегета (универсальная приправа)', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'морковь, паприка красная, паприка зеленая, чеснок сушеный гранулы, лук, лук-порей, петрушка зелень, пастернак корень, укроп зелень, томатные хлопья, орегано, базилик.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '400'),
      14652 => array('Название' => 'Розмарин сушеный', 'Страна' => 'Марокко', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Розмарин сушеный', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '800'),
      14653 => array('Название' => 'Свекла сушеная', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Свекла сушеная', 'Категории' => '2  Список', 'Цена за 1кг' => '300'),
      14654 => array('Название' => 'Смесь пяти перцев (горошек)', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'черный перец горошек, белый перец горошек, зеленый перец горошек, розовый перец горошек, душистый перец горошек.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1100'),
      14655 => array('Название' => 'Смесь овощное ассорти', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'морковь, паприка красная, паприка зеленая, чеснок сушеный гранулы, лук, лук-порей, петрушка зелень, пастернак корень, укроп зелень, томатные хлопья, орегано, базилик.', 'Категории' => '2  Список', 'Цена за 1кг' => '4400'),
      14656 => array('Название' => 'Смесь приправ для моркови по-корейски в/c', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'кориандр, смесь перцев, чеснок, куркума, лук, пажитник, паприка красная.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14657 => array('Название' => 'Смесь приправ для плова в/c', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'барбарис, имбирь, кумин, лук, морковь, орех мускатный, петрушка, укроп, чеснок, паприка красная, соль.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14658 => array('Название' => 'Смесь приправ для шаурмы в/с', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'томаты, тмин, лук, укроп, кориандр, куркума, паприка красная, перец красный, перец черный, чеснок, соль.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14659 => array('Название' => 'Смесь приправ Прованские травы', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'розмарин, базилик, тимьян, майоран, чабер, орегано.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '700'),
      14660 => array('Название' => 'Смесь приправ Итальянская', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'орегано, чеснок, базилик, чабер, лук.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '800'),
      14661 => array('Название' => 'Томаты сушеные', 'Страна' => 'Армения', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Томаты сушёные', 'Категории' => '2  Список', 'Цена за 1кг' => '1367'),
      14662 => array('Название' => 'Сумах', 'Страна' => 'Израиль', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Сумах', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '700'),
      14663 => array('Название' => 'Тимьян сушеный', 'Страна' => 'Марокко', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'тимьян сушеный', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '700'),
      14664 => array('Название' => 'Укроп семена', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Укроп семена', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14665 => array('Название' => 'Уцхо-сунели', 'Страна' => 'Грузия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'уцхо-сунели', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14666 => array('Название' => 'Фенхель семена', 'Страна' => 'Египет', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Фенхель семена', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14667 => array('Название' => 'Хмели-сунели', 'Страна' => 'Грузия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'кориандр, куркума, пажитник, базилик, лавровый лист, петрушка, укроп, майоран.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14668 => array('Название' => 'Чабер (кондари)', 'Страна' => 'Польша', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Чабер (кондари)', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14669 => array('Название' => 'Ванилин', 'Страна' => 'Китай', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Ванилин', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14671 => array('Название' => 'Глутамат натрия', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Глутамат натрия', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14672 => array('Название' => 'Горчица молотая', 'Страна' => 'Индия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Горчица молотая', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '175'),
      14673 => array('Название' => 'Горчица целая', 'Страна' => 'Индия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Горчица целая', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '250'),
      14674 => array('Название' => 'Желатин', 'Страна' => 'Польша', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Желатин', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1100'),
      14675 => array('Название' => 'Зира семена', 'Страна' => 'Иран', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Зира семена', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '700'),
      14676 => array('Название' => 'Зира целая', 'Страна' => 'Таджикистан', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Зира целая', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '1400'),
      14677 => array('Название' => 'Зира молотая', 'Страна' => 'Иран', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Зира молотая', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14678 => array('Название' => 'Имбирь корень молотый', 'Страна' => 'Китай', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Имбирь корень молотый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14679 => array('Название' => 'Кориандр молотый', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Кориандр молотый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '400'),
      14680 => array('Название' => 'Кориандр семена', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Кориандр семена', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '400'),
      14681 => array('Название' => 'Куркума корень', 'Страна' => 'Индия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Куркума корень', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '700'),
      14682 => array('Название' => 'Куркума молотая в/с', 'Страна' => 'Индия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Куркума молотая в/с', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14683 => array('Название' => 'Лавровый лист в/с', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Лавровый лист в/с', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '800'),
      14684 => array('Название' => 'Лимонная кислота', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Лимонная кислота', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '300'),
      14685 => array('Название' => 'Пажитник (чаман) молотый', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Пажитник (чаман) молотый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '400'),
      14686 => array('Название' => 'Пажитник (чаман) целый', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Пажитник (чаман) целый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '400'),
      14687 => array('Название' => 'Перец острый дробленый', 'Страна' => 'Индия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец острый дробленый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '900'),
      14688 => array('Название' => 'Перец острый молотый 100%', 'Страна' => 'Мексика', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец острый молотый 100%', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14689 => array('Название' => 'Перец сладкий дробленый в/с', 'Страна' => 'Индия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец сладкий дробленый в/с', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '900'),
      14690 => array('Название' => 'Перец сладкий молотый паприка в/с', 'Страна' => 'Индонезия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Перец сладкий молотый паприка в/с', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '800'),
      14691 => array('Название' => 'Смесь приправ для мяса в/с', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'пряные травы, перец, соль.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14692 => array('Название' => 'Смесь приправ для первых блюд в/с', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'лук, чеснок, томаты, морковь, паприка красная и зеленая, укроп, сельдерей, соль.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14693 => array('Название' => 'Смесь приправ для рыбы в/с', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'гвоздика, имбирь, кориандр, корица, куркума, орех мускатный, перец душистый, перец черный, соль.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14694 => array('Название' => 'Смесь приправ для свинины в/с', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'перец черный, майоран, куркума, паприка красная, укроп, хмели-сунели, морковь, перец красный острый, соль.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14695 => array('Название' => 'Смесь приправ для шашлыка в/с', 'Страна' => 'Абхазия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'смесь перцев, пряные травы, имбирь, лук, чеснок, куркума, гвоздика, томаты, соль.', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
      14696 => array('Название' => 'Тмин молотый', 'Страна' => 'Египет', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Тмин молотый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14697 => array('Название' => 'Тмин семена', 'Страна' => 'Египет', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Тмин семена', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14698 => array('Название' => 'Тмин черный', 'Страна' => 'Таджикистан', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Тмин черный', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '800'),
      14699 => array('Название' => 'Чеснок гранулированный', 'Страна' => 'Россия', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Чеснок гранулированный', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '600'),
      14700 => array('Название' => 'Чеснок молотый', 'Страна' => 'Китай', 'Калории' => '', 'Белки' => '', 'Жиры' => '', 'Углеводы' => '', 'Состав' => 'Чеснок молотый', 'Категории' => 'Специи на развес', 'Цена за 1кг' => '500'),
    );

    //Add more
    foreach ($more as $key => $v) {
      $add = [];
      $add['properties'] = [];
      $add = (object) $add;
      $properties = [];
      $properties['(Click to sort Ascending)'] = $v['Название'];
      $properties['Страна(Click to sort Ascending)'] = $v['Страна'];
      $properties['Калории(Click to sort Ascending)'] = $v['Калории'];
      $properties['Белки(Click to sort Ascending)'] = $v['Белки'];
      $properties['Жиры(Click to sort Ascending)'] = $v['Жиры'];
      $properties['Углеводы(Click to sort Ascending)'] = $v['Углеводы'];
      $properties['Состав(Click to sort Ascending)'] = $v['Состав'];
      $properties['Цена(Click to sort Ascending)'] = $v['Цена за 1кг'];
      $properties['Единица (сис)(Click to sort Ascending)'] = 1;
      $properties['Состав(Click to sort Ascending)'] = $v['Состав'];
      $properties = (object) $properties;
      $add->properties = $properties;
      array_push($data->features,$add);
    }

    // dd()

    // dd($data,$more);

    $content = '';
    $list = '';

    foreach ($data->features as $key => $item) {
      $v = $item->properties;
              
      //Set name
      if('name' == 'name'){
        $name = '(Click to sort Ascending)';
        $len = iconv_strlen($v->$name);
        if($len > 79){
          dump($v->$name);
          continue;
        } 
        for ($i=0; $i < (80 - $len); $i++) { 
          $v->$name .= ' ';
        }
      }

      //Set button
      if('button' == 'button'){
        $button = $key+1;
        $len = iconv_strlen($button);
        $pre_button = '';
        for ($i=0; $i < (15 - $len); $i++) { 
          $pre_button .= '0';
        }
        $button = $pre_button . $button;
      }

      //set price
      if('price' == 'price'){
        $price = 'Цена(Click to sort Ascending)';
        $unit = 'Единица (сис)(Click to sort Ascending)';

        if(!is_numeric($v->$unit) || !is_numeric($v->$price)){
          dump('unit / price not number');
          dd($v);
        }

        $price_full = number_format((float)((1 / $v->$unit) * $v->$price), 2, '.', '');
        $len = iconv_strlen($price_full);
        $pre = '';
        for ($i=0; $i < (8 - $len); $i++) { 
          $pre .= '0';
        }
        $price_full = $pre . $price_full;
      }

      
      $pa1 = 'A220000100000';
      $pa2_button = $button;
      $pa3 = '0001000100';
      $pa4_price = $price_full;
      $pa5_days = '000';
      $pa6 = '0000';
      $pa7_name = $v->$name;
      $pa8 = "\r\n";

      $string = $pa1.$pa2_button.$pa3.$pa4_price.$pa5_days.$pa6.$pa7_name;

      //set country
      if('country' == 'country'){
        $country = 'Страна(Click to sort Ascending)';

        $val = 'Страна: ' . $v->$country;
        $len = iconv_strlen($val);
        if($len > 48){
          dump('bad country', $v);
          continue;
        }

        $len = iconv_strlen($val);
        for ($i=0; $i < (100 - $len); $i++) { 
          $val .= ' ';
        }
        
        $string .= $val;
      }

      //Ccal
      if('ccal' == 'ccal'){
        
        $name = 'Калории(Click to sort Ascending)';
        if(isset($v->$name)){
          $val = 'Калории: ' . $v->$name;
          $len = iconv_strlen($val);
          if($len > 48){
            dump('bad Калории', $val);
            continue;
          }

          $len = iconv_strlen($val);
          for ($i=0; $i < (100 - $len); $i++) { 
            $val .= ' ';
          }
          
          $string .= $val;
        }
      }     

      //Бжу
      if('Бжу' == 'Бжу'){
        $prots = 'Белки(Click to sort Ascending)';
        $fats = 'Жиры(Click to sort Ascending)';
        $carbs = 'Углеводы(Click to sort Ascending)';

        if(isset($v->$prots) && isset($v->$fats) && isset($v->$carbs)){

          $val = "БЖУ: {$v->$prots}/{$v->$fats}/{$v->$carbs}" ;
          $len = iconv_strlen($val);
          if($len > 48){
            dump('bad БЖУ', $v, $val);
            continue;
          }
          
          $len = iconv_strlen($val);
          for ($i=0; $i < (100 - $len); $i++) { 
            $val .= ' ';
          }
          
          $string .= $val;
        }
      }    
      
      //Состав
      if('Состав' == 'Состав'){
        
        $name = 'Состав(Click to sort Ascending)';
        if(isset($v->$name)){
          $val = $v->$name;
          $val = 'Состав: ' . $v->$name;            
          $val = str_replace('Состав: Состав:','Состав:',$val);
          $len = iconv_strlen($val);
          $more_sostav = [];
          if($len > 48){
            $left = $val;
            do{                
              $str = mb_substr  ( $left , 0, 45 );
              $left = mb_substr  ( $left , 45 );                
              array_push($more_sostav,$str);                
              if($left == FALSE ) break;
            }while(1);
            
            if(count($more_sostav) > 5){
              dump('bad Состав', $val);
              continue;
            }
          }

          if(count($more_sostav) == 0){
            $more_sostav[1] = $val;
          }

          foreach ($more_sostav as $key => $val) {
            $len = iconv_strlen($val);
            for ($i=0; $i < (100 - $len); $i++) { 
              $val .= ' ';
            }
            $string .= $val;
          }           
          
        }
      }  

      $string .= "\r\n";

      $content .= $string;

      $list .= $pa2_button . '  ' . $pa7_name . "\r\n";

    }

    $b = "B00010001Товарная группа #1            \r\n";
    $a = "T0001Отдел поставки товаров        \r\n";
    
    $content = $b . $content . $a;

    Storage::disk('local')->put('up95.txt', mb_convert_encoding($content, 'Windows-1251'));

    dump($list);

    dd($content);
    
  });

  Route::get('make/vesi/odin', function(){
    //
    
    $data = json_decode('{
      "type": "FeatureCollection",
      "name": "Sheet1",
      "crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:EPSG::3857" } },
      "features": [
        { "type": "Feature", "properties": { "Field1": "(Click to sort Ascending)", "Field2": "Название(Click to sort Ascending)", "Field3": "Страна(Click to sort Ascending)", "Field4": "Калории(Click to sort Ascending)", "Field5": "Белки(Click to sort Ascending)", "Field6": "Жиры(Click to sort Ascending)", "Field7": "Углеводы(Click to sort Ascending)", "Field8": "Условия хранения\/составы", "Field9": "Категории(Click to sort Ascending)", "Field10": "Цена(Click to sort Ascending)", "Field11": "Единица (сис)(Click to sort Ascending)", "Field12": "Сыпучка(Click to sort Ascending)", "Field13": "цена", "Field14": "ОТОБРАЖАТЬ ДАТУ ПЕЧАТИ ЭТИКЕТКИ!!!" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "13789", "Field2": "Форель потрошеная холодного копчения", "Field3": "Россия", "Field4": "132", "Field5": "26", "Field6": "3", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "500.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "13782", "Field2": "Форель потрошеная с головой в пряном маринаде", "Field3": "Россия", "Field4": "100", "Field5": "19", "Field6": "2", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "350.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "13787", "Field2": "Форель потрошеная с головой", "Field3": "Россия", "Field4": "97", "Field5": "19", "Field6": "2", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "330.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "13788", "Field2": "Форель потрошеная с головой", "Field3": "Россия", "Field4": "97", "Field5": "19", "Field6": "2", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "660.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12881", "Field2": "Окунь горячего копчения", "Field3": "Норвегия", "Field4": "175", "Field5": "23", "Field6": "9", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "480.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12900", "Field2": "Тунец филе свежемороженное", "Field3": "Китай", "Field4": "139", "Field5": "24", "Field6": "4", "Field7": "0", "Field8": "Срок годности: 12 месяцев при t -18С", "Field9": "Рыба и морепродукты", "Field10": "1100.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12869", "Field2": "Форель балык холодного копчения", "Field3": "Норвегия", "Field4": "132", "Field5": "26", "Field6": "3", "Field7": "1", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "650.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12876", "Field2": "Скумбрия горячего копчения", "Field3": "Норвегия", "Field4": "317", "Field5": "22", "Field6": "23", "Field7": "4", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "288.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12867", "Field2": "Горбуша балык холодного копчения", "Field3": "Россия", "Field4": "174", "Field5": "21", "Field6": "10", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "350.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12861", "Field2": "Чука свежемороженная", "Field3": "Китай", "Field4": "205", "Field5": "2", "Field6": "5", "Field7": "38", "Field9": "Рыба и морепродукты", "Field10": "425.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12884", "Field2": "Кальмар горячего копчения", "Field4": "128", "Field5": "21", "Field6": "4", "Field7": "2", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "400.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12899", "Field2": "Мидии замороженные", "Field4": "50", "Field5": "9", "Field6": "2", "Field7": "0", "Field9": "Рыба и морепродукты", "Field10": "550.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12862", "Field2": "Филе лосося слабой соли в вакуумной упаковке", "Field3": "Норвегия", "Field4": "233", "Field5": "21", "Field6": "16", "Field7": "1", "Field9": "Рыба и морепродукты", "Field10": "340.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12879", "Field2": "Салака горячего копчения", "Field3": "Норвегия", "Field4": "152", "Field5": "25", "Field6": "5", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "140.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12898", "Field2": "Морской коктейль замороженный", "Field3": "Китай", "Field4": "70", "Field5": "14", "Field6": "1", "Field7": "1", "Field8": "<p>кальмар полоски, кальмар щупальца, креветки, осьминог, мидии.<\/p>", "Field9": "Рыба и морепродукты", "Field10": "450.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12878", "Field2": "Горбуша горячего копчения", "Field3": "Россия", "Field4": "161", "Field5": "23", "Field6": "8", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "350.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12882", "Field2": "Лещ горячего копчения", "Field3": "Россия", "Field4": "172", "Field5": "33", "Field6": "5", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "180.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12873", "Field2": "Сельдь холодного копчения", "Field3": "Норвегия", "Field4": "217", "Field5": "25", "Field6": "12", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "150.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12871", "Field2": "Скумбрия холодного копчения", "Field3": "Норвегия", "Field4": "150", "Field5": "23", "Field6": "6", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "288.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12875", "Field2": "Зубатка пестрая горячего копчения", "Field3": "Норвегия", "Field4": "130", "Field5": "20", "Field6": "5", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "520.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12863", "Field2": "Филе лосося слабой соли в вакуумной упаковке", "Field3": "Норвегия", "Field4": "233", "Field5": "21", "Field6": "16", "Field7": "1", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С.", "Field9": "Рыба и морепродукты", "Field10": "1870.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12901", "Field2": "Угорь унаги свежемороженный", "Field3": "Южная Корея", "Field4": "220", "Field5": "28", "Field6": "17", "Field7": "3", "Field8": "<p>угорь жареный, соевый соус, кукурузный крахмал, сахар, кукурузный сироп.<\/p>", "Field9": "Рыба и морепродукты", "Field10": "1100.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12868", "Field2": "Горбуша тушка холодного копчения", "Field3": "Россия", "Field4": "174", "Field5": "21", "Field6": "10", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "350.00", "Field11": "0.5", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12902", "Field2": "Лангустины креветки без головы свежемороженные", "Field3": "Аргентина", "Field4": "112", "Field5": "20", "Field6": "2", "Field7": "2", "Field9": "Рыба и морепродукты", "Field10": "2550.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12877", "Field2": "Масляная рыба, тушка горячего копчения", "Field3": "Норвегия", "Field4": "180", "Field5": "18", "Field6": "12", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "1400.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12874", "Field2": "Филе масляной рыбы холодного копчения", "Field3": "Норвегия", "Field4": "180", "Field5": "18", "Field6": "12", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "1207.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12872", "Field2": "Филе лосося пластинами холодного копчения", "Field3": "Норвегия", "Field4": "179", "Field5": "20", "Field6": "10", "Field7": "0", "Field8": "Срок годности: 60 суток при t от -2 до 8С, 3 месяца при t -18С", "Field9": "Рыба и морепродукты", "Field10": "2200.00", "Field11": "1", "Field12": "31700" }, "geometry": null },
        { "type": "Feature", "properties": { "Field1": "12819", "Field2": "Филе лосося свежемороженное в вакуумной упаковке", "Field3": "Норвегия", "Field4": "142", "Field5": "20", "Field6": "6", "Field7": "0", "Field8": "Срок годности: 18 суток при t от -4 до 8С, 150 суток при t -18С.", "Field9": "Рыба и морепродукты", "Field10": "1496.00", "Field11": "1", "Field12": "31700" }, "geometry": null }
      ]
    }');

    $more = array(
      array('#' => '(Click to sort Ascending)', 'Название' => '(Click to sort Ascending)', 'Страна' => '(Click to sort Ascending)', 'Калории' => '(Click to sort Ascending)', 'Белки' => '(Click to sort Ascending)', 'Жиры' => '(Click to sort Ascending)', 'Углеводы' => '(Click to sort Ascending)', 'Состав' => '(Click to sort Ascending)', 'Категории' => '(Click to sort Ascending)', 'Цена за 1кг / шт' => '(Click to sort Ascending)'),
      array('#' => '14598', 'Название' => 'Курочка целая Халяль, Гюней премиум с/м', 'Страна' => 'Россия', 'Калории' => '238', 'Белки' => '18', 'Жиры' => '18', 'Углеводы' => '0', 'Состав' => 'Курочка целая', 'Категории' => 'Птица', 'Цена за 1кг / шт' => '255.00'),
      array('#' => '14615', 'Название' => 'Говяжий гуляш', 'Страна' => 'Россия', 'Калории' => '148', 'Белки' => '14', 'Жиры' => '10', 'Углеводы' => '3', 'Состав' => 'говядина', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '570.00'),
      array('#' => '14599', 'Название' => 'Кура тушка Северная', 'Страна' => 'Россия', 'Калории' => '238', 'Белки' => '18', 'Жиры' => '18', 'Углеводы' => '0', 'Состав' => 'Кура тушка', 'Категории' => 'Птица', 'Цена за 1кг / шт' => '195.00'),
      array('#' => '14610', 'Название' => 'Говядина грудинка на кости', 'Страна' => 'Россия', 'Калории' => '490', 'Белки' => '10', 'Жиры' => '50', 'Углеводы' => '0', 'Состав' => 'Говядина грудинка на кости', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '540.00'),
      array('#' => '14601', 'Название' => 'Филе бедра куриного', 'Страна' => 'Россия', 'Калории' => '136', 'Белки' => '14', 'Жиры' => '9', 'Углеводы' => '1', 'Состав' => 'Филе бедра куриного', 'Категории' => 'Птица', 'Цена за 1кг / шт' => '315.00'),
      array('#' => '14586', 'Название' => 'Шея ягненка', 'Страна' => 'Россия', 'Калории' => '220', 'Белки' => '14', 'Жиры' => '18', 'Углеводы' => '0', 'Состав' => 'Шея ягненка', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '450.00'),
      array('#' => '14587', 'Название' => 'Ягненок целый', 'Страна' => 'Россия', 'Калории' => '220', 'Белки' => '17', 'Жиры' => '17', 'Углеводы' => '1', 'Состав' => 'Ягненок целый', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '540.00'),
      array('#' => '14588', 'Название' => 'Бараний окорок на кости', 'Страна' => 'Россия', 'Калории' => '232', 'Белки' => '18', 'Жиры' => '18', 'Углеводы' => '0', 'Состав' => 'Бараний окорок на кости', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '630.00'),
      array('#' => '14589', 'Название' => 'Бараний окорок без кости', 'Страна' => 'Россия', 'Калории' => '200', 'Белки' => '17', 'Жиры' => '14', 'Углеводы' => '0', 'Состав' => 'Бараний окорок без кости', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '1035.00'),
      array('#' => '14590', 'Название' => 'Баранина-корейка корзина неочищенная', 'Страна' => 'Россия', 'Калории' => '255', 'Белки' => '16', 'Жиры' => '22', 'Углеводы' => '0', 'Состав' => 'Баранина-корейка корзина неочищенная', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '735.00'),
      array('#' => '14591', 'Название' => 'Баранина-корейка без хребта 13 ребер', 'Страна' => 'Россия', 'Калории' => '134', 'Белки' => '11', 'Жиры' => '10', 'Углеводы' => '0', 'Состав' => 'Баранина-корейка без хребта 13 ребер', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '1095.00'),
      array('#' => '14592', 'Название' => 'Бараний курдюк', 'Страна' => 'Россия', 'Калории' => '900', 'Белки' => '0', 'Жиры' => '100', 'Углеводы' => '0', 'Состав' => 'Бараний курдюк', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '500.00'),
      array('#' => '14593', 'Название' => 'Баранина лопаточная часть без кости', 'Страна' => 'Россия', 'Калории' => '199', 'Белки' => '16', 'Жиры' => '15', 'Углеводы' => '0', 'Состав' => 'Баранина лопаточная часть без кости', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '830.00'),
      array('#' => '14594', 'Название' => 'Баранина лопаточная часть на кости', 'Страна' => 'Россия', 'Калории' => '284', 'Белки' => '16', 'Жиры' => '25', 'Углеводы' => '0', 'Состав' => 'Баранина лопаточная часть на кости', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '570.00'),
      array('#' => '14595', 'Название' => 'Баранина реберная часть', 'Страна' => 'Россия', 'Калории' => '203', 'Белки' => '17', 'Жиры' => '15', 'Углеводы' => '0', 'Состав' => 'Баранина реберная часть', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '560.00'),
      array('#' => '14596', 'Название' => 'Баранина седло на кости', 'Страна' => 'Россия', 'Калории' => '192', 'Белки' => '16', 'Жиры' => '14', 'Углеводы' => '0', 'Состав' => 'Баранина седло на кости', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '650.00'),
      array('#' => '14604', 'Название' => 'Телячья вырезка', 'Страна' => 'Россия', 'Калории' => '94', 'Белки' => '19', 'Жиры' => '2', 'Углеводы' => '0', 'Состав' => 'Телятина', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '1430.00'),
      array('#' => '14605', 'Название' => 'Телятина', 'Страна' => 'Россия', 'Калории' => '97', 'Белки' => '20', 'Жиры' => '2', 'Углеводы' => '0', 'Состав' => 'Телятина', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '1305.00'),
      array('#' => '14606', 'Название' => 'Телятина корейка', 'Страна' => 'Россия', 'Калории' => '97', 'Белки' => '20', 'Жиры' => '2', 'Углеводы' => '0', 'Состав' => 'Телятина корейка', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '1575.00'),
      array('#' => '14607', 'Название' => 'Говядина бескостная задняя часть', 'Страна' => 'Россия', 'Калории' => '104', 'Белки' => '20', 'Жиры' => '3', 'Углеводы' => '0', 'Состав' => 'Говядина бескостная задняя часть', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '825.00'),
      array('#' => '14608', 'Название' => 'Говядина бескостная передняя часть', 'Страна' => 'Россия', 'Калории' => '111', 'Белки' => '20', 'Жиры' => '4', 'Углеводы' => '0', 'Состав' => 'Говядина бескостная передняя часть', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '735.00'),
      array('#' => '14609', 'Название' => 'Говядина вырезка', 'Страна' => 'Россия', 'Калории' => '113', 'Белки' => '20', 'Жиры' => '4', 'Углеводы' => '0', 'Состав' => 'Говядина вырезка', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '1560.00'),
      array('#' => '14611', 'Название' => 'Говядина тонкий край (корейка)', 'Страна' => 'Россия', 'Калории' => '166', 'Белки' => '20', 'Жиры' => '10', 'Углеводы' => '0', 'Состав' => 'Говядина тонкий край (корейка)', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '600.00'),
      array('#' => '14612', 'Название' => 'Говядина толстый край (шея)', 'Страна' => 'Россия', 'Калории' => '130', 'Белки' => '17', 'Жиры' => '7', 'Углеводы' => '0', 'Состав' => 'Говядина толстый край (шея)', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '600.00'),
      array('#' => '14613', 'Название' => 'Говяжий антрекот на кости', 'Страна' => 'Россия', 'Калории' => '220', 'Белки' => '30', 'Жиры' => '11', 'Углеводы' => '0', 'Состав' => 'Говяжий антрекот на кости', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '600.00'),
      array('#' => '14614', 'Название' => 'Говядина голяшка без кости задняя', 'Страна' => 'Россия', 'Калории' => '187', 'Белки' => '19', 'Жиры' => '12', 'Углеводы' => '0', 'Состав' => 'Говядина голяшка без кости задняя', 'Категории' => 'Фермерское мясо', 'Цена за 1кг / шт' => '570.00'),
      array('#' => '14597', 'Название' => 'Цыплята-корнишоны', 'Страна' => 'Россия', 'Калории' => '139', 'Белки' => '19', 'Жиры' => '7', 'Углеводы' => '1', 'Состав' => 'Цыплята-корнишоны', 'Категории' => 'Птица', 'Цена за 1кг / шт' => '265.00'),
      array('#' => '14600', 'Название' => 'Филе грудки куриной', 'Страна' => 'Россия', 'Калории' => '113', 'Белки' => '24', 'Жиры' => '2', 'Углеводы' => '1', 'Состав' => 'Филе грудки куриной', 'Категории' => 'Птица', 'Цена за 1кг / шт' => '300.00'),
      array('#' => '14602', 'Название' => 'Индейка грудка филе', 'Страна' => 'Россия', 'Калории' => '114', 'Белки' => '24', 'Жиры' => '2', 'Углеводы' => '0', 'Состав' => 'Индейка грудка филе', 'Категории' => 'Птица', 'Цена за 1кг / шт' => '465.00'),
      array('#' => '14603', 'Название' => 'Индейка бедро филе', 'Страна' => 'Россия', 'Калории' => '116', 'Белки' => '21', 'Жиры' => '4', 'Углеводы' => '0', 'Состав' => 'Индейка бедро филе', 'Категории' => 'Птица', 'Цена за 1кг / шт' => '505.00'),
    );

    // +"Field1": "(Click to sort Ascending)"
    // +"Field2": "Название(Click to sort Ascending)"
    // +"Field3": "Страна(Click to sort Ascending)"
    // +"Field4": "Калории(Click to sort Ascending)"
    // +"Field5": "Белки(Click to sort Ascending)"
    // +"Field6": "Жиры(Click to sort Ascending)"
    // +"Field7": "Углеводы(Click to sort Ascending)"
    // +"Field8": "Условия хранения/составы"
    // +"Field9": "Категории(Click to sort Ascending)"
    // +"Field10": "Цена(Click to sort Ascending)"
    // +"Field11": "Единица (сис)(Click to sort Ascending)"
    // +"Field12": "Сыпучка(Click to sort Ascending)"
    // +"Field13": "цена"
    // +"Field14": "ОТОБРАЖАТЬ ДАТУ ПЕЧАТИ ЭТИКЕТКИ!!!"

    // +"Field1": "13782"
    // +"Field2": "Форель потрошеная с головой в пряном маринаде"
    // +"Field3": "Россия"
    // +"Field4": "100"
    // +"Field5": "19"
    // +"Field6": "2"
    // +"Field7": "1"
    // +"Field9": "Рыба и морепродукты"
    // +"Field10": "350.00"
    // +"Field11": "0.5"
    // +"Field12": "31700"

    //Add more
    foreach ($more as $key => $v) {
      $add = [];
      $add['properties'] = [];
      $add = (object) $add;
      $properties = [];
      $properties['Field1'] = $v['#'];
      $properties['Field2'] = $v['Название'];
      $properties['Field3'] = $v['Страна'];
      $properties['Field4'] = $v['Калории'];
      $properties['Field5'] = $v['Белки'];
      $properties['Field6'] = $v['Жиры'];
      $properties['Field7'] = $v['Углеводы'];
      $properties['Field8'] = $v['Состав'];
      $properties['Field10'] = $v['Цена за 1кг / шт'];
      $properties['Field11'] = 1;
      $properties['Field13'] = $v['Состав'];
      $properties = (object) $properties;
      $add->properties = $properties;
      array_push($data->features,$add);
    }

    
    
    $content = "";

    foreach ($data->features as $key => $item) {
      $v = $item->properties;

      if($v->Field1 == '(Click to sort Ascending)') continue;

      //Set name
      if('name' == 'name'){
        $name = 'Field2';
        $len = iconv_strlen($v->$name);
        if($len > 79){
          dump($v->$name);
          continue;
        } 
        for ($i=0; $i < (80 - $len); $i++) { 
          $v->$name .= ' ';
        }
      }

      //Set button
      if('button' == 'button'){
        $button = $key+1;
        $len = iconv_strlen($button);
        $pre_button = '';
        for ($i=0; $i < (15 - $len); $i++) { 
          $pre_button .= '0';
        }
        $button = $pre_button . $button;

        dump($button . ' - ' .$v->Field2);
      }

      //set price
      if('price' == 'price'){
        $price = 'Field10';
        $unit = 'Field11';

        $price_full = number_format((float)((1 / $v->$unit) * $v->$price), 2, '.', '');
        $len = iconv_strlen($price_full);
        $pre = '';
        for ($i=0; $i < (8 - $len); $i++) { 
          $pre .= '0';
        }
        $price_full = $pre . $price_full;
      }
              
      $pa1 = 'A220000100000';
      $pa2_button = $button;
      $pa3 = '0001000100';
      $pa4_price = $price_full;
      $pa5_days = '000';
      $pa6 = '0000';
      $pa7_name = $v->$name;
      $pa8 = "\r\n";

      $string = $pa1.$pa2_button.$pa3.$pa4_price.$pa5_days.$pa6.$pa7_name.$pa8;

      $content .= $string;

      //set country
      if('country' == 'country'){
        $country = 'Field3';
        if(isset($v->$country)) {

          $val = 'Страна: ' . $v->$country;
          $len = iconv_strlen($val);
          if($len > 48){
            dump('bad country', $v);
            continue;
          }

          $len = iconv_strlen($val);
          // for ($i=0; $i < (100 - $len); $i++) { 
          //   $val .= ' ';
          // }

          $ipa1 = 'I';
          $ipa2_button = $button;
          $ipa3_text = $val;
          $ipa4 = "";
          $add = $ipa1.$ipa2_button.$ipa3_text.$ipa4;

          
          $content .= $add;
        }
      }

      //Ccal
      if('ccal' == 'ccal'){

        $name = 'Field4';
        if(isset($v->$name)){
          $val = 'Калории: ' . $v->$name;
          $len = iconv_strlen($val);
          if($len > 48){
            dump('bad Калории', $val);
            continue;
          }

          $ipa1 = 'I';
          $ipa2_button = $button;
          $ipa3_text = $val;
          $ipa4 = "";
          $add = $ipa3_text.$ipa4;

          
          $content .= $add;
        }
      }   

        
      //Бжу
      if('Бжу' == 'Бжу'){
        $prots = 'Field5';
        $fats = 'Field6';
        $carbs = 'Field7';

        if(isset($v->$prots) && isset($v->$fats) && isset($v->$carbs)){

          $val = "БЖУ: {$v->$prots}/{$v->$fats}/{$v->$carbs}" ;
          $len = iconv_strlen($val);
          if($len > 48){
            dump('bad БЖУ', $v, $val);
            continue;
          }
                          
          $ipa1 = 'I';
          $ipa2_button = $button;
          $ipa3_text = $val;
          $ipa4 = "";
          $add = $ipa3_text.$ipa4;
          
          $content .= $add;
        }
      }   

      //srok
      if('srok' == 'srok'){
        $name = 'Field8';

        if(isset($v->$name)){

          $val = $v->$name;
          $len = iconv_strlen($val);
          $more_sostav = [];
          if($len > 48){
            $left = $val;
            do{                
              $str = mb_substr  ( $left , 0, 45 );
              $left = mb_substr  ( $left , 45 );                
              array_push($more_sostav,$str);                
              if($left == FALSE ) break;
            }while(1);
            
            if(count($more_sostav) > 5){
              dump('bad Состав', $val);
              continue;
            }
          }

          if(count($more_sostav) == 0){
            $more_sostav[1] = $val;
          }

          foreach ($more_sostav as $key => $val) {      
            $ipa3_text = $val;
            $ipa4 = "";
            $add = $ipa3_text.$ipa4;
            
            $content .= $add;
          }   
                    
        }
      }   
      $content .= "\r\n";
    }

    Storage::disk('local')->put('up100.txt', mb_convert_encoding($content, "cp866"));

    dd($content);
  });
}

use App\Cart;

Route::get('/test', function(){
  echo 'Здесь происходит, что-то очень важное 🎩';

  dd();

  {//Piece
  
    $products = new App\Product();
    $products = $products->with('metas');
  
    $products = $products

    ->where('unit', '=' ,1)
    ->whereHas('metas', function($q){
      $q->where('name','unit_view')
      ->where('value','NOT LIKE','%кг%');
    })    
    ->get();    

    // dd($products->toArray());
  
    foreach ($products as $key => $v) {
      if(DB::table('product_metas')->where('name','unit_type')->where('product_id',$v->id)->exists()) continue;
  
      DB::table('product_metas')->insert([
        'product_id' => $v->id,
        'name' => 'unit_type',
        'value' => 'piece',
      ]);
    }
  }

  {//Кг
    $products = new App\Product();
    $products = $products->with('metas');
  
    $products = $products->where('unit', '<>' ,1);
    $products = $products->whereHas('metas', function($q){
      $q->where('value','LIKE','%г%')
      ->orwhere('value','LIKE','%грамм%')
      ->orwhere('value','LIKE','%кг%');
    })
    ->whereHas('metas', function($q){
      $q->where('name','unit_view')
      ->where('value','NOT LIKE','%+/-%');
    })    
    ->get();

  
    foreach ($products as $key => $v) {
      if(DB::table('product_metas')->where('name','unit_type')->where('product_id',$v->id)->exists()) continue;
  
      DB::table('product_metas')->insert([
        'product_id' => $v->id,
        'name' => 'unit_type',
        'value' => 'kg',
      ]);
    }
  }



  // dd($pieces);

  //Get 
  // $cart = Cart::with('items')->with('containers')->where('id', 13828)->first();
  
  

  // dd(Cart::getCart());
 


  dd(10);
  
});

Route::get('/mail/preview/{id}', function($id){


  // $order = App\Order::getWithOptions(['id'=>$id]);

  // dump(  $order->toarray());

  $user = App\User::find(751);
  $email = App\Email::jugeGet(['id'=>$id]);

  $html = App\Email::customTags($email->html,$user);

  // dump($html);


  // Mail::send('mail.customEmail', ['user' => $user->toarray(),'html' => $html], function($m){
  //   // $m->to('aslanovadaria@yandex.ru','to');
  //   // $m->to('mapss@inbox.lv','to');
  //   $m->to('jurijsgergelaba@yandex.ru','to');
  //   $m->from('no-reply@bananich.ru');
  //   $m->subject('Дегустационный сет от Бананыча');
  // });

  // Mail::send('mail.customEmail', ['user' => $user->toarray(),'html' => $html], function($m){
  //   $m->to('aslanovadaria@yandex.ru','to');
  //   // $m->to('mapss@inbox.lv','to');
  //   // $m->to('jurijsgergelaba@yandex.ru','to');
  //   $m->from('no-reply@bananich.ru');
  //   $m->subject('Дегустационный сет от Бананыча');
  // });


  // return view('mail.test');
  return view('mail.customEmail', ['user' => $user->toarray(),'html' => $html]);
});


//Logistic
Route::get('/logistic/daily', function(){echo App\Logistic::daily();});

//bonus
Route::get('/bonus/die/sms', function(){echo App\Sms::bonusNotification();});


Route::domain('x.bananich.ru')->middleware(['HttpsRR','under-construction'])->group(function () {
  Route::get('/', function(){
    // return redirect('/');
    return redirect('/catalogue');
  });
});

Route::domain('neolavka.ru')->middleware(['HttpsRR','under-construction'])->group(function () {
  Route::get('/', function(){
    // return redirect('/');
    return redirect('/catalogue');
  });
});

Route::group(['middleware' => ['HttpsRR'
// ,'under-construction'
]], function () {
    
  Route::get('/home', function(){
    return redirect('/');
  });

  Route::get('/test/test', function(){
      //
  });


  //All
  Route::group(['middleware' => []], function (){

    {//Shared Order
      Route::post('/shared/order/test/time', 'SharedOrderController@testTime');
      Route::put('/shared/order/open', 'SharedOrderController@open');
      Route::post('/shared/order', 'SharedOrderController@post');
      Route::delete('/shared/order', 'SharedOrderController@delete');
      Route::post('/shared/order/join', 'SharedOrderController@join');
      Route::get('/shared/order/weights', 'SharedOrderController@getWeights');
      Route::get('/shared/order/auth', 'SharedOrderController@byAuth');
      Route::delete('/shared/order/kick', 'SharedOrderController@kick');
      Route::any('/shared/order/handle', 'SharedOrderController@handle');
      Route::any('/shared/order/update', 'SharedOrderController@update');
      Route::any('/shared/order/order', 'SharedOrderController@getOrder');
      
      {//Shared Order Pay
        // Route::get('/shared/order/pays', 'SharedOrderPayController@get');
        Route::put('/shared/order/pay', 'SharedOrderPayController@pay');
      }
    }

    //Order
    Route::put('/order/log', 'JugeLogsController@orderButton');
    Route::put('/order/log/success', 'JugeLogsController@orderSuccess');
    Route::put('/order/put', 'OrderController@put');
    Route::post('/order/customer', 'OrderController@customerPost');
    Route::any('/order/update/available', 'OrderController@updateAvailable');

    //Cart
    Route::get('/json/cart', 'CartController@get');
    Route::post('/cart/edit/item', 'CartController@editItem');
    Route::post('/cart/session', 'CartController@changeSession');
    Route::delete('/cart/remove/item', 'CartController@removeItem'); 
    Route::delete('/cart/reset', 'CartController@resetItems');
    Route::post('/cart/container', 'CartController@editContainer');
    Route::delete('/cart/container', 'CartController@removeContainer');
    Route::put('/cart/from/local', 'CartController@cartFromLocal');

    //Coupon
    Route::any('/coupon/cart', 'CouponController@cartAttach');

    //Session
    Route::get('/json/session', 'SessionController@get');

    //Categories
    Route::get('/json/categories', 'CategoryController@getAll');

    //Interview
    Route::get('/interview/{id}', function($id){
        return view('interview',['id' => $id]);
    });
    Route::put('/put/interviews', 'InterviewController@put');

    //SMS
    Route::get('/sms/to/send', 'SmsController@toSend');
    Route::get('/sms/send/confirm', 'SmsController@sendConfirm');
    Route::put('/sms/add/send', 'SmsController@sendAdd');
    Route::any('/sms/add/input', 'SmsController@smsAddInput');

    //Errors
    Route::put('/error', 'ErrorController@put');

    //Auth
    Auth::routes();

    //User
    Route::get('/auth/user', 'UserController@getAuthUser');
    Route::post('/user', 'UserController@post');
    Route::post('/user/address', 'UserController@postAddress');
    Route::post('/user/main/photo', 'UserController@editMainPhoto');

    //Product
    Route::get('/product/last/update', 'ProductController@lastUpdate'); 

    //Present
    Route::get('/present/settings', 'PresentController@getSettings'); 
    Route::get('/product/present', 'PresentController@getProduct'); 
    Route::put('/present/cart', 'PresentController@addPresentToCart'); 

    //Settings
    Route::get('/json/settings', 'SettingController@get'); 

    //Order Limits
    Route::get('/order/available/days', 'OrderController@getAvailableDays');

    //Not found
    Route::put('/not/found', 'NotFoundController@put'); 

  });

  //Gruzka
  Route::group(['middleware' => ['auth', 'can:gruzka_panel']], function (){

    //Gruzka
    Route::middleware([])->group(function (){
      Route::put('/gruzka/confirm', 'GruzkaController@confirm');
      Route::put('/gruzka/noitem', 'GruzkaController@noItem');
      Route::put('/gruzka/done', 'GruzkaController@done');
    });

    //Gruzka
    Route::middleware([])->group(function (){  
      Route::get('/json/orders', 'OrderController@jsonGet');
      //Order Status
      Route::get('/json/order/statuses', 'OrderStatusController@jsonGetStatuses');
      Route::put('/order/status', 'OrderStatusController@putStatus');  
    });

    Route::prefix('gruzka')->group(function (){

      //Vue
      Route::get('/{vue_capture?}', function () {
          return view('admin');
      })->where('vue_capture', '[\/\w\.-]*');    
    });

  });

  //Driver
  Route::group(['middleware' => ['auth', 'can:driver_panel']], function (){

    //User
    Route::get('/user/comments', 'UserController@comments');
    Route::put('/add/comment', 'UserController@addComment');
    Route::delete('/delete/comment', 'UserController@deleteComment');

    //Delivery    
    Route::get('/json/deliveries', 'DeliveryController@jsonGet');  
    Route::put('/put/delivery', 'DeliveryController@put');      
    Route::delete('/delivery', 'DeliveryController@delete');


    //Pay
    Route::get('/json/pay/methods', 'PayController@getMethods');
    //Return Item
    Route::put('/return/item', 'ReturnItemController@put');      
    Route::delete('/return/item', 'ReturnItemController@delete');        

    Route::prefix('driver')->group(function (){

      //Logistic    
      Route::get('/logistic/keys', 'LogisticController@getDriverLogisticKeys');

      //Vue
      Route::get('/{vue_capture?}', function () {
          return view('admin');
      })->where('vue_capture', '[\/\w\.-]*');    
    });
  });

  //Admin
  Route::group(['middleware' => ['auth', 'can:admin_panel']], function (){

    //Libaras
    Route::put('/admin/libra', 'LibraController@put');
    Route::post('/admin/libra/sort', 'LibraController@sortByName');
    Route::post('/admin/libra/update', 'LibraController@update');
    Route::get('/admin/libra/logs', 'LibraController@getLogs');
    Route::get('/admin/libra/last/product/update', 'LibraController@lastProductUpdate');
    Route::get('/admin/libra/last/update', 'LibraController@lastLibraUpdate');
    Route::get('/admin/libra/vesi/odin', function(){return Storage::download('/vesi/odin.txt');});

    //Logs
    Route::get('/admin/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    
    //Email
    Route::put('/admin/email', 'EmailController@put');
    Route::post('/admin/email', 'EmailController@post');
    Route::put('/admin/test/mail', 'EmailController@testMail');

    //TEST
    Route::get('/admin/test', function(){
      echo 'Здесь происходит, что-то очень важное 🎩🎩';
    });

    //Confirm
    Route::get('/to/confirm/orders', 'OrderController@getToConfirmOrders');

    //Logistic
    Route::middleware([])->group(function (){
      Route::post('/logistic/change/driver', 'LogisticController@changeDriver');
    });   

    //Bonus
    Route::middleware([])->group(function (){
      Route::put('/bonus/add', 'BonusController@add');
    });

    //User
    Route::middleware([])->group(function (){
      Route::get('/login/as/user', 'UserController@loginAsUser');  
      Route::post('/user/to/driver', 'UserController@toDriver');  
      Route::post('/user/to/collector', 'UserController@toСollector');  
      Route::get('/json/drivers', 'UserController@getDrivers'); 
    }); 

    //Items
    Route::middleware([])->group(function (){
      Route::get('/json/items', 'ItemController@jsonGet');    //  
      Route::get('/json/item/statuses', 'ItemStatusController@jsonGetStatuses');
      Route::delete('/item', 'ItemController@delete');
      Route::post('/item', 'ItemController@post');
    });
    
    //Menus\Pages
    Route::middleware([])->group(function (){
      Route::put('/page', 'PageController@put');
      Route::post('/page', 'PageController@post');
      Route::post('/page/menu/attach', 'PageController@attach');
      Route::post('/page/menu/detach', 'PageController@detach');
      Route::post('/page/site/attach', 'PageController@attachSite');
      Route::post('/page/site/detach', 'PageController@detachSite');
      Route::put('/menu', 'MenuController@put');
    });

    //Coupons
    Route::middleware([])->group(function (){
      Route::post('/coupon', 'CouponController@post');
      Route::put('/coupon', 'CouponController@put');
      // Route::get('/order/limit/settings', 'OrderController@getLimitSettings');
    });

    //Order Limits
    Route::middleware([])->group(function (){
      Route::get('/orders/calendar', 'OrderController@getCalendarOrders');
      Route::get('/order/limit/settings', 'OrderController@getLimitSettings');
    });

    //Category
    Route::middleware([])->group(function (){
      Route::put('/category', 'CategoryController@put');
      Route::post('/category', 'CategoryController@post');
      Route::post('/categoty/main/photo', 'CategoryController@editMainPhoto');
      Route::post('/category/product/detach', 'CategoryController@detachProduct');
      Route::post('/category/product/attach', 'CategoryController@attachProduct');
      Route::post('/category/category/detach', 'CategoryController@detachCategory');
      Route::post('/category/category/attach', 'CategoryController@attachCategory');
    });
    
    //Settings
    Route::middleware([])->group(function (){
      Route::post('/settings', 'SettingController@post');  
      Route::delete('/settings', 'SettingController@delete');  
    });

    //Present
    Route::middleware([])->group(function (){
      Route::put('/admin/product/present', 'PresentController@putProduct'); 
      Route::delete('/admin/product/present', 'PresentController@deleteProduct'); 
    });

    //File upload
    Route::middleware([])->group(function (){
      Route::post('/file/upload', 'FileUploadController@fileUpload');
      Route::delete('/file/delete', 'FileUploadController@fileDelete');
    });

    //Order
    Route::middleware([])->group(function (){
      //Order
      Route::post('/order', 'OrderController@post');
      Route::put('/order/item', 'OrderController@addItem');

    });

    //Product
    Route::middleware([])->group(function (){
      Route::put('/product', 'ProductController@put');
      Route::post('/product', 'ProductController@post');
      Route::get('/json/products', 'ProductController@get');
      Route::get('/base64/preloaded/images', 'ProductController@getBase64PreloadedImages');

      //Product Published
      Route::post('/product/publish', 'ProductController@publish');

      //Delivery days
      Route::post('/product/delivery/limits', 'ProductController@editDeliveryLimits');

      //Main photo
      Route::post('/product/main/photo', 'ProductController@editMainPhoto');
      
      //Config List
      Route::get('/config', 'ListConfigController@get');
      Route::post('/config/post', 'ListConfigController@post');

      //Product discount
      Route::post('/product/discount/set', 'ProductController@postPrice');
      // Route::post('/product/discount/set', 'ProductController@setDiscount');
      Route::delete('/product/discount/remove', 'ProductController@removeDiscount');

      //Discount
      Route::delete('/discount/remove', 'DiscountController@remove');
      Route::put('/discount/add', 'DiscountController@add');
    });

    //Report
    Route::middleware([])->group(function (){

      //Report
      Route::get('/json/report', 'ReportController@jsonGet');

      //Stocktaking
      Route::get('/json/stocktaking/products', 'StocktakingController@jsonGetProducts');
      Route::put('/stocktaking', 'StocktakingController@put');

      //Writeoff        
      Route::put('/put/writeoff', 'WriteoffController@put');    

      //Purchases        
      Route::put('/put/purchase', 'PurchaseController@put');      
      //Purchase prices       
      Route::get('/json/purchase/prices', 'PurchaseController@getPrices');
      Route::put('/put/purchase/prices', 'PurchaseController@putPrice');

      //Goods
      Route::get('/json/goods', 'GoodsController@jsonGet');
      Route::put('/put/goods', 'GoodsController@put');
      Route::post('/post/goods', 'GoodsController@post');
      Route::delete('/delete/goods', 'GoodsController@delete');

    });

    //Supplier
    Route::middleware([])->group(function (){
      Route::get('/json/suppliers', 'SupplierController@jsonGet');
      Route::get('/json/suppliers/distinct', 'SupplierController@jsonDistinct');
      Route::put('/put/supplier', 'SupplierController@put');
      Route::post('/post/supplier', 'SupplierController@post');
      Route::delete('/delete/supplier', 'SupplierController@delete');
      Route::put('/attach/supplier/product', 'SupplierController@addProduct');
      Route::delete('/remove/supplier/product', 'SupplierController@removeProduct');
      Route::post('/edit/supplier/product/id', 'SupplierController@editId');
    });

    //Juge CRUD
    Route::middleware([])->group(function (){
      Route::get('/juge', 'JugeCRUDController@get');
      Route::get('/juge/keys', 'JugeCRUDController@getKeys');
      Route::get('/juge/inputs', 'JugeCRUDController@getInputs');    
      Route::get('/juge/post/inputs', 'JugeCRUDController@getPostInputs');    
      Route::post('/juge', 'JugeCRUDController@post');    
      Route::delete('/juge', 'JugeCRUDController@delete');    
    });

    //Admin panel
    Route::prefix('admin')->group(function (){
      //Vue
      Route::get('/{vue_capture?}', function () {
          return view('admin');
      })->where('vue_capture', '[\/\w\.-]*');    
    });

  });

  //Site
  Route::group(['middleware' => []], function (){


    //Favorites
    Route::put('/favorite', 'FavoriteController@put');
    Route::delete('/favorite', 'FavoriteController@remove');

    //Pages
    Route::middleware([])->group(function (){
      //Profile
      Route::middleware(['auth'])->get('/profile', function () {
        return view('main');
      })->where('vue_capture', '[\/\w\.-]*');
    });

    //Vue Pages
    Route::get('/{vue_capture?}', function () {
        return view('main');
    })->where('vue_capture', '[\/\w\.-]*');

    //Juge READ
    Route::middleware([])->group(function (){
      Route::get('/juge', 'JugeCRUDController@get');
      Route::get('/juge/keys', 'JugeCRUDController@getKeys');
      Route::get('/juge/inputs', 'JugeCRUDController@getInputs');    
    });

  });


      

  Route::get('/404', function(){
      abort(404);
  });


  //Old admin
  do{
    //Admin
    // Route::middleware(['can:admin panel'])->prefix('admin')->group(function (){

    //     //Settings
    //     Route::post('/settings', 'SettingController@post');  

 




    //     //Statistics
    //     Route::get('/json/statistics', 'StatisticController@jsonGet');



    //     //Permissions
    //     // Route::get('/', 'PermissionController@redirect');

    //     //User
    //     Route::put('/user', 'UserController@put');
    //     Route::get('/json/users', 'UserController@jsonGet');
    //     Route::post('/user/comment', 'UserController@post');

    //     //Auto gruzka
    //     Route::get('/gruzka/auto/order', 'OrderController@autoOrder');

    //     //Item quantity update
    //     Route::post('/item/quantity', 'ItemController@quantityUpdate');
    //     Route::put('/item/status', 'ItemStatusController@putStatus');

    //     //Parse
    //     Route::get('/parse/orders', 'ParseController@getOrders');
    //     Route::get('/parse/product/by/name', 'ParseController@parseProductByName');

    //     //Order
    //     Route::get('/json/orders', 'OrderController@jsonGet');
    //     Route::post('/order', 'OrderController@post');
    //     Route::put('/order/item', 'OrderController@addItem');

    //     //Order Status
    //     Route::get('/json/order/statuses', 'OrderStatusController@jsonGetStatuses');
    //     Route::put('/order/status', 'OrderStatusController@putStatus');



    //     //Container
    //     Route::put('/container', 'ContainerController@put');
    //     Route::delete('/container', 'ContainerController@delete');
    //     Route::get('/json/containers', 'ContainerController@jsonGet');
    //     Route::put('/container/attach', 'ContainerController@attach');
        
    //     //File upload
    //     Route::post('/file/upload', 'FileUploadController@fileUpload');
    //     Route::delete('/file/delete', 'FileUploadController@fileDelete');

    //     // Route::get('/home', function(){
    //     //     return view('main');
    //     // })->name('home');

    //     //Juge CRUD
    //     Route::get('/juge', 'JugeCRUDController@get');
    //     Route::get('/juge/keys', 'JugeCRUDController@getKeys');
    //     Route::get('/juge/inputs', 'JugeCRUDController@getInputs');

    //     Route::get('/{vue_capture?}', function () {
    //         return view('admin');
    //     })->where('vue_capture', '[\/\w\.-]*');

    // });

  }while(0);

  Auth::routes();



});
// });





// Route::get('/admin/test/sfdsfdsf', function(){
//   echo 'Здесь происходит, что-то очень важное 🎩🎩';
  
//   $users = DB::table('bonuses')->select('user_id')->groupBy('user_id')->pluck('user_id');
  
  

//   foreach ($users as $key => $userId) {
//     dump('user - '. $userId);
//     $userBonuses = App\Bonus::where('user_id',$userId)->with('addBonus')->orderBy('id')->get();
//     //Search removes
//     foreach ($userBonuses as $key => $bonus) {
//       if(!$bonus->addBonus){
//         $quantity = $bonus->quantity;

//         dump('PLUS == id: '. $bonus->id . ' q: ' . $bonus->quantity);
//         //Bonus adds
//         foreach ($userBonuses as $key => $bonus) {
//           if($bonus->addBonus && $bonus->addBonus->left > 0){
//             dump('MINUS == id: '. $bonus->id . ' q: ' . $quantity);
//             $bonus->addBonus->left -= $quantity;
//             $quantity = $bonus->addBonus->left - ($bonus->addBonus->left*2);
//             if($bonus->addBonus->left < 0) $bonus->addBonus->left = 0;     
            
//             dump('LEFT '.$bonus->addBonus->left);
//           }
//           if($quantity < 1) break;
          
//         }
//       }        
//     }

//     foreach ($userBonuses as $key => $bonus) {
//       if($bonus->addBonus){
//         $bonus->addBonus->save();

//       }
//     }

//     dump('----');
//   }


//   dd(11);
// });


