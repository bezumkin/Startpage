<!doctype html>
<html lang="ru-RU">
<head>
    <title>{$.en ? 'Webstartpage' : 'Домашняя страница'}</title>
    <base href="/"/>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/components/startpage/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/components/startpage/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/components/startpage/icons/favicon-16x16.png">
    <link rel="manifest" href="/assets/components/startpage/icons/manifest.json">
    <link rel="mask-icon" href="/assets/components/startpage/icons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/assets/components/startpage/icons/favicon.ico">
    <meta name="msapplication-config" content="/assets/components/startpage/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    {('<meta name="assets-version" content="' ~ $.assets_version ~ '">') | htmlToHead : false : false}
    {('/assets/components/startpage/css/web/main.css?v=' ~ $.assets_version) | cssToHead : false : false}
    {('/assets/components/startpage/js/web/lib/require.min.js?v=' ~ $.assets_version) | jsToBottom : false : false}
    {('/assets/components/startpage/js/web/config.js?v=' ~ $.assets_version) | jsToBottom : false : false}
</head>
<body>

<header>
    <div class="header">
        <div class="container">
            <div class="logo">
                Webstartpage
                <img src="/assets/components/startpage/img/logo.png"
                     srcset="/assets/components/startpage/img/logo@2x.png 2x">
            </div>
            <div class="hybridauth">
                {'!HybridAuth' | snippet : [
                'loginTpl' => '@FILE chunks/hybridauth/login.tpl',
                'logoutTpl' => '@FILE chunks/hybridauth/logout.tpl',
                'providerTpl' => '@FILE chunks/hybridauth/provider.tpl',
                'activeProviderTpl' => '@FILE chunks/hybridauth/provider-active.tpl',
                ]}
            </div>
        </div>
    </div>
    <div class="sub-header">
        <div class="container">
            <div class="lang">
                {if $.en}
                    <a href="/?lang=ru">
                        <img src="/assets/components/startpage/img/ru.png"
                             srcset="/assets/components/startpage/img/ru@2x.png 2x">
                    </a>
                {else}
                    <a href="/?lang=en">
                        <img src="/assets/components/startpage/img/en.png"
                             srcset="/assets/components/startpage/img/en@2x.png 2x">
                    </a>
                {/if}
            </div>
        </div>
    </div>
</header>
<section class="container" id="main-section">
    {'@FILE snippets/startpage.php' | snippet}
</section>
<footer>
    <div class="container">
        <div class="copy">
            &copy; 2011 - {'' | date : 'Y'}&nbsp;
            <a href="mailto:info@webstartpage.ru">{$.en ? 'Vasily Naumkin' : 'Василий Наумкин'}</a>
            <small>render time: [^t^]</small>
        </div>
        <div class="logos">
            <a href="https://modx.com" target="_blank">
                <img src="/assets/components/startpage/img/modx-logo.png"
                     srcset="/assets/components/startpage/img/modx-logo@2x.png 2x">
            </a>
        </div>
    </div>
</footer>
{include 'file:chunks/_modal.tpl'}
</body>
</html>