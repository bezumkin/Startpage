<div id="links-header">
    <div id="search">
        {include 'file:chunks/_search.tpl'}
    </div>
    <div id="weather">
        {*include 'file:chunks/_weather.tpl'*}
    </div>
</div>
<div id="links">
    {foreach $links as $link}
        {include 'file:chunks/links/_link.tpl' link=$link}
    {/foreach}
    <div class="link new" id="new-link">
        <a href="#add">
            <div class="content">
                <i class="fa fa-plus-circle "></i>
            </div>
        </a>
    </div>
</div>