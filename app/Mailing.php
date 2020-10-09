<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Mail;
use App\User;

class Mailing extends Model
{
    public static function open(){
      // $users = User::get();
      $users = array(
        array(
          "id" => 658,
          "email" => "elenasmirno@yandex.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 682,
          "email" => "ninmeo@gmail.com",
          "name" => "Нина",
        ),
        array(
          "id" => 685,
          "email" => "marie.suvorina@gmail.com",
          "name" => "Мария",
        ),
        array(
          "id" => 686,
          "email" => "roman.ova@mail.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 697,
          "email" => "tatuscha0808@mail.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 701,
          "email" => "nadin771@yandex.ru",
          "name" => "NADEZDA",
        ),
        array(
          "id" => 713,
          "email" => "gky@list.ru",
          "name" => "Кристина",
        ),
        array(
          "id" => 723,
          "email" => "a.endakova@gmail.com",
          "name" => "Анастасия",
        ),
        array(
          "id" => 731,
          "email" => "cafespb.ru@mail.ru",
          "name" => "Alina",
        ),
        array(
          "id" => 775,
          "email" => "only@list.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 795,
          "email" => "olya_vl81@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 798,
          "email" => "smirnova.elena.alex@gmail.com",
          "name" => "Елена",
        ),
        array(
          "id" => 800,
          "email" => "elenamatulis@yandex.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 807,
          "email" => "ivanova_marina_@inbox.ru",
          "name" => "Марина",
        ),
        array(
          "id" => 811,
          "email" => "evgenya-nik@mail.ru",
          "name" => "Евгения",
        ),
        array(
          "id" => 818,
          "email" => "got.julia@gmail.com",
          "name" => "Юлия",
        ),
        array(
          "id" => 820,
          "email" => "juliaeagle@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 821,
          "email" => "Lazalisa@inbox.ru",
          "name" => "Irina",
        ),
        array(
          "id" => 825,
          "email" => "innostra@yandex.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 833,
          "email" => "olgachmk@gmail.com",
          "name" => "Ольга",
        ),
        array(
          "id" => 837,
          "email" => "smurf.mdp@gmail.com",
          "name" => "Мария",
        ),
        array(
          "id" => 842,
          "email" => "oksana_hi_hi@mail.ru",
          "name" => "Оксана",
        ),
        array(
          "id" => 843,
          "email" => "vailayrin@gmail.com",
          "name" => "Валерия",
        ),
        array(
          "id" => 844,
          "email" => "fainakras@yandex.ru",
          "name" => "Фаина",
        ),
        array(
          "id" => 847,
          "email" => "leeana1@yandex.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 856,
          "email" => "j.p.star@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 907,
          "email" => "lidoirina@mail.ru",
          "name" => "Ирина",
        ),
        array(
          "id" => 924,
          "email" => "dira76@mail.ru",
          "name" => "Ирина",
        ),
        array(
          "id" => 934,
          "email" => "khubezhevam@gmail.com",
          "name" => "Милана",
        ),
        array(
          "id" => 946,
          "email" => "ula1302@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 949,
          "email" => "avrora.ru84@mail.ru",
          "name" => "Зульфия",
        ),
        array(
          "id" => 1033,
          "email" => "83almira@mail.ru",
          "name" => "Альмира",
        ),
        array(
          "id" => 1057,
          "email" => "a.finogenova80@mail.ru",
          "name" => "Алена",
        ),
        array(
          "id" => 1069,
          "email" => "iz-nata@yandex.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 1076,
          "email" => "ek.proshina08@gmail.com",
          "name" => "Катерина",
        ),
        array(
          "id" => 1098,
          "email" => "heginu99@gmail.com",
          "name" => "Наталья",
        ),
        array(
          "id" => 1101,
          "email" => "anygolfik@yahoo.com",
          "name" => "Анна",
        ),
        array(
          "id" => 1113,
          "email" => "asd-2000@mail.ru",
          "name" => "Наталия",
        ),
        array(
          "id" => 1142,
          "email" => "borisenkovalera@mail.ru",
          "name" => "Валерия",
        ),
        array(
          "id" => 1152,
          "email" => "fedorova09@inbox.ru",
          "name" => "Валентина",
        ),
        array(
          "id" => 1164,
          "email" => "annabaraban229@gmail.com",
          "name" => "Анна",
        ),
        array(
          "id" => 1205,
          "email" => "masshha@list.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 1212,
          "email" => "m-anastasiya_@mail.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 1259,
          "email" => "freeverna@yandex.ru",
          "name" => "Надежда",
        ),
        array(
          "id" => 1265,
          "email" => "miledineba@yandex.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 1278,
          "email" => "xabigailx@narod.ru",
          "name" => "Радмила",
        ),
        array(
          "id" => 1311,
          "email" => "dina_on-line@mail.ru",
          "name" => "Дина",
        ),
        array(
          "id" => 1322,
          "email" => "kodinatanja@yandex.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 1328,
          "email" => "savushkina2802@gmail.com",
          "name" => "Анастасию",
        ),
        array(
          "id" => 1339,
          "email" => "wasenko@yandex.ru",
          "name" => "Вероника",
        ),
        array(
          "id" => 1355,
          "email" => "anyhim77@gmail.com",
          "name" => "Анна",
        ),
        array(
          "id" => 1362,
          "email" => "feistdasha@mail.ru",
          "name" => "Дарья",
        ),
        array(
          "id" => 1413,
          "email" => "katuwa13@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 1434,
          "email" => "cherkasic@mail.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 1435,
          "email" => "a9093825312@yandex.ru",
          "name" => "Арина",
        ),
        array(
          "id" => 1452,
          "email" => "saturi@narod.ru",
          "name" => "Надежда",
        ),
        array(
          "id" => 1460,
          "email" => "a.suppes23@gmail.com",
          "name" => "Анна",
        ),
        array(
          "id" => 1471,
          "email" => "k.81@inbox.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 1477,
          "email" => "alenakotovich94@mail.ru",
          "name" => "Алёна",
        ),
        array(
          "id" => 1511,
          "email" => "maria.shev.2009@yandex.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 1523,
          "email" => "6656920@gmail.com",
          "name" => "Ольга",
        ),
        array(
          "id" => 1525,
          "email" => "ania1993@list.ru",
          "name" => "Анна",
        ),
        array(
          "id" => 1531,
          "email" => "eekoroleva@gmail.com",
          "name" => "Елена",
        ),
        array(
          "id" => 1534,
          "email" => "katushenka2004@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 1581,
          "email" => "yafa80@mail.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 1607,
          "email" => "smyaki@yandex.ru",
          "name" => "Светлана",
        ),
        array(
          "id" => 1618,
          "email" => "nasfarick@mail.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 1627,
          "email" => "uyaroslavaaa@mail.ru",
          "name" => "Ярослава",
        ),
        array(
          "id" => 1635,
          "email" => "shnova@mail.ru",
          "name" => "Полина",
        ),
        array(
          "id" => 1643,
          "email" => "kandla@bk.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 1674,
          "email" => "suvorova1705@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 1680,
          "email" => "al_25@inbox.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 1704,
          "email" => "oksyaka@mail.ru",
          "name" => "Оксана",
        ),
        array(
          "id" => 1711,
          "email" => "sunlightlion812@gmail.com",
          "name" => "Надежда",
        ),
        array(
          "id" => 1716,
          "email" => "ekaterina-dancer@ya.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 1722,
          "email" => "ilyanad@mail.ru",
          "name" => "Иляна",
        ),
        array(
          "id" => 1746,
          "email" => "olga221188@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 1771,
          "email" => "DaryaSPbee@yandex.ru",
          "name" => "Дарья",
        ),
        array(
          "id" => 1781,
          "email" => "oliababes@yahoo.com",
          "name" => "Ольга",
        ),
        array(
          "id" => 1787,
          "email" => "mrbesthat@gmail.com",
          "name" => "Анастасия",
        ),
        array(
          "id" => 1794,
          "email" => "tamara.90@mail.ru",
          "name" => "Тамара",
        ),
        array(
          "id" => 1796,
          "email" => "helenvorobeva@mail.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 1806,
          "email" => "mletunovskaya@gmail.com",
          "name" => "Марина",
        ),
        array(
          "id" => 1807,
          "email" => "nataly-pr@mail.ru",
          "name" => "Наталия",
        ),
        array(
          "id" => 1826,
          "email" => "daoli@list.ru",
          "name" => " Рада",
        ),
        array(
          "id" => 1873,
          "email" => "tulenkova85@mail.ru",
          "name" => "Евгения",
        ),
        array(
          "id" => 1874,
          "email" => "dobrinya1708@gmail.com",
          "name" => "Сергей",
        ),
        array(
          "id" => 1883,
          "email" => "arimana@list.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 1893,
          "email" => "shmeleva-u@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 1935,
          "email" => "katrinka_2007_90@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 1944,
          "email" => "o.vesova@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 1945,
          "email" => "250613@mail.ru",
          "name" => "Aleksandra",
        ),
        array(
          "id" => 1955,
          "email" => "littlepig@mail.ru",
          "name" => "Дарья",
        ),
        array(
          "id" => 1965,
          "email" => "mariolopezz@mail.ru",
          "name" => "Вадим",
        ),
        array(
          "id" => 1976,
          "email" => "petrova.innaa@gmail.com",
          "name" => "Инна",
        ),
        array(
          "id" => 1977,
          "email" => "upryamay@mail.ru",
          "name" => "Вероника",
        ),
        array(
          "id" => 1988,
          "email" => "SvetlanaS2003@mail.ru",
          "name" => "Светлана",
        ),
        array(
          "id" => 2022,
          "email" => "ky4evay84@gmail.com",
          "name" => "Юлия",
        ),
        array(
          "id" => 2029,
          "email" => "romiach@mail.ru",
          "name" => "Роман",
        ),
        array(
          "id" => 2053,
          "email" => "aniutka5645@mail.ru",
          "name" => "Никита",
        ),
        array(
          "id" => 2066,
          "email" => "belikova8218@icloud.com",
          "name" => "Евгения",
        ),
        array(
          "id" => 2069,
          "email" => "mertvaya-balerina@yandex.ru",
          "name" => "Марина",
        ),
        array(
          "id" => 2086,
          "email" => "vik-petrinich@mail.ru",
          "name" => "Виктория",
        ),
        array(
          "id" => 2095,
          "email" => "mariasobo@mail.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 2107,
          "email" => "tanushkinapochta@mail.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2128,
          "email" => "iolin@mail.ru",
          "name" => "Долгушина Мария",
        ),
        array(
          "id" => 2130,
          "email" => "ezhevi4ka22@ya.ru",
          "name" => "Виктория",
        ),
        array(
          "id" => 2154,
          "email" => "euou@mail.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2156,
          "email" => "surkina78@mail.ru",
          "name" => "Светлана",
        ),
        array(
          "id" => 2162,
          "email" => "yarullinatv@mail.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2172,
          "email" => "airanna-novia@mail.ru",
          "name" => "Анна",
        ),
        array(
          "id" => 2175,
          "email" => "k-uria@mail.ru",
          "name" => "Kittylove2",
        ),
        array(
          "id" => 2185,
          "email" => "malishevavp@mail.ru",
          "name" => "Виктория",
        ),
        array(
          "id" => 2192,
          "email" => "valerievna-spb@yandex.ru",
          "name" => "Марина",
        ),
        array(
          "id" => 2196,
          "email" => "liz-lu@yandex.ru",
          "name" => "Елизавета",
        ),
        array(
          "id" => 2200,
          "email" => "zhegzdrina@yandex.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2201,
          "email" => "SvetaLampNak@gmail.com",
          "name" => "Светлана",
        ),
        array(
          "id" => 2203,
          "email" => "marienes@yandex.ru",
          "name" => "Марика",
        ),
        array(
          "id" => 2215,
          "email" => "ohappy2710@gmail.com",
          "name" => "Olga",
        ),
        array(
          "id" => 2217,
          "email" => "tanya.lukasheva@gmail.com",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2218,
          "email" => "aivazovaekaterina02@gmail.com",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2222,
          "email" => "bilan.61@mail.ru",
          "name" => "Ирина",
        ),
        array(
          "id" => 2223,
          "email" => "ksenia_mushenko@mail.ru",
          "name" => "Ксения",
        ),
        array(
          "id" => 2229,
          "email" => "mazik.svetlana@gmail.com",
          "name" => "Светлана",
        ),
        array(
          "id" => 2238,
          "email" => "balashova_mv@mail.ru",
          "name" => "Мари",
        ),
        array(
          "id" => 2241,
          "email" => "rushana1983@mail.ru",
          "name" => "Рушана",
        ),
        array(
          "id" => 2246,
          "email" => "dev83@mail.ru",
          "name" => "Ксения",
        ),
        array(
          "id" => 2247,
          "email" => "tatyana4391@yandex.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2248,
          "email" => "saint.kate@yandex.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2256,
          "email" => "t.u.s.i.a@list.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2257,
          "email" => "leravydolob@yahoo.com",
          "name" => "Валерия Суротдинова",
        ),
        array(
          "id" => 2258,
          "email" => "vavulina@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2260,
          "email" => "luiziana2121@gmail.com",
          "name" => "Луиза",
        ),
        array(
          "id" => 2262,
          "email" => "ksenia.dspb@yandex.ru",
          "name" => "Ксения",
        ),
        array(
          "id" => 2263,
          "email" => "Kati_valkova@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2267,
          "email" => "lveimer@mail.ru",
          "name" => "Людмила",
        ),
        array(
          "id" => 2273,
          "email" => "n.kozlova@morsudsnab.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2274,
          "email" => "perlis@bk.ru",
          "name" => "Александра",
        ),
        array(
          "id" => 2275,
          "email" => "Danil4enko.anya2017@yandex.ru",
          "name" => "Анна",
        ),
        array(
          "id" => 2277,
          "email" => "zamakhina.t@gmail.com",
          "name" => "Таня",
        ),
        array(
          "id" => 2278,
          "email" => "butal2009@yandex.ru",
          "name" => "Альбина",
        ),
        array(
          "id" => 2283,
          "email" => "Shvepsik@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2284,
          "email" => "ekimova_natali@list.ru",
          "name" => "Natali",
        ),
        array(
          "id" => 2291,
          "email" => "lena.ch.85@bk.ru",
          "name" => "Elena",
        ),
        array(
          "id" => 2292,
          "email" => "sokolova_tatiana_borisovna@mail.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2294,
          "email" => "shmaria@mail.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 2295,
          "email" => "aqaelf@mail.ru",
          "name" => "Эльвира",
        ),
        array(
          "id" => 2298,
          "email" => "chezareka@gmail.com",
          "name" => "Дарья",
        ),
        array(
          "id" => 2301,
          "email" => "zotka999@gmail.com",
          "name" => "Ольга",
        ),
        array(
          "id" => 2303,
          "email" => "Dinaro4kus@gmail.com",
          "name" => "Дина",
        ),
        array(
          "id" => 2304,
          "email" => "leusroom@gmail.com",
          "name" => "Lesya",
        ),
        array(
          "id" => 2305,
          "email" => "marybo91@yandex.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 2306,
          "email" => "arhipova_violett@mail.ru",
          "name" => "Виолетта",
        ),
        array(
          "id" => 2315,
          "email" => "katynka@mail.ru",
          "name" => "Катерина",
        ),
        array(
          "id" => 2316,
          "email" => "loves-0889@mail.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2317,
          "email" => "nataly113@rambler.ru",
          "name" => "Natalia",
        ),
        array(
          "id" => 2320,
          "email" => "vashupapu@mail.ru",
          "name" => "Таисия",
        ),
        array(
          "id" => 2326,
          "email" => "Jlianaaf@gmail.com",
          "name" => "Юлиана",
        ),
        array(
          "id" => 2327,
          "email" => "shashovaira@gmail.com",
          "name" => "Ирина",
        ),
        array(
          "id" => 2329,
          "email" => "galina.13@mail.ru",
          "name" => "Галина",
        ),
        array(
          "id" => 2330,
          "email" => "alina_bankirdom@mail.ru",
          "name" => "Алина",
        ),
        array(
          "id" => 2331,
          "email" => "bazenova.av@gmail.com",
          "name" => "Алена",
        ),
        array(
          "id" => 2333,
          "email" => "nataly.09-09@mail.ru",
          "name" => "Наталия",
        ),
        array(
          "id" => 2336,
          "email" => "katerina_kfk@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2339,
          "email" => "mariykapixel@gmail.com",
          "name" => "Мария",
        ),
        array(
          "id" => 2340,
          "email" => "zemlyanichenko@mail.ru",
          "name" => "Светлана",
        ),
        array(
          "id" => 2341,
          "email" => "i_snegova@mail.ru",
          "name" => "Ирина",
        ),
        array(
          "id" => 2342,
          "email" => "222m33@mail.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 2344,
          "email" => "lorsikmorsik@gmail.com",
          "name" => "Лариса",
        ),
        array(
          "id" => 2346,
          "email" => "morkovka.ksu@mail.ru",
          "name" => "Ксения",
        ),
        array(
          "id" => 2349,
          "email" => "nautilus1949@icloud.com",
          "name" => "Ирина",
        ),
        array(
          "id" => 2350,
          "email" => "Annetlady@mail.ru",
          "name" => "Anna",
        ),
        array(
          "id" => 2351,
          "email" => "isolda_de_lik@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2352,
          "email" => "33305@mail.ru",
          "name" => "Natali",
        ),
        array(
          "id" => 2355,
          "email" => "diabik@yandex.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2359,
          "email" => "marina@prtrendrussia.com",
          "name" => "Marina",
        ),
        array(
          "id" => 2365,
          "email" => "maria.cherevan@gmail.com",
          "name" => "Мария",
        ),
        array(
          "id" => 2369,
          "email" => "AliceMalashonok@gmail.com",
          "name" => "Аня",
        ),
        array(
          "id" => 2371,
          "email" => "krestinskaya.maria@gmail.com",
          "name" => "Мария",
        ),
        array(
          "id" => 2373,
          "email" => "nlz@inbox.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2374,
          "email" => "poliinas6@mail.ru",
          "name" => "Полина",
        ),
        array(
          "id" => 2376,
          "email" => "nata-piter82@mail.ru",
          "name" => "Наталия",
        ),
        array(
          "id" => 2378,
          "email" => "ekogacheva@mail.ru",
          "name" => "Евгения",
        ),
        array(
          "id" => 2379,
          "email" => "oelesina@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2383,
          "email" => "olyashka8@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2384,
          "email" => "polay111@mail.ru",
          "name" => "Polina",
        ),
        array(
          "id" => 2387,
          "email" => "velliss@mail.ru",
          "name" => "Евдокия",
        ),
        array(
          "id" => 2388,
          "email" => "li.azatyan@mail.ru",
          "name" => "Liana",
        ),
        array(
          "id" => 2391,
          "email" => "dmitry.aliorder@gmail.com",
          "name" => "Дмитрий",
        ),
        array(
          "id" => 2396,
          "email" => "vivien.ngoc@icloud.com",
          "name" => "Вивьен",
        ),
        array(
          "id" => 2398,
          "email" => "toninapo4ta@mail.ru",
          "name" => "Антонина",
        ),
        array(
          "id" => 2399,
          "email" => "rovena13@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2401,
          "email" => "zvigunenok2@mail.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 2403,
          "email" => "katherine.job@yandex.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2404,
          "email" => "pfmedia@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2406,
          "email" => "mashytka_nik@mail.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 2407,
          "email" => "nastena4ka1@mail.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 2408,
          "email" => "nas-nas-ananas@yandex.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 2410,
          "email" => "anuta110297@gmail.com",
          "name" => "Анна",
        ),
        array(
          "id" => 2415,
          "email" => "anna.gusakova1@gmail.com",
          "name" => "Анна",
        ),
      );
      
      
      

      foreach ($users as $key => $user) {  
        $email = $user['email'];
        Mail::send('mail.rasilka', ['user' => $user], function($m)use($email){
          $m->to($email,'to');
          $m->from('no-reply@bananich.ru');
          $m->subject('Акция недели от Бананыча!)');
        });
        dump(count($users) - $key . ' - ' . $user['name'] . ' - ' . $user['email']);
        
      }

    }
}
