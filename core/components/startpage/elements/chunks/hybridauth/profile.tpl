<form action="profile/update" method="post" id="profile-form">
    <div class="form-group">
        <label for="profile-fullname">{$.en ? 'Your name' : 'Ваше имя'}</label>
        <input type="text" name="fullname" class="form-control" id="profile-fullname" value="{$profile.fullname}">
    </div>
    <div class="form-group">
        <label for="profile-avatar">{$.en ? 'Link to the avatar' : 'Ссылка на аватар'}</label>
        <input type="url" name="avatar" class="form-control" id="profile-avatar" value="{$profile.photo}">
        <small>
            {if $.en}
                Avatars by default are loaded with <a href="https://gravatar.com" target="_blank">Gravatar</a>,
                using your email from social networks. But you can specify your own link.
            {else}
                Аватарки по умолчанию загружаются с <a href="https://gravatar.com" target="_blank">Gravatar</a>,
                используя ваш email из соцсетей. Но вы можете указать и свою ссылку вручную.
            {/if}
        </small>
    </div>

    <div class="buttons">
        <button type="submit" class="btn btn-outline-primary">{$.en ? 'Save' : 'Сохранить'}</button>
        <button class="btn btn-outline-secondary" data-dismiss="modal">{$.en ? 'Cancel' : 'Отмены'}</button>
    </div>
</form>

<label for="fullname">{$.en ? 'Log in via a social network' : 'Вход через соц.сети'}</label>
<div class="providers">
    {$providers}
</div>
<small>
    {if $.en}
        Here you can connect or disconnect your social network for authorization.
    {else}
        Здесь вы можете подключить или отключить ваши соц.сети для авторизации.
    {/if}
</small>