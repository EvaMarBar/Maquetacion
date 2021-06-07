<header class="header-fixed fixed">

    <div class="header-container">
        <div class="header-logo">
            @isset($logo->path)
                <a href="/"><img src="{{Storage::url($logo->path)}}"></a>
            @endisset
        </div>

        <div class="header-menu">
            {{display_menu('Principal','horizontal')}}

            <div class="booking-button">
                <button>
                    @lang('front/header.shop')
                </button>
            </div>
        </div>

    </div>

</header>

<div class="header-checkpoint"></div>
