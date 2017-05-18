<a href="#profile" class="profile">
    {if $photo != ''}
        <img src="{$photo}" alt="" title="" class="avatar"/>
    {else}
        <img src="{$gravatar}?s=50&d=mm" srcset="{$gravatar}?s=100&d=mm 2x" alt="" title="" class="avatar"/>
    {/if}
    <span class="fullname">{$fullname}</span>
</a>
<a href="{$logout_url}" class="logout" title="{$.en ? 'Logout' : 'Выход'}"><i class="fa fa-sign-out ">&nbsp;</i></a>