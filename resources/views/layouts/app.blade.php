<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Vendors --}}
    @if (strpos($_SERVER['SERVER_NAME'], '.loc') === false && strpos($_SERVER['SERVER_NAME'], 'neolavka.') !== false)
        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        
            ym(72176563, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true,
                ecommerce:"dataLayer"
            });
            ym(72176563, 'userParams', {id: {{Auth::user() ? Auth::user()->id : 0}} });
            ym(72176563, 'setUserID', '{{Auth::user() ? Auth::user()->id : 0}}');
            ym(72176563, 'params', {customerId: {{Auth::user() ? Auth::user()->id : 0}} });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/72176563" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

        <!-- /Yandex.Pixel -->
        <script type="text/javascript">!function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src="https://vk.com/js/api/openapi.js?168",t.onload=function(){VK.Retargeting.Init("VK-RTRG-878297-fMsbn"),VK.Retargeting.Hit()},document.head.appendChild(t)}();</script><noscript><img src="https://vk.com/rtrg?p=VK-RTRG-878297-fMsbn" style="position:fixed; left:-999px;" alt=""/></noscript>
        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '128300155829263');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=128300155829263&ev=PageView&noscript=1"
        /></noscript>
        <!-- End Facebook Pixel Code -->
    @endif

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>    
        {{ strpos($_SERVER['SERVER_NAME'], '.loc') !== false ? 'LOC 🐜' : '' }}
        {{ strpos($_SERVER['SERVER_NAME'], 'bananich.') !== false ? 'Bananich 🍌' : '' }}
        {{ strpos($_SERVER['SERVER_NAME'], 'neolavka.') !== false ? 'Neolavka 🍐' : '' }}
    </title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;1,300;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    {{-- Favicon --}}
    <?php
        $favicon = strpos($_SERVER['SERVER_NAME'], 'bananich.') !== false ? 'img/favicon.png' : 'img/neo_favicon.png';
    ?>
    <link rel="icon" href="{{$favicon}}" type="image/x-icon">
    
  
</head>
<body>
    

    {{-- Vendors --}}
    @if (ENV('APP_ENV') != 'local' )
        {{--  --}}
    @endif

    <div id="app">
        <main class="py-0">
            @yield('content')
        </main>
    </div>
</body>
</html>
