<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    {{-- Vendors --}}
    @if (ENV('APP_ENV') != 'local' && strpos($_SERVER['SERVER_NAME'], 'neolavka.') !== false)
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
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/72176563" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->
    @endif

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>    
        {{ strpos($_SERVER['SERVER_NAME'], '.loc') !== false ? '🎢LOCAL🎢' : '' }}
        {{ strpos($_SERVER['SERVER_NAME'], 'bananich.') !== false ? 'Bananich 🍌' : '' }}
        {{ strpos($_SERVER['SERVER_NAME'], 'neolavka.') !== false ? 'Neolavka 🌿' : '' }}
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
