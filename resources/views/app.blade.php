<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon" />
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('fonts/circular/stylesheet.css') }}">

        <!-- Scripts -->
        @routes
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="">
        @inertia
        @if(Route::getCurrentRoute()->uri == '/')
            <!-- Start of LiveChat (www.livechatinc.com) code -->
            <script type="text/javascript">
                window.__lc = window.__lc || {};
                window.__lc.license = 13293825;
                ;(function(n,t,c){function i(n){return e._h?e._h.apply(null,n):e._q.push(n)};
                    var e={_q:[],_h:null,_v:"2.0",on:function(){i(["on",c.call(arguments)])},once:function(){
                            i(["once",c.call(arguments)])},off:function(){i(["off",c.call(arguments)])},
                        get:function(){if(!e._h)throw new Error("[LiveChatWidget] You can't use getters before load.");
                            return i(["get",c.call(arguments)])},call:function(){i(["call",c.call(arguments)])},init:function(){
                            var n=t.createElement("script");
                            n.async=!0,n.type="text/javascript",
                                n.src="https://cdn.livechatinc.com/tracking.js",t.head.appendChild(n)}};
                    !n.__lc.asyncInit&&e.init(),n.LiveChatWidget=n.LiveChatWidget||e}(window,document,[].slice))
            </script>
            <noscript>
                <a href="https://www.livechatinc.com/chat-with/13293825/" rel="nofollow">Chat with us</a>,
                powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a>
            </noscript>
            <!-- End of LiveChat code -->
            
            <script type="text/javascript">
                var _iub = _iub || [];
                _iub.csConfiguration = {"countryDetection":true,"lang":"{{\Illuminate\Support\Facades\App::getLocale()}}","siteId":2409101,"floatingPreferencesButtonDisplay":false,"consentOnContinuedBrowsing":false,"cookiePolicyId":45354605, "banner":{ "acceptButtonDisplay":true,"customizeButtonDisplay":true,"acceptButtonColor":"#9bd639","acceptButtonCaptionColor":"white","customizeButtonColor":"rgba(33.8, 33.8, 33.8, 0.46)","customizeButtonCaptionColor":"white","rejectButtonColor":"#e3a134","rejectButtonCaptionColor":"white","position":"float-top-center","textColor":"#ffffff","backgroundColor":"rgba(0, 0, 1.92, 0.37)","rejectButtonDisplay":true,"listPurposes":true }};
            </script>
            <script type="text/javascript" src="//cdn.iubenda.com/cs/iubenda_cs.js" charset="UTF-8" async></script>
        @endif
    </body>

</html>
