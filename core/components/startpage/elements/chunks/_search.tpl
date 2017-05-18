<div class="search-wrapper">
    <div class="btn-group" role="group">
        <div id="dropdown-trigger" data-toggle="dropdown"></div>
        <div class="dropdown-menu">
            <div id="search-yandex" data-url="https://yandex.{$.en ? 'com' : 'ru'}/yandsearch" data-q="text" class="dropdown-item">
                {if $.en}
                    <span style="color:red;">Y</span><span style="color:black;">andex</span>
                {else}
                    <span style="color:red;">Я</span><span style="color:black;">ндекс</span>
                {/if}
            </div>
            <div id="search-google" data-url="{$.en ? 'https://www.google.com/search' : 'https://www.google.ru/search'}" data-q="q" class="dropdown-item">
                <span style="color:#3350c2;">G</span><span style="color:#d2162e;">o</span><span style="color:#db6e01;">o</span><span style="color:#3350c2;">g</span><span style="color:#008000;">l</span><span style="color:#d2162e;">e</span>
            </div>

            <div id="search-yahoo" data-url="https://{$.en ? '' : 'ru.'}search.yahoo.com/search" data-q="p" class="dropdown-item">
                <span style="color:#7b0099;">Yahoo!</span>
            </div>
            <div id="search-bing" data-url="http://www.bing.com/search" data-q="q" class="dropdown-item">
                <span style="color:#195fc3;">Bing</span>
            </div>

            <div id="search-mailru" data-url="https://go.mail.ru/search" data-q="q" class="dropdown-item">
                <span style="color:#db6e01;">@</span><span style="color:#00468c;">Mail</span><span style="color:#db6e01;">.ru</span>
            </div>
            <div id="search-rambler" data-url="https://nova.rambler.ru/search" data-q="query" class="dropdown-item">
                <span style="color:#00aeef;">Rambler</span>
            </div>
            <div id="search-wikipedia" data-url="{$.en ? 'https://en.wikipedia.org/wiki/Special:Search' : 'https://ru.wikipedia.org/wiki/Служебная:Search'}"
                 data-q="search" class="dropdown-item">
                <span style="color:#000;">{$.en ? 'Wikipedia' : 'Википедия'}</span>
            </div>
            <div id="search-imdb" data-url="http://www.imdb.com/find" data-q="q" class="dropdown-item">
                <span style="color:darkgoldenrod">imdb.com</span>
            </div>
            <div id="search-kinopoisk" data-url="https://www.kinopoisk.ru/index.php" data-q="kp_query" class="dropdown-item">
                <span style="color:#000;">КиноПоиск</span>
            </div>
        </div>
    </div>
    <form action="" method="get" class="external" id="search-form" target="_blank">
        <div class="input-group">
            <input name="" type="text" class="search form-control" autocomplete="new-password"
                   placeholder="{$.en ? 'Search...' : 'Поиск...'}">
            <button type="submit" class="input-group-addon alone"><i class="fa fa-search"></i></button>
            <button type="reset" class="input-group-addon hidden"><i class="fa fa-times"></i></button>
        </div>
    </form>
</div>