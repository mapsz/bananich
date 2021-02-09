<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Mail;
use App\User;
use App\Email;

class Mailing extends Model
{

  public static function send($id,$users){
    //Get email
    $email = Email::jugeGet(['id'=>$id]);

    foreach ($users as $key => $user) {
      //Add tags
      $toSendHtml = Email::customTags($email->html,$user);
      //Send attrs
      $send = [];
      $send['email'] = $user['email'];
      $send['subject'] = $email->subject;
      Mail::send('mail.customEmail', ['html' => $toSendHtml], function($m)use($send){
        $m->to($send['email'],'to');
        $m->from('no-reply@bananich.ru');
        $m->subject($send['subject']);
      });
      
    }

    return 1;

  }


    public static function open($id,$test = true,$site = false){
      // $users = User::get();
      $users = [
        ['email' => 'dashakruglova@gmail.com', 'name'=>'Дарья'],
        ['email' => 'alton_88@mail.ru', 'name'=>'Ольга'],
        ['email' => 'ira_nazarova@mail.ru', 'name'=>'Ирина'],
        ['email' => 'lee.buyanovskaya@gmail.com', 'name'=>'Лиза'],
        ['email' => 'elenakostina86@mail.ru', 'name'=>'Елена'],
        ['email' => 'arhangelskaya.vs@yandex.ru', 'name'=>'Дмитрий'],
        ['email' => 'nicolpny@gmail.com', 'name'=>'Екатерина'],
        ['email' => 'lena.makeeva@gmail.com', 'name'=>'Елена'],
        ['email' => 'katya.shkolenko@gmail.com', 'name'=>'Екатерина'],
        ['email' => 'shulyamba@mail.ru', 'name'=>'Мария'],
        ['email' => 'fedul7@mail.ru', 'name'=>'Батыр'],
        ['email' => 'av.geibo@gmail.com', 'name'=>'Анна'],
        ['email' => 'ukkatta12@gmail.com', 'name'=>'Юлия'],
        ['email' => 'sdudich@yandex.ru', 'name'=>'Светлана'],
        ['email' => 'prossto@yandex.ru', 'name'=>'Елена'],
        ['email' => 'ludmisha09@mail.ru', 'name'=>'Людмила'],
        ['email' => 'lenok.nikitina85@mail.ru', 'name'=>'Елена'],
        ['email' => 'vale-budilova@yandex.ru', 'name'=>'Алина'],
        ['email' => '1443302@gmail.com', 'name'=>'Ирина'],
        ['email' => 'mikheikinalubov@gmail.com', 'name'=>'Любовь'],
        ['email' => 'appiap888@gmail.com', 'name'=>'Ирина'],
        ['email' => 'aviv@mail.ru', 'name'=>'Анна'],
        ['email' => 'catcatwow@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'panova_sveta@mail.ru', 'name'=>'Светлана'],
        ['email' => 'zdzhaparalieva@mail.ru', 'name'=>'Жанна'],
        ['email' => 'asel-kushen@mail.ru', 'name'=>'Асель'],
        ['email' => 'elena_top@list.ru', 'name'=>'Елена'],
        ['email' => 'polina.reyner@gmail.com', 'name'=>'Полина'],
        ['email' => 'bobjele@mail.ru', 'name'=>'Анна'],
        ['email' => 'littlepanic147@gmail.com', 'name'=>'Лена'],
        ['email' => 'loovedimkaa@mail.ru', 'name'=>'Яна'],
        ['email' => 'alisamonak@yandex.ru', 'name'=>'Алиса'],
        ['email' => 'dbugumbaeva@gmail.com', 'name'=>'Динара'],
        ['email' => 'shaminagintare@gmail.com', 'name'=>'Гинтаре'],
        ['email' => 'doctortort@gmail.com', 'name'=>'Елизавета'],
        ['email' => 'kozlova-1992@yandex.ru', 'name'=>'Дарья'],
        ['email' => 'mari_borisova@mail.ru', 'name'=>'Мария'],
        ['email' => 'goldenpr.irina@gmail.com', 'name'=>'Ирина'],
        ['email' => 'olechka.popova@gmail.com', 'name'=>'Ольга'],
        ['email' => 'Shhh-h@list.ru', 'name'=>'Александра'],
        ['email' => 'Aapp2011@ya.ru', 'name'=>'Саша'],
        ['email' => 'alexandrakarpova@bk.ru', 'name'=>'Александра'],
        ['email' => 'kiseleva.vera2601@mail.ru', 'name'=>'Вера'],
        ['email' => 'vetolya@mail.ru', 'name'=>'Ольга'],
        ['email' => 'olga19792003@mail.ru', 'name'=>'Ольга'],
        ['email' => 'oikaika@gmail.com', 'name'=>'Ольга'],
        ['email' => 'kristina.gmi@gmail.com', 'name'=>'Кристина'],
        ['email' => 'mggtk@list.ru', 'name'=>'Анна'],
        ['email' => 'anastasia.ryabtseva@gmail.com', 'name'=>'Анастасия Рябцева'],
        ['email' => 'm.pimorenko@mail.ru', 'name'=>'Мария'],
        ['email' => 'N.potemina@gmail.com', 'name'=>'Наталия'],
        ['email' => 'Inalife@mail.ru', 'name'=>'Инга'],
        ['email' => 'el.ustimova@gmail.com', 'name'=>'Елена'],
        ['email' => 'olga-gl@inbox.ru', 'name'=>'Ольга'],
        ['email' => 'alexandra.savina.vl@gmail.com', 'name'=>'Александра'],
        ['email' => 'elina6986@mail.ru', 'name'=>'Элина'],
        ['email' => 'shvarts_ca-more@mail.ru', 'name'=>'Полина'],
        ['email' => 'red_baloon@mail.ru', 'name'=>'анна'],
        ['email' => 'batonrain@gmail.com', 'name'=>'Евгений'],
        ['email' => 'Nadya-moon@mail.ru', 'name'=>'Надя'],
        ['email' => 'inna_a_z@mail.ru', 'name'=>'Инна Зароченцева'],
        ['email' => 'aleksandra.sergeeva@gmail.com', 'name'=>'Александра'],
        ['email' => 'kira-bezhanova@mail.ru', 'name'=>'Кира'],
        ['email' => 'ja.twins@yandex.ru', 'name'=>'Жанна'],
        ['email' => 'floradaria@mail.ru', 'name'=>'Дарья'],
        ['email' => 'karnavalovava@mail.ru', 'name'=>'Валентина'],
        ['email' => 'duffy-devis@yandex.ru', 'name'=>'Светлана'],
        ['email' => '79817493336@ya.ru', 'name'=>'Иван'],
        ['email' => 'ksy6501@ya.ru', 'name'=>'Ксения'],
        ['email' => 'tribalmohini@gmail.com', 'name'=>'Валентина'],
        ['email' => 'annomaliya666@yandex.ru', 'name'=>'Анна'],
        ['email' => 'bakharev.k@gmail.com', 'name'=>'Константин'],
        ['email' => 'polliru@mail.ru', 'name'=>'Полина'],
        ['email' => 'elkina.nata@mail.ru', 'name'=>'Наталия'],
        ['email' => 'melkonyan.karine@gmail.com', 'name'=>'Каринэ Миронова'],
        ['email' => 'escadus@gmail.com', 'name'=>'Мария'],
        ['email' => 'victoria.nehaichik@gmail.com', 'name'=>'Сергей'],
        ['email' => 'caspereta@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'aryonmeow@gmail.com', 'name'=>'Алёна'],
        ['email' => 'katushenka2004@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'ivleva.i@gmail.com', 'name'=>'Ирина'],
        ['email' => 'sev_yul@mail.ru', 'name'=>'Юлия'],
        ['email' => 'nastenka_0892@bk.ru', 'name'=>'Анастасия'],
        ['email' => 'Chrasotyle4ka@yandex.ru', 'name'=>'Кристина'],
        ['email' => 'leg28009@gmail.com', 'name'=>'Любовь'],
        ['email' => 'katrunskinny@gmail.com', 'name'=>'Екатерина'],
        ['email' => 'irina.cherkasskikh@mail.ru', 'name'=>'Irina'],
        ['email' => 'an.spb.rus@gmail.com', 'name'=>'Наталия'],
        ['email' => 'johan.trumpeter@gmail.com', 'name'=>'Маргарита'],
        ['email' => 'smartpain@mail.ru', 'name'=>'Юлия'],
        ['email' => 'natasha.vostokova@gmail.com', 'name'=>'Наталья'],
        ['email' => 'lankarulla@gmail.com', 'name'=>'Катя'],
        ['email' => 'prr1612@gmail.com', 'name'=>'Руслан'],
        ['email' => 'vladislav.kovechenkov@gmail.com', 'name'=>'Владислав'],
        ['email' => 'dispersion8@gmail.com', 'name'=>'Полина'],
        ['email' => 'Xacyku@list.ru', 'name'=>'Софья'],
        ['email' => 'bananichru@sharatan.net', 'name'=>'Андрей'],
        ['email' => 'anastasiaalarina@gmail.com', 'name'=>'Анастасия'],
        ['email' => 'alinalautner3@gmail.com', 'name'=>'Павел'],
        ['email' => 'mari.vartanyan@gmail.com', 'name'=>'Мариам'],
        ['email' => 'Pai.8@yandex.ru', 'name'=>'Александра'],
        ['email' => 'ehlinkapyadukhova@yandex.ru', 'name'=>'Элина'],
        ['email' => 'naduwane@gmail.com', 'name'=>'Надежда'],
        ['email' => 'sunshine_113@mail.ru', 'name'=>'Elena'],
        ['email' => 'katya_kotik87@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'iv.titova@mail.ru', 'name'=>'Ирина'],
        ['email' => 'korshun3554@gmail.com', 'name'=>'Елена'],
        ['email' => 'katykutsistova@gmail.com', 'name'=>'Катя'],
        ['email' => 'talpaka@yandex.ru', 'name'=>'Татьяна'],
        ['email' => '9353254@mail.ru', 'name'=>'Наталья'],
        ['email' => 'himmelt@yandex.ru', 'name'=>'Татьяна'],
        ['email' => 'D_olca@mail.ru', 'name'=>'Ольга'],
        ['email' => 'shamsutdinova_regina@yahoo.com', 'name'=>'Регина'],
        ['email' => 'ranitta@mail.ru', 'name'=>'Рания'],
        ['email' => 'mariya9@bk.ru', 'name'=>'Мария'],
        ['email' => 'alina_sergeeva@list.ru', 'name'=>'Алина'],
        ['email' => 'beglyakovaoa@gmail.com', 'name'=>'Олеся'],
        ['email' => 'elvira.kirsanova@gmail.com', 'name'=>'Эля'],
        ['email' => 'aichet5@mail.ru', 'name'=>'Айшет'],
        ['email' => 'tishkasp@yandex.ru', 'name'=>'Ирина'],
        ['email' => '2yana2003@mail.ru', 'name'=>'Tuyana'],
        ['email' => 'lucymf@yandex.ru', 'name'=>'Алина'],
        ['email' => 'popova-inna@yandex.ru', 'name'=>'Инна'],
        ['email' => 'Nashatulja@mail.ru', 'name'=>'Наталья'],
        ['email' => 'mad61091@gmail.com', 'name'=>'Мария'],
        ['email' => 'kley@ya.ru', 'name'=>'Алексей'],
        ['email' => 'evkestel@yandex.ru', 'name'=>'Евгения'],
        ['email' => 'zeleniyel@gmail.com', 'name'=>'Стас'],
        ['email' => 'lenastarkova@bk.ru', 'name'=>'Елена'],
        ['email' => 'ritpe@ya.ru', 'name'=>'Маргарита'],
        ['email' => 'alba.vasi@yandex.ru', 'name'=>'Альбина'],
        ['email' => 'a.melentyeva@gmail.com', 'name'=>'Анастасия'],
        ['email' => 'tdurakova@mail.ru', 'name'=>'Татьяна'],
        ['email' => 'ekaterinavolk13@yandex.ru', 'name'=>'Екатерина'],
        ['email' => 'ludmilkin@yandex.ru', 'name'=>'Людмила'],
        ['email' => 'veranda08@yandex.ru', 'name'=>'Вера'],
        ['email' => 'oksikkori@gmail.com', 'name'=>'Оксана'],
        ['email' => 'nebotov@list.ru', 'name'=>'Наталья'],
        ['email' => 'annyavtushko@gmail.com', 'name'=>'Анна'],
        ['email' => '79312098987@yandex.ru', 'name'=>'Алиса'],
        ['email' => 'katerina-ved@yandex.ru', 'name'=>'Екатерина'],
        ['email' => 'evg.g.makarova@yandex.ru', 'name'=>'Евгения'],
        ['email' => 'scorpion1105@yandex.ru', 'name'=>'Андрей'],
        ['email' => 'angelochek.oliga@mail.ru', 'name'=>'Ольга'],
        ['email' => 'guzefin@gmail.com', 'name'=>'Алексей'],
        ['email' => 'alexandra.yarysh@gmail.com', 'name'=>'Alexandra'],
        ['email' => 'kruglova_maria@mail.ru', 'name'=>' Мария'],
        ['email' => 'zhannett78@rambler.ru', 'name'=>'Жанна'],
        ['email' => 'Lbz43@mail.ru', 'name'=>'Лора'],
        ['email' => 'yaroslav.pozdnyakov@gmail.com', 'name'=>'Yaroslav'],
        ['email' => 'Anna_lisa81@mail.ru', 'name'=>'Анна'],
        ['email' => 'narovicholga@mail.ru', 'name'=>'Ольга'],
        ['email' => 'nevrolog@mail.ru', 'name'=>'Ольга Рублева'],
        ['email' => 'ksyushe@mail.ru', 'name'=>'Ксюша'],
        ['email' => 'Yana.kozlova.21@mail.ru', 'name'=>'Яна'],
        ['email' => 'evgeniya017@bk.ru', 'name'=>'Евгения'],
        ['email' => 'giftik@list.ru', 'name'=>'Анна'],
        ['email' => 'karina_dima79@mail.ru', 'name'=>'Карина'],
        ['email' => 'qnarik.j@gmail.com', 'name'=>'Кнарик'],
        ['email' => 'lila.waits@gmail.com', 'name'=>'Людмила'],
        ['email' => 'yulews@mail.ru', 'name'=>'Юлия'],
        ['email' => 'lisaweta.s@yandex.ru', 'name'=>'Елизавета'],
        ['email' => 'petra-83@mail.ru', 'name'=>'Ирина'],
        ['email' => 'zhakeng@gmail.com', 'name'=>'Gulzat'],
        ['email' => 'ShikhovAnna@yandex.ru', 'name'=>'Анна'],
        ['email' => 'arinakopashina@gmail.com', 'name'=>'Арина'],
        ['email' => 'albinavolkonskaya@gmail.com', 'name'=>'Альбина'],
        ['email' => 'kutoraster@gmail.com', 'name'=>'Галина'],
        ['email' => 'angelina.prokopenko@inbox.ru', 'name'=>'Ангелина'],
        ['email' => 'lazareva.elizaveta@gmail.com', 'name'=>'Лиза'],
        ['email' => 'inary@mail.ru', 'name'=>'Анна'],
        ['email' => 'dymov.nick@yandex.ru', 'name'=>'Николай'],
        ['email' => 'elena_aksik@mail.ru', 'name'=>'Елена'],
        ['email' => 'to.dashavan@gmail.com', 'name'=>'Даша'],
        ['email' => 'anastasiavictory@yahoo.com', 'name'=>'Анастасия'],
        ['email' => 'iirik15@mail.ru', 'name'=>'Ирина'],
        ['email' => 'stolyarova-d@mail.ru', 'name'=>'Дарья'],
        ['email' => 'kramer2206@gmail.com', 'name'=>'Виктория'],
        ['email' => 'svets-design@yandex.ru', 'name'=>'Светлана'],
        ['email' => 'amur666777@yandex.ru', 'name'=>'Анастасия'],
        ['email' => 'shoonter@list.ru', 'name'=>'Антон'],
        ['email' => 'daria.zima@gmail.com', 'name'=>'Дарья'],
        ['email' => 's-x-valya@mail.ru', 'name'=>'Валентина'],
        ['email' => 'evgeniya.priss@mail.ru', 'name'=>'Женя'],
        ['email' => 'anyan9301@gmail.com', 'name'=>'Анна'],
        ['email' => 'lesya1303r@gmail.com', 'name'=>'Алеся'],
        ['email' => 'anna.smolyarova@gmail.com', 'name'=>'Анна'],
        ['email' => 'Fedotova.ohmr@yandex.ru', 'name'=>'Анастасия'],
        ['email' => 'lereena89@gmail.com', 'name'=>'Елена'],
        ['email' => 'tilsonya@gmail.com', 'name'=>'Софья'],
        ['email' => 'natalya_17@mail.ru', 'name'=>'Наталья'],
        ['email' => 'ksenia.pomazova@gmail.com', 'name'=>'Ксения'],
        ['email' => 'scherbakes@gmail.com', 'name'=>'Екатерина'],
        ['email' => 'galabizkit@mail.ru', 'name'=>'Галина'],
        ['email' => 'nepogodic@gmail.com', 'name'=>'Татьяна'],
        ['email' => 'diana.v.danilenko@gmail.com', 'name'=>'Диана'],
        ['email' => 'viktoriya_taraso@mail.ru', 'name'=>'Виктория'],
        ['email' => 'polina.apalko@gmail.com', 'name'=>'Полина'],
        ['email' => 'mashik2005@list.ru', 'name'=>'Мария'],
        ['email' => 'jmalyutina@gmail.com', 'name'=>'Юлия'],
        ['email' => 'mail@juliagroo.ru', 'name'=>'Julia'],
        ['email' => 'marianna_grigor@mail.ru', 'name'=>'Mari'],
        ['email' => 'ann.enfant@gmail.com', 'name'=>'Анна'],
        ['email' => 'avashestik@gmail.com', 'name'=>'Александра'],
        ['email' => 'mmv2507@mail.ru', 'name'=>'Марина'],
        ['email' => 'nat_zon@yahoo.com', 'name'=>'Наталия'],
        ['email' => 'inna_tom@mail.ru', 'name'=>'Инна'],
        ['email' => 'kseniyaalmasova@gmail.com', 'name'=>'Ксения'],
        ['email' => 'izzvezd@gmail.com', 'name'=>'Екатерина'],
        ['email' => 'ksultanova@gmail.com', 'name'=>'Екатерина'],
        ['email' => 'Fyodorovaks@gmail.com', 'name'=>'Ксения'],
        ['email' => 'pavlov.avdei@gmail.com', 'name'=>'Павел'],
        ['email' => 'whitekey103@gmail.com', 'name'=>'Ольга'],
      ];
                        
      if($test){
          $users = array(
            array(
              "id" => 4,
              "email" => "aslanovadaria@yandex.ru",
              "name" => "Дарья",
            ),
            array(
              "id" => 6,
              "email" => "mapss@inbox.lv",
              "name" => "jura",
            ),
            array(
              "id" => 6,
              "email" => "jurijsgergelaba@yandex.ru",
              "name" => "jura",
            ),
            array(
              "id" => 6,
              "email" => "work020520@yandex.ru",
              "name" => "Vera",
            )
          );
      }

      $email = Email::jugeGet(['id'=>$id]);

      foreach ($users as $key => $user) {  
        //Add tags
        $toSendHtml = Email::customTags($email->html,$user);
        //Send attrs
        $send = [];
        $send['email'] = $user['email'];
        $send['subject'] = $email->subject;
        //From
        if($site == 'x') $send['from'] = 'no-reply@neolavka.ru';
        else $send['from'] = 'no-reply@bananich.ru';
        Mail::send('mail.customEmail', ['html' => $toSendHtml, 'site' => $site], function($m)use($send){
          $m->to($send['email'],'to');
          $m->from($send['from']);
          $m->subject($send['subject']);
        });
        dump(count($users) - $key . ' - ' . $user['name'] . ' - ' . $user['email']);
        
      }

    }
}
