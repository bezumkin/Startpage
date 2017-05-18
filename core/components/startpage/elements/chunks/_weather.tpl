<div class="weather-wrapper">
    <div id="city-trigger">{$weather.geo_object.locality.name}</div>

    {if $weather?}
        <div class="temp">
            {if $weather.fact.temp > 0}
                {set $weather.fact.temp = '+' ~ $weather.fact.temp}
            {/if}
            {$weather.fact.temp} °C
        </div>
        <div class="img" style="background:url({$weather.fact.icon})"></div>
        <div class="update fa fa-refresh" id="weather-update" data-id="{$weather.geo_object.locality.id}"></div>
        <div class="details">
            <div>{$.en ? 'Pressure' : 'Давление'}: {$weather.fact.pressure_mm} {$.en ? 'mmHg' : 'мм рт. ст.'}</div>
            <div>{$.en ? 'Humidity' : 'Влажность'}: {$weather.fact.humidity} %</div>
        </div>
        <div class="link">
            {if $.en}
                <div>Wind: {$weather.fact.wind_speed} m/s {$weather.fact.wind_dir | strtoupper}</div>
                <div>
                    <a href="https://yandex.com/pogoda/{$weather.info.slug}/details" target="_blank">
                        Detailed forecast &rarr;
                    </a>
                </div>
            {else}
                <div>Ветер: {$weather.fact.wind_speed} м/с {$weather.fact.wind_dir}</div>
                <div>
                    <a href="https://yandex.ru/pogoda/{$weather.info.slug}/details" target="_blank">
                        Подробный прогноз &rarr;
                    </a>
                </div>
            {/if}
        </div>
    {/if}
</div>
<form action="weather/select" method="post" id="city-form" class="hidden">
    <div class="input-group">
        <input name="city" type="text" class="form-control" autocomplete="new-password"
               id="city-form-input"
               placeholder="{$.en ? 'Specify your city' : 'Укажите свой город'}">
        <button type="submit" class="input-group-addon"><i class="fa fa-check"></i></button>
        <button type="reset" class="input-group-addon"><i class="fa fa-times"></i></button>
    </div>
</form>
