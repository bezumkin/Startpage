<form action="link/create" method="post" id="new-link-form">
    <div class="input-group">
        <input type="text" name="link" class="form-control" id="new-link-form-input"
               placeholder="{$.en ? 'Link to a website' : 'Ссылка на веб-сайт'}">
        <button type="submit" class="input-group-addon alone"><i class="fa fa-check"></i></button>
    </div>
    <small>
        {if $.en}
            Provide a link to a website and it will be added to your home page after checking.
        {else}
            Укажите ссылку на веб-сайт и он будет добавлен на страницу после проверки.
        {/if}
    </small>
</form>