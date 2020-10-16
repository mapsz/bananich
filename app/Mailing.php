<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Mail;
use App\User;

class Mailing extends Model
{
    public static function open(){
      // $users = User::get();
      $users = $users = array(
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
          "id" => 922,
          "email" => "Nadya-moon@mail.ru",
          "name" => "Надя",
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
          "id" => 1004,
          "email" => "Glazenkova@gmail.com",
          "name" => "Наталья",
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
        array(
          "id" => 2420,
          "email" => "botinans@mail.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2421,
          "email" => "alena290680@yandex.ru",
          "name" => "Алексей",
        ),
        array(
          "id" => 2425,
          "email" => "e-loseva@mail.eu",
          "name" => "Елена",
        ),
        array(
          "id" => 2426,
          "email" => "alevtina.iakimenko@gmail.com",
          "name" => "Алевтина",
        ),
        array(
          "id" => 2430,
          "email" => "sveta0906@bk.ru",
          "name" => "Sveta",
        ),
        array(
          "id" => 2432,
          "email" => "8128877@gmail.com",
          "name" => "Ольга",
        ),
        array(
          "id" => 2433,
          "email" => "olga_hml@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2434,
          "email" => "euhenia78@mail.ru",
          "name" => "Чупанова Евгения",
        ),
        array(
          "id" => 2435,
          "email" => "ivishnevsky@icloud.com",
          "name" => "И",
        ),
        array(
          "id" => 2440,
          "email" => "olga.butymova@gmail.com",
          "name" => "Olga",
        ),
        array(
          "id" => 2443,
          "email" => "jmikhailova@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 2448,
          "email" => "marihabsileva@gmail.com",
          "name" => "Марина",
        ),
        array(
          "id" => 2449,
          "email" => "ban3@yandex.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 2451,
          "email" => "gnomic_da@mail.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 2454,
          "email" => "lexyfox1990@gmail.com",
          "name" => "Александра",
        ),
        array(
          "id" => 2455,
          "email" => "m_u_koroleva@mail.ru",
          "name" => "Марина",
        ),
        array(
          "id" => 2458,
          "email" => "tochki.nadi@yandex.ru",
          "name" => "Надежда",
        ),
        array(
          "id" => 2464,
          "email" => "vlg-spb-12@yandex.ru",
          "name" => "Marina",
        ),
        array(
          "id" => 2469,
          "email" => "Marie-sitnik@yandex.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 2470,
          "email" => "biletgorod@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2471,
          "email" => "fortepianoist@mail.ru",
          "name" => "Станислав",
        ),
        array(
          "id" => 2480,
          "email" => "ozimova@yahoo.com",
          "name" => "Maria",
        ),
        array(
          "id" => 2482,
          "email" => "katerin010192@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2484,
          "email" => "n.rusu@bk.ru",
          "name" => "Надежда",
        ),
        array(
          "id" => 2487,
          "email" => "Mers_ksu@mail.ru",
          "name" => "Kseniya",
        ),
        array(
          "id" => 2490,
          "email" => "medsister@bk.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2493,
          "email" => "zhendubaeva.ira@mail.ru",
          "name" => "Ирина",
        ),
        array(
          "id" => 2495,
          "email" => "a.e.osepyan@gmail.com",
          "name" => "Александр",
        ),
        array(
          "id" => 2496,
          "email" => "fas15kot@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2501,
          "email" => "evgenia.malinovskaya@gmail.com",
          "name" => "evgenia",
        ),
        array(
          "id" => 2502,
          "email" => "zeka0007@mail.ru",
          "name" => "Евгений",
        ),
        array(
          "id" => 2505,
          "email" => "gudkovajob@gmail.com",
          "name" => " Мария",
        ),
        array(
          "id" => 2507,
          "email" => "nevskay83@mail.ru",
          "name" => "Жанна",
        ),
        array(
          "id" => 2508,
          "email" => "fred_perry08@mail.ru",
          "name" => "Сергей",
        ),
        array(
          "id" => 2509,
          "email" => "grachiovgra@yandex.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2513,
          "email" => "aniasha@mail.ru",
          "name" => "Анна",
        ),
        array(
          "id" => 2514,
          "email" => "chernyshov.r@gmail.com",
          "name" => "Роман",
        ),
        array(
          "id" => 2515,
          "email" => "dulova_i@mail.ru",
          "name" => "Ирина",
        ),
        array(
          "id" => 2516,
          "email" => "n.plaksickaya@yandex.ru",
          "name" => "Наталия",
        ),
        array(
          "id" => 2518,
          "email" => "adelisv@rambler.ru",
          "name" => "Адель Хусаенова",
        ),
        array(
          "id" => 2520,
          "email" => "danilina88@yandex.ru",
          "name" => "Кристина",
        ),
        array(
          "id" => 2524,
          "email" => "natali-977@mail.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2525,
          "email" => "vulita@gmail.com",
          "name" => "Лейла",
        ),
        array(
          "id" => 2529,
          "email" => "dmitry.berezin78@gmail.com",
          "name" => "Дмитрий",
        ),
        array(
          "id" => 2530,
          "email" => "evkoff@mail.ru",
          "name" => "Евгения",
        ),
        array(
          "id" => 2531,
          "email" => "tutash@gmail.com",
          "name" => "Наталия",
        ),
        array(
          "id" => 2532,
          "email" => "selena307@yandex.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2534,
          "email" => "uliana.liferova@gmail.com",
          "name" => "Ульяна",
        ),
        array(
          "id" => 2535,
          "email" => "mordvinov87@mail.ru",
          "name" => "Владимир",
        ),
        array(
          "id" => 2536,
          "email" => "sasha-grushaa@yandex.ru",
          "name" => "Александра",
        ),
        array(
          "id" => 2540,
          "email" => "visotkova1983@gmail.com",
          "name" => "Анастасия",
        ),
        array(
          "id" => 2543,
          "email" => "klazarev@hotmail.com",
          "name" => "Константин",
        ),
        array(
          "id" => 2546,
          "email" => "ask.87@mail.ru",
          "name" => "Степан",
        ),
        array(
          "id" => 2547,
          "email" => "torovst@gmail.com",
          "name" => "Stepan",
        ),
        array(
          "id" => 2549,
          "email" => "20_ekaterina@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2550,
          "email" => "dashun87@mail.ru",
          "name" => "Дарья",
        ),
        array(
          "id" => 2551,
          "email" => "natali79-10@mail.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2553,
          "email" => "keit_94@bk.ru",
          "name" => "Катерина",
        ),
        array(
          "id" => 2564,
          "email" => "sentoma@rambler.ru",
          "name" => "Анастасия Викторова",
        ),
        array(
          "id" => 2569,
          "email" => "kamaleevaalbina@mail.ru",
          "name" => "Альбина",
        ),
        array(
          "id" => 2570,
          "email" => "mak_irina84@mail.ru",
          "name" => "Ирина",
        ),
        array(
          "id" => 2573,
          "email" => "goncharuchye@gmail.com",
          "name" => "Мария",
        ),
        array(
          "id" => 2574,
          "email" => "tanick@mail.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2576,
          "email" => "enryenry@mail.ru",
          "name" => "enrysaak",
        ),
        array(
          "id" => 2577,
          "email" => "kazak.albert@yandex.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2578,
          "email" => "nervov.net@gmail.com",
          "name" => "Карина",
        ),
        array(
          "id" => 2579,
          "email" => "katenka89_31@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2581,
          "email" => "l.tsitkina@mail.ru",
          "name" => "Любовь",
        ),
        array(
          "id" => 2584,
          "email" => "lenli82@mail.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2587,
          "email" => "roman812p@gmail.ru",
          "name" => "Роман",
        ),
        array(
          "id" => 2591,
          "email" => "natavasilieva78@mail.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2592,
          "email" => "annaanna13033@gmail.com",
          "name" => "Анна",
        ),
        array(
          "id" => 2594,
          "email" => "olga.maksimova2@yandex.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2595,
          "email" => "nimatora@gmail.com",
          "name" => "Vladislav",
        ),
        array(
          "id" => 2597,
          "email" => "annazel@mail.ru",
          "name" => "Анна",
        ),
        array(
          "id" => 2598,
          "email" => "precious-box@ya.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2601,
          "email" => "mayyafrid@gmail.com",
          "name" => "Майя",
        ),
        array(
          "id" => 2603,
          "email" => "karpanvi@gmail.com",
          "name" => "Анна",
        ),
        array(
          "id" => 2604,
          "email" => "girlcat4@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2605,
          "email" => "yanina79@mail.ru",
          "name" => "Яна",
        ),
        array(
          "id" => 2607,
          "email" => "agzamova_eva@mail.ru",
          "name" => "Ekaterina",
        ),
        array(
          "id" => 2611,
          "email" => "alenka2305@rambler.ru",
          "name" => "Алёна",
        ),
        array(
          "id" => 2612,
          "email" => "s.i.dmitrieva@gmail.com",
          "name" => "Софья",
        ),
        array(
          "id" => 2614,
          "email" => "hlk2001@mail.ru",
          "name" => "Алексей",
        ),
        array(
          "id" => 2617,
          "email" => "natachka1881@mail.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2619,
          "email" => "Di.va2013@yandex.ru",
          "name" => "Diana",
        ),
        array(
          "id" => 2620,
          "email" => "verka-sterwa@yandex.ru",
          "name" => "Вера",
        ),
        array(
          "id" => 2622,
          "email" => "klepka_try@mail.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2625,
          "email" => "o.markman25@gmail.com",
          "name" => "Ольга",
        ),
        array(
          "id" => 2627,
          "email" => "mrqfast@gmail.com",
          "name" => "Прокофьев",
        ),
        array(
          "id" => 2629,
          "email" => "forfoto2019@bk.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2635,
          "email" => "l-tokareva@yandex.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2639,
          "email" => "irinavelichkospb@gmail.com",
          "name" => "Ирина",
        ),
        array(
          "id" => 2641,
          "email" => "remezova92@mail.ru",
          "name" => "Ольга",
        ),
        array(
          "id" => 2645,
          "email" => "supercatkuzya@mail.ru",
          "name" => "Полина",
        ),
        array(
          "id" => 2651,
          "email" => "sa-fly@yandex.ru",
          "name" => "Лобанова Татьяна",
        ),
        array(
          "id" => 2653,
          "email" => "maskaleva.yuliya@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 2654,
          "email" => "mari60881@mail.ru",
          "name" => "Марина",
        ),
        array(
          "id" => 2658,
          "email" => "annap-spb@yandex.ru",
          "name" => "Анна",
        ),
        array(
          "id" => 2660,
          "email" => "sovamalina@gmail.com",
          "name" => "Ольга",
        ),
        array(
          "id" => 2662,
          "email" => "katron_2405@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2663,
          "email" => "iraramilevna@gmail.com",
          "name" => "Ирина",
        ),
        array(
          "id" => 2665,
          "email" => "lukina.nsp@gmail.com",
          "name" => "Лариса",
        ),
        array(
          "id" => 2668,
          "email" => "shenechk@mail.ru",
          "name" => "Евгения",
        ),
        array(
          "id" => 2669,
          "email" => "t.migranova.dodo@gmail.com",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2672,
          "email" => "loky25@mail.ru",
          "name" => "Дарья",
        ),
        array(
          "id" => 2673,
          "email" => "julia___ak@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 2674,
          "email" => "gul2153@yandex.ru",
          "name" => "Гульнара",
        ),
        array(
          "id" => 2684,
          "email" => "Sasa19702609@yandex.ru",
          "name" => "Александра",
        ),
        array(
          "id" => 2687,
          "email" => "Mariya.zubko@gmail.com",
          "name" => "Мария",
        ),
        array(
          "id" => 2690,
          "email" => "alex.k91@inbox.ru",
          "name" => "Александра",
        ),
        array(
          "id" => 2691,
          "email" => "kseni1980j@mail.ru",
          "name" => "Оксана",
        ),
        array(
          "id" => 2693,
          "email" => "ToyRocketStudio@gmail.com",
          "name" => "Сергей",
        ),
        array(
          "id" => 2697,
          "email" => "nicanorik@gmail.com",
          "name" => "Анастасия",
        ),
        array(
          "id" => 2699,
          "email" => "ryo-81@mail.ru",
          "name" => "Игорь",
        ),
        array(
          "id" => 2700,
          "email" => "taro-vopros@rambler.ru",
          "name" => "Яна",
        ),
        array(
          "id" => 2701,
          "email" => "tsykinaev@mail.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2702,
          "email" => "Likochka88@mail.ru",
          "name" => "Лика",
        ),
        array(
          "id" => 2703,
          "email" => "andreeva.natali12@mail.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2706,
          "email" => "elenamk08@mail.ru",
          "name" => "София",
        ),
        array(
          "id" => 2709,
          "email" => "pacahontasyeap@gmail.com",
          "name" => "Евгения",
        ),
        array(
          "id" => 2710,
          "email" => "nikavik47@gmail.com",
          "name" => "Вероника",
        ),
        array(
          "id" => 2714,
          "email" => "ksenia-nf@yandex.ru",
          "name" => "Ксения",
        ),
        array(
          "id" => 2715,
          "email" => "kurguzova.anna@gmail.com",
          "name" => "Анна",
        ),
        array(
          "id" => 2716,
          "email" => "9111323200@mail.ri",
          "name" => "Александра",
        ),
        array(
          "id" => 2718,
          "email" => "dees@bk.ru",
          "name" => "Дмитрий",
        ),
        array(
          "id" => 2719,
          "email" => "fja@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 2721,
          "email" => "LenKka_1026@mail.ru",
          "name" => "Alena",
        ),
        array(
          "id" => 2725,
          "email" => "rga12@yandex.ru",
          "name" => "Галина",
        ),
        array(
          "id" => 2726,
          "email" => "victoriagorodnitskaya@yandex.ru",
          "name" => "Вика",
        ),
        array(
          "id" => 2731,
          "email" => "vladelena@mail.ru",
          "name" => "Elena",
        ),
        array(
          "id" => 2732,
          "email" => "timashova.a@gmail.com",
          "name" => "Эрика",
        ),
        array(
          "id" => 2733,
          "email" => "familytreasures@yandex.ru",
          "name" => "Anastasia",
        ),
        array(
          "id" => 2738,
          "email" => "viktoria@tkach.eu",
          "name" => "VIKTORIA",
        ),
        array(
          "id" => 2741,
          "email" => "danikmasik2012@gmail.com",
          "name" => "Мария",
        ),
        array(
          "id" => 2742,
          "email" => "olesa2582@mail.ru",
          "name" => "Олеся",
        ),
        array(
          "id" => 2746,
          "email" => "olli@list.ru",
          "name" => "Мария",
        ),
        array(
          "id" => 2749,
          "email" => "lerochka_ne@mail.ru",
          "name" => "Никита",
        ),
        array(
          "id" => 2750,
          "email" => "murakami@inbox.ru",
          "name" => "София",
        ),
        array(
          "id" => 2754,
          "email" => "katrussik@list.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2757,
          "email" => "anna.kirillova51@gmail.com",
          "name" => "Анна",
        ),
        array(
          "id" => 2758,
          "email" => "1990yana@gmail.com",
          "name" => "Яна",
        ),
        array(
          "id" => 2761,
          "email" => "podsev_seva@mail.ru",
          "name" => "Всеволод",
        ),
        array(
          "id" => 2763,
          "email" => "pasha-91@bk.ru",
          "name" => "Павел",
        ),
        array(
          "id" => 2766,
          "email" => "ksenya_kramer@mail.ru",
          "name" => "Ксения",
        ),
        array(
          "id" => 2769,
          "email" => "ds_stepanova@mail.ru",
          "name" => "Дарья",
        ),
        array(
          "id" => 2770,
          "email" => "Redsvetlanka@gmail.com",
          "name" => "Светлана",
        ),
        array(
          "id" => 2771,
          "email" => "elsepa@mail.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2775,
          "email" => "cleo6791@mail.ru",
          "name" => "Анна",
        ),
        array(
          "id" => 2777,
          "email" => "blackmarinero3700@mail.ru",
          "name" => "Марина",
        ),
        array(
          "id" => 2785,
          "email" => "lubruss13@mail.ru",
          "name" => "Любовь",
        ),
        array(
          "id" => 2788,
          "email" => "daryayo@yandex.ru",
          "name" => "Daria",
        ),
        array(
          "id" => 2789,
          "email" => "barkovamail@bk.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2790,
          "email" => "nika.svetukhina@gmail.com",
          "name" => "Ника",
        ),
        array(
          "id" => 2793,
          "email" => "footless-fancies@yandex.ru",
          "name" => "Олеся",
        ),
        array(
          "id" => 2796,
          "email" => "zaza_lu@mail.ru",
          "name" => "Жанна",
        ),
        array(
          "id" => 2800,
          "email" => "sun-hina@mail.ru",
          "name" => "Лилия",
        ),
        array(
          "id" => 2801,
          "email" => "prudnikovavikaliza@mail.ru",
          "name" => "Виктория",
        ),
        array(
          "id" => 2802,
          "email" => "volkovadina89@gmail.com",
          "name" => "Дина",
        ),
        array(
          "id" => 2806,
          "email" => "adygeya@bk.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2807,
          "email" => "dokdhanina97@inbox.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 2809,
          "email" => "s.natali07@bk.ru",
          "name" => "Наталья",
        ),
        array(
          "id" => 2811,
          "email" => "lyantono@yandex.ru",
          "name" => "Любовь",
        ),
        array(
          "id" => 2812,
          "email" => "d_ekaterina@inbox.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2814,
          "email" => "lerasmirnova@gmail.com",
          "name" => "Валерия",
        ),
        array(
          "id" => 2815,
          "email" => "lilalyy@yandex.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2816,
          "email" => "bukosha@mail.ru",
          "name" => "Анна",
        ),
        array(
          "id" => 2822,
          "email" => "ersill@yandex.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2824,
          "email" => "meowmar666@gmail.com",
          "name" => "Марина",
        ),
        array(
          "id" => 2826,
          "email" => "titiana1607@mail.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2827,
          "email" => "svetlana.v@list.ru",
          "name" => "Светлана",
        ),
        array(
          "id" => 2830,
          "email" => "maryzueva1987@gmail.com",
          "name" => "Марина",
        ),
        array(
          "id" => 2832,
          "email" => "N.Shchekovskaia@gmail.com",
          "name" => "Наталья",
        ),
        array(
          "id" => 2838,
          "email" => "puma2005-88@mail.ru",
          "name" => "Маргарита",
        ),
        array(
          "id" => 2840,
          "email" => "kentleh@mail.ru",
          "name" => "Екатерина",
        ),
        array(
          "id" => 2841,
          "email" => "dariya-doc@yandex.ru",
          "name" => "Дарья",
        ),
        array(
          "id" => 2842,
          "email" => "neizb@inbox.ru",
          "name" => "ГАЛИНА",
        ),
        array(
          "id" => 2844,
          "email" => "slejza@mail.ru",
          "name" => "Татьяна",
        ),
        array(
          "id" => 2846,
          "email" => "uteva1991@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 2849,
          "email" => "yulya_grekova@mail.ru",
          "name" => "Юлия",
        ),
        array(
          "id" => 2850,
          "email" => "zuuzla@mail.ru",
          "name" => "Зоя",
        ),
        array(
          "id" => 2856,
          "email" => "raznavesta@gmail.com",
          "name" => "Светлана",
        ),
        array(
          "id" => 2857,
          "email" => "eskinan@bk.ru",
          "name" => "Nata",
        ),
        array(
          "id" => 2858,
          "email" => "a.l.i.n.ka@mail.ru",
          "name" => "Алина",
        ),
        array(
          "id" => 2863,
          "email" => "grinch85@yandex.ru",
          "name" => "Елена",
        ),
        array(
          "id" => 2864,
          "email" => "lstll@hotmail.com",
          "name" => "Люся",
        ),
        array(
          "id" => 2867,
          "email" => "nastya-15.08.93@mail.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 2870,
          "email" => "lybov23@mail.ru",
          "name" => "Любовь",
        ),
        array(
          "id" => 2871,
          "email" => "elena.kozhekina@gmail.com",
          "name" => "Елена",
        ),
        array(
          "id" => 2872,
          "email" => "irinamazyr41@gmail.com",
          "name" => "Ирина",
        ),
        array(
          "id" => 2874,
          "email" => "n.sokolkina@pen-paper.ru",
          "name" => "Natalia",
        ),
        array(
          "id" => 2878,
          "email" => "evglevskiymax@gmail.com",
          "name" => "Максим",
        ),
        array(
          "id" => 2881,
          "email" => "maralex2000@mail.ru",
          "name" => "Марина",
        ),
        array(
          "id" => 2883,
          "email" => "sharapova-kr@yandex.ru",
          "name" => "Кристина",
        ),
        array(
          "id" => 2884,
          "email" => "dia155@yandex.ru",
          "name" => "Диана",
        ),
        array(
          "id" => 2886,
          "email" => "Shalgueva@gmail.com",
          "name" => "Dina",
        ),
        array(
          "id" => 2897,
          "email" => "mariamakarova140@gmail.com",
          "name" => "Мария",
        ),
        array(
          "id" => 2899,
          "email" => "farhyd@mail.ru",
          "name" => "Эльвира",
        ),
        array(
          "id" => 2900,
          "email" => "alex-glu@yandex.ru",
          "name" => "Александр",
        ),
        array(
          "id" => 2905,
          "email" => "marisal1988lm@mail.ru",
          "name" => "Марина",
        ),
        array(
          "id" => 2908,
          "email" => "workzhavyra@gmail.com",
          "name" => "Александр",
        ),
        array(
          "id" => 2909,
          "email" => "dypo4ka@list.ru",
          "name" => "Анастасия",
        ),
        array(
          "id" => 2911,
          "email" => "nadellli@icloud.com",
          "name" => "Надежда",
        ),
      );
      
      

      foreach ($users as $key => $user) {  
        $email = $user['email'];
        Mail::send('mail.rasilka', ['user' => $user], function($m)use($email){
          $m->to($email,'to');
          $m->from('no-reply@bananich.ru');
          $m->subject('Новая акция недели от Бананыча!)');
        });
        dump(count($users) - $key . ' - ' . $user['name'] . ' - ' . $user['email']);
        
      }

    }
}
