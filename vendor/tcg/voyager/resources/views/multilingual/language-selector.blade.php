@if (isset($isModelTranslatable) && $isModelTranslatable)
    <div class="language-selector">
        <div class="btn-group btn-group-sm" role="group" data-toggle="buttons" style="border: 2px solid #0074c7;border-radius: 20px;box-shadow: inset 0px 0px 8px 0px #0074c7;">
            @foreach(config('voyager.multilingual.locales') as $lang)
                <label class="btn btn-lang {{ ($lang === config('voyager.multilingual.default')) ? " active" : "" }}"
                style="color:black;">
                    <input type="radio" name="i18n_selector" id="{{$lang}}"
                           autocomplete="off"{{ ($lang === config('voyager.multilingual.default')) ? ' checked="checked"' : '' }}>
                    <img src="{{asset('flags')}}/{{strtolower($lang)}}.png"> {{ strtoupper($lang) }}
                </label>
            @endforeach
        </div>
    </div>
@endif
