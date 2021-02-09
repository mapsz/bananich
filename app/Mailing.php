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
        ['email' => 'mollka92@mail.ru', 'name'=>'Алиса'],
        ['email' => 'evkestel@yandex.ru', 'name'=>'Евгения'],
        ['email' => 'st.andrey@list.ru', 'name'=>'Андрей'],
        ['email' => 'mad61091@gmail.com', 'name'=>'Мария'],
        ['email' => 'kley@ya.ru', 'name'=>'Алексей'],
        ['email' => 'rybinamaria466@gmail.com', 'name'=>'Мария'],
        ['email' => 'Nashatulja@mail.ru', 'name'=>'Наталья'],
        ['email' => 'saturdayforme@gmail.com', 'name'=>'Анастасия'],
        ['email' => 'Snider2000@mail.ru', 'name'=>'Александр'],
        ['email' => 'lucymf@yandex.ru', 'name'=>'Алина'],
        ['email' => 'popova-inna@yandex.ru', 'name'=>'Инна'],
        ['email' => 'lenskya1003@gmail.com', 'name'=>'Анжелика'],
        ['email' => '2yana2003@mail.ru', 'name'=>'Tuyana'],
        ['email' => 'alya.kir@mail.ru', 'name'=>'Алина'],
        ['email' => 'e-filipp@yandex.ru', 'name'=>'Елизавета'],
        ['email' => 'Md.annarats@gmail.com', 'name'=>'Анна'],
        ['email' => 'maxwell5060@yandex.ru', 'name'=>'Максим'],
        ['email' => 'aichet5@mail.ru', 'name'=>'Айшет'],
        ['email' => 'sashaigorevna2013@gmail.com', 'name'=>'Александра'],
        ['email' => 'koroleva_mipa@mail.ru', 'name'=>'Анна'],
        ['email' => 'suvorova1705@mail.ru', 'name'=>'Юлия'],
        ['email' => 'alinjch@icloud.com', 'name'=>'Алина'],
        ['email' => 'mvchaikovskaya@gmail.com', 'name'=>'Маргарита'],
        ['email' => 'dkate90@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'norpa_marinka@list.ru', 'name'=>'Марина'],
        ['email' => 'alina_sergeeva@list.ru', 'name'=>'Алина'],
        ['email' => 'beglyakovaoa@gmail.com', 'name'=>'Олеся'],
        ['email' => 'Aru035@gmail.com', 'name'=>'Александра'],
        ['email' => 'greentorain@gmail.com', 'name'=>'Яра'],
        ['email' => 'gutegelova@yandex.ru', 'name'=>'Гуля'],
        ['email' => 'mariya9@bk.ru', 'name'=>'Мария'],
        ['email' => 'annagerm@yahoo.com', 'name'=>'Анна'],
        ['email' => 'evstkatya@yandex.ru', 'name'=>'Екатерина'],
        ['email' => 'merzluka@mail.ru', 'name'=>'Анна'],
        ['email' => 'm2560006@yandex.ru', 'name'=>'Мила'],
        ['email' => 'lanasweta@yandex.ru', 'name'=>'Светлана'],
        ['email' => 'andriyhusti@gmail.com', 'name'=>'Андрей'],
        ['email' => 'victory-slobojaninova@mail.ru', 'name'=>'Виктория'],
        ['email' => 'shamsutdinova_regina@yahoo.com', 'name'=>'Регина'],
        ['email' => 'ranitta@mail.ru', 'name'=>'Рания'],
        ['email' => 'taisgrigorieva480@gmail.com', 'name'=>'Таисия'],
        ['email' => 'himmelt@yandex.ru', 'name'=>'Татьяна'],
        ['email' => 'ksenia.tatarintzeva@gmail.com', 'name'=>'Ксения'],
        ['email' => 'sstado@gmail.com', 'name'=>'Яна'],
        ['email' => 'D_olca@mail.ru', 'name'=>'Ольга'],
        ['email' => 'alina_battalova@bk.ru', 'name'=>'Алина'],
        ['email' => 'hippocorn1988@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'vailayrin@gmail.com', 'name'=>'Валерия'],
        ['email' => 'talpaka@yandex.ru', 'name'=>'Татьяна'],
        ['email' => 'sniper-fczp@yandex.ru', 'name'=>'Олеся'],
        ['email' => '9353254@mail.ru', 'name'=>'Наталья'],
        ['email' => 'shkout@yandex.ru', 'name'=>'Александр'],
        ['email' => 'ainenenene.gayane@gmail.com', 'name'=>'Гаянэ'],
        ['email' => 'sveta.chuinyshena@gmail.com', 'name'=>'Светлана'],
        ['email' => 'korshun3554@gmail.com', 'name'=>'Елена'],
        ['email' => 'luba.a.smirnova@gmail.com', 'name'=>'Любовь Смирнова'],
        ['email' => 'olganmanko@gmail.com', 'name'=>'Ольга'],
        ['email' => 'maklakova74@rambler.ru', 'name'=>'Алексадра'],
        ['email' => 'katya_kotik87@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'mouette6@mail.ru', 'name'=>'Лариса'],
        ['email' => 'mouette6@mail.ru', 'name'=>'Лариса'],
        ['email' => 'ehlinkapyadukhova@yandex.ru', 'name'=>'Элина'],
        ['email' => 'naduwane@gmail.com', 'name'=>'Надежда'],
        ['email' => 'sunshine_113@mail.ru', 'name'=>'Elena'],
        ['email' => 'aobobr@yandex.ru', 'name'=>'Алексей'],
        ['email' => 'ksyyu@mail.ru', 'name'=>'Оксана'],
        ['email' => 'ven.shakirova@gmail.com', 'name'=>'Венера'],
        ['email' => 'vik.bosyj@gmail.com', 'name'=>'Виктория'],
        ['email' => 'Pai.8@yandex.ru', 'name'=>'Александра'],
        ['email' => 'kroshka_drew@mail.ru', 'name'=>'Ksenia'],
        ['email' => 'ko_sya@list.ru', 'name'=>'Ольга'],
        ['email' => 'olyarsenyeva@mail.ru', 'name'=>'Ольга'],
        ['email' => 'vladislav.gorbick@yandex.ru', 'name'=>'Владислав'],
        ['email' => 'karinamorozova1112@rambler.ru', 'name'=>'Карина'],
        ['email' => 'shashka_rekant@mail.ru', 'name'=>'Александра'],
        ['email' => 'ania1993@list.ru', 'name'=>'Анна'],
        ['email' => 'elyannd@gmail.com', 'name'=>'Алина'],
        ['email' => 'galuwka@rambler.ru', 'name'=>'Галина'],
        ['email' => 'ilovechendler@gmail.com', 'name'=>'Кристина'],
        ['email' => 'anastasiaalarina@gmail.com', 'name'=>'Анастасия'],
        ['email' => 'emitaohof@gmail.com', 'name'=>'София'],
        ['email' => 'Xacyku@list.ru', 'name'=>'Софья'],
        ['email' => 'vulita@gmail.com', 'name'=>'Лейла'],
        ['email' => 'zinka1@list.ru', 'name'=>'Зинаида'],
        ['email' => 'aslanovadaria@yandex.ru', 'name'=>'Дарья'],
        ['email' => 'johan.trumpeter@gmail.com', 'name'=>'Маргарита'],
        ['email' => 'smartpain@mail.ru', 'name'=>'Юлия'],
        ['email' => 'prr1612@gmail.com', 'name'=>'Руслан'],
        ['email' => 'jannkor@mail.ru', 'name'=>'Жанна'],
        ['email' => 'vpozitive@mail.ru', 'name'=>'Диана'],
        ['email' => 'aryonmeow@gmail.com', 'name'=>'Алёна'],
        ['email' => 'vvmkl@ya.ru', 'name'=>'Валентина'],
        ['email' => 'sev_yul@mail.ru', 'name'=>'Юлия'],
        ['email' => 'nastenka_0892@bk.ru', 'name'=>'Анастасия'],
        ['email' => 'leg28009@gmail.com', 'name'=>'Любовь'],
        ['email' => 'katrunskinny@gmail.com', 'name'=>'Екатерина'],
        ['email' => 'urbsam@icloud.com', 'name'=>'Ксения'],
        ['email' => 'irina.cherkasskikh@mail.ru', 'name'=>'Irina'],
        ['email' => 'yarbabinskaya@gmail.com', 'name'=>'Ярославна'],
        ['email' => 'kir-shuvaloff@yandex.ru', 'name'=>'Кира'],
        ['email' => 'olga-stepanyuk@bk.ru', 'name'=>'Оля'],
        ['email' => 'elkina.nata@mail.ru', 'name'=>'Наталия'],
        ['email' => 'mermaid_90@mail.ru', 'name'=>'Ольга'],
        ['email' => '89110370570@mail.ru', 'name'=>'Иван'],
        ['email' => 'fakeglue@gmail.com', 'name'=>'Ася'],
        ['email' => 'bakharev.k@gmail.com', 'name'=>'Константин'],
        ['email' => 'karnavalovava@mail.ru', 'name'=>'Валентина'],
        ['email' => 'a.brestkin@gmail.com', 'name'=>'Антон'],
        ['email' => 'kira-bezhanova@mail.ru', 'name'=>'Кира'],
        ['email' => 'Nadya-moon@mail.ru', 'name'=>'Надя'],
        ['email' => 'khuraman_eup_23@bk.ru', 'name'=>'Хураман'],
        ['email' => 'urbanklyaksa@mail.ru', 'name'=>'Мария'],
        ['email' => 'alexandra.savina.vl@gmail.com', 'name'=>'Александра'],
        ['email' => 'j.tanya@mail.ru', 'name'=>'Татьяна'],
        ['email' => 'tatyana_solodova@mail.ru', 'name'=>'Татьяна'],
        ['email' => 'oikaika@gmail.com', 'name'=>'Ольга'],
        ['email' => 'mashunya-9@yandex.ru', 'name'=>'Татьяна'],
        ['email' => 'anastasia.ryabtseva@gmail.com', 'name'=>'Анастасия Рябцева'],
        ['email' => 'm.pimorenko@mail.ru', 'name'=>'Мария'],
        ['email' => 'puhovskaya1@mail.ru', 'name'=>'Татьяна'],
        ['email' => 'ale_light@mail.ru', 'name'=>'Александра'],
        ['email' => 'sh_nastasya@list.ru', 'name'=>'Анастасия'],
        ['email' => 'sergeeva.luda02@yandex.ru', 'name'=>'Людмила'],
        ['email' => 'suprunova_00@mail.ru', 'name'=>'Елизавета'],
        ['email' => 'a183052@mail.ru', 'name'=>'Анна'],
        ['email' => 'loovedimkaa@mail.ru', 'name'=>'Яна'],
        ['email' => 'petrova.innaa@gmail.com', 'name'=>'Инна'],
        ['email' => 'nina.veselova.job@gmail.com', 'name'=>'Nina'],
        ['email' => 'goldenlocks@mail.ru', 'name'=>'Полина'],
        ['email' => 'katya.rina@gmail.com', 'name'=>'Katerina'],
        ['email' => 'nycteastephens828@gmail.com', 'name'=>'Алина'],
        ['email' => 'phrocia@mail.ru', 'name'=>'Ольга'],
        ['email' => 'elena_top@list.ru', 'name'=>'Елена'],
        ['email' => 'littlepanic147@gmail.com', 'name'=>'Лена'],
        ['email' => 'mega.kostyukova@mail.ru', 'name'=>'Юлия'],
        ['email' => 'ludmisha09@mail.ru', 'name'=>'Людмила'],
        ['email' => 'prossto@yandex.ru', 'name'=>'Елена'],
        ['email' => 'nicolpny@gmail.com', 'name'=>'Екатерина'],
        ['email' => 'shulyamba@mail.ru', 'name'=>'Мария'],
        ['email' => 'av.geibo@gmail.com', 'name'=>'Анна'],
        ['email' => 'fedul7@mail.ru', 'name'=>'Батыр'],
        ['email' => 'levinson.ipad@gmail.com', 'name'=>'Анна'],
        ['email' => 'elenakostina86@mail.ru', 'name'=>'Елена'],
        ['email' => 'jrcfyf888@mail.ru', 'name'=>'Оксана'],
        ['email' => 'dashakruglova@gmail.com', 'name'=>'Дарья'],
        ['email' => 'innostra@yandex.ru', 'name'=>'Наталья'],
        ['email' => 'lankarulla@gmail.com', 'name'=>'Катя'],
        ['email' => 'katjaaleksandrova@ya.ru', 'name'=>'Екатерина'],
        ['email' => 'floradaria@mail.ru', 'name'=>'Дарья'],
        ['email' => 'kristina.gmi@gmail.com', 'name'=>'Кристина'],
        ['email' => 'tishkasp@yandex.ru', 'name'=>'Ирина'],
        ['email' => 'caspereta@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'natasha.vostokova@gmail.com', 'name'=>'Наталья'],
        ['email' => 'neizb@inbox.ru', 'name'=>'ГАЛИНА'],
        ['email' => 'an.spb.rus@gmail.com', 'name'=>'Наталия'],
        ['email' => 'ivleva.i@gmail.com', 'name'=>'Ирина'],
        ['email' => 'alenna.89@mail.ru', 'name'=>'Алена'],
        ['email' => 'katushenka2004@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'Chrasotyle4ka@yandex.ru', 'name'=>'Кристина'],
        ['email' => 'miasspolly@mail.ru', 'name'=>'Полина'],
        ['email' => 'olga-gl@inbox.ru', 'name'=>'Ольга'],
        ['email' => 'alinalautner3@gmail.com', 'name'=>'Павел'],
        ['email' => 'dispersion8@gmail.com', 'name'=>'Полина'],
        ['email' => 'vyava@ngs.ru', 'name'=>'Яна'],
        ['email' => 'alexeykrivoruk@gmail.com', 'name'=>'Алексей'],
        ['email' => 'zlog@mail.ru', 'name'=>'Светлана'],
        ['email' => 'lili_halitova@mail.ru', 'name'=>'Лилия'],
        ['email' => 'elvira.kirsanova@gmail.com', 'name'=>'Эля'],
        ['email' => 'vale-budilova@yandex.ru', 'name'=>'Алина'],
        ['email' => 'N.potemina@gmail.com', 'name'=>'Наталия'],
        ['email' => 'ksy6501@ya.ru', 'name'=>'Ксения'],
        ['email' => 'bananichru@sharatan.net', 'name'=>'Андрей'],
        ['email' => 'Lanafena@gmail.com', 'name'=>'Светлана'],
        ['email' => 'kiseleva.vera2601@mail.ru', 'name'=>'Вера'],
        ['email' => 'el.ustimova@gmail.com', 'name'=>'Елена'],
        ['email' => 'duffy-devis@yandex.ru', 'name'=>'Светлана'],
        ['email' => 'Almaarot@mail.ru', 'name'=>'Софья'],
        ['email' => 'hey.asika@gmail.com', 'name'=>'Ася'],
        ['email' => 'kryazh.tanya@yandex.ru', 'name'=>'Татьяна'],
        ['email' => 'Natalimm91@gmail.com', 'name'=>'Наталья'],
        ['email' => 'kozhanova.luba@yandex.ru', 'name'=>'Любовь'],
        ['email' => 'dbugumbaeva@gmail.com', 'name'=>'Динара'],
        ['email' => 'a8882@bk.ru', 'name'=>'Анна'],
        ['email' => 'katya.shkolenko@gmail.com', 'name'=>'Екатерина'],
        ['email' => 'batonrain@gmail.com', 'name'=>'Евгений'],
        ['email' => 'mikheikinalubov@gmail.com', 'name'=>'Любовь'],
        ['email' => 'victoria.nehaichik@gmail.com', 'name'=>'Сергей'],
        ['email' => 'mggtk@list.ru', 'name'=>'Анна'],
        ['email' => 'sun_flower_@mail.ru', 'name'=>'Ксения'],
        ['email' => 'mari.vartanyan@gmail.com', 'name'=>'Мариам'],
        ['email' => 'lena.makeeva@gmail.com', 'name'=>'Елена'],
        ['email' => 'alexandrakarpova@bk.ru', 'name'=>'Александра'],
        ['email' => 'savushkina2802@gmail.com', 'name'=>'Анастасия'],
        ['email' => 'inna_a_z@mail.ru', 'name'=>'Инна Зароченцева'],
        ['email' => 'ksuty@inbox.ru', 'name'=>'Ксения'],
        ['email' => 'sv.mikhaylova.92@gmail.com', 'name'=>'Светлана'],
        ['email' => 'melkonyan.karine@gmail.com', 'name'=>'Каринэ Миронова'],
        ['email' => 'Intorico@me.com', 'name'=>'Анастасия'],
        ['email' => 'katuha010@gmail.com', 'name'=>'Катерина'],
        ['email' => 'Aapp2011@ya.ru', 'name'=>'Саша'],
        ['email' => 'ukkatta12@gmail.com', 'name'=>'Юлия'],
        ['email' => 'olechka.popova@gmail.com', 'name'=>'Ольга'],
        ['email' => 'zdzhaparalieva@mail.ru', 'name'=>'Жанна'],
        ['email' => 'doctortort@gmail.com', 'name'=>'Елизавета'],
        ['email' => 'Inalife@mail.ru', 'name'=>'Инга'],
        ['email' => 'alisamonak@yandex.ru', 'name'=>'Алиса'],
        ['email' => 'em76@list.ru', 'name'=>'Екатерина'],
        ['email' => 'elina6986@mail.ru', 'name'=>'Элина'],
        ['email' => 'olga19792003@mail.ru', 'name'=>'Ольга'],
        ['email' => 'ch.4nnie@yandex.ru', 'name'=>'Анна'],
        ['email' => 'shaminagintare@gmail.com', 'name'=>'Гинтаре'],
        ['email' => 'aleksandra.sergeeva@gmail.com', 'name'=>'Александра'],
        ['email' => 'yanchik-dudo@yandex.ru', 'name'=>'Яна'],
        ['email' => 'Lbz43@mail.ru', 'name'=>'Лора'],
        ['email' => 'nataljakonsetova@mail.ru', 'name'=>'Наталья'],
        ['email' => 'Shhh-h@list.ru', 'name'=>'Александра'],
        ['email' => 'red_baloon@mail.ru', 'name'=>'анна'],
        ['email' => 'panova_sveta@mail.ru', 'name'=>'Светлана'],
        ['email' => 'flygirl88@yandex.ru', 'name'=>'Дарья'],
        ['email' => 'ja.twins@yandex.ru', 'name'=>'Жанна'],
        ['email' => 'somova_v78@mail.ru', 'name'=>'Виктория'],
        ['email' => '79817493336@ya.ru', 'name'=>'Иван'],
        ['email' => 'evgenia090388@yandex.ru', 'name'=>'Евгения'],
        ['email' => 'vetolya@mail.ru', 'name'=>'Ольга'],
        ['email' => 'iv.titova@mail.ru', 'name'=>'Ирина'],
        ['email' => 'lenok.nikitina85@mail.ru', 'name'=>'Елена'],
        ['email' => 'sdudich@yandex.ru', 'name'=>'Светлана'],
        ['email' => 'katykutsistova@gmail.com', 'name'=>'Катя'],
        ['email' => 'tribalmohini@gmail.com', 'name'=>'Валентина'],
        ['email' => 'kozlova-1992@yandex.ru', 'name'=>'Дарья'],
        ['email' => 'escadus@gmail.com', 'name'=>'Мария'],
        ['email' => 'aviv@mail.ru', 'name'=>'Анна'],
        ['email' => 'mari_borisova@mail.ru', 'name'=>'Мария'],
        ['email' => 'bobjele@mail.ru', 'name'=>'Анна'],
        ['email' => 'asel-kushen@mail.ru', 'name'=>'Асель'],
        ['email' => 'little_bubu@list.ru', 'name'=>'Вера'],
        ['email' => 'goldenpr.irina@gmail.com', 'name'=>'Ирина'],
        ['email' => 'appiap888@gmail.com', 'name'=>'Ирина'],
        ['email' => 'catcatwow@mail.ru', 'name'=>'Екатерина'],
        ['email' => 'alton_88@mail.ru', 'name'=>'Ольга'],
        ['email' => 'arhangelskaya.vs@yandex.ru', 'name'=>'Дмитрий'],
        ['email' => 'ira_nazarova@mail.ru', 'name'=>'Ирина'],
        ['email' => 'imfranc@gmail.com', 'name'=>'Фанис'],
        ['email' => 'polliru@mail.ru', 'name'=>'Полина'],
        ['email' => 'lee.buyanovskaya@gmail.com', 'name'=>'Лиза'],
        ['email' => 'polina.reyner@gmail.com', 'name'=>'Полина'],
        ['email' => 'elvira1703@rambler.ru', 'name'=>'Эльвира'],
        ['email' => '2243440@mail.ru', 'name'=>'Ирина'],
        ['email' => '1443302@gmail.com', 'name'=>'Ирина'],
        ['email' => 'annomaliya666@yandex.ru', 'name'=>'Анна'],
        ['email' => 'vladislav.kovechenkov@gmail.com', 'name'=>'Владислав'],
        ['email' => 'shvarts_ca-more@mail.ru', 'name'=>'Полина'],
        ['email' => 'nexorspb@gmail.com', 'name'=>'Александр'],
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
