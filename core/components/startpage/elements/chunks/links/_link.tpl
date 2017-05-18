<div class="link {$link.screenshots ? 'image' : 'no-image'}" id="link-{$link.id}" data-id="{$link.id}">
    <div class="content">
        <a href="{$link.scheme}://{$link.link}" target="_blank">
            <div class="link-image">
                {if $link.screenshots}
                    <img src="/assets/screenshots/{$link.id}/small.jpg?{$link.updatedon | strtotime}"
                         srcset="/assets/screenshots/{$link.id}/small@2x.jpg?{$link.updatedon | strtotime} 2x">
                {/if}
            </div>
        </a>
        <div class="link-header">
            <span class="update fa fa-refresh"></span>
            <span class="remove fa fa-trash-o"></span>
        </div>
        <div class="link-footer">
            {$link.domain}
        </div>
        <div class="link-loading">
            <div class="fa fa-circle-o-notch fa-spin"></div>
        </div>
    </div>
</div>