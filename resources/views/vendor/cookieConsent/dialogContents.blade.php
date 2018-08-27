<div class="js-cookie-consent cookie-consent">

    <div class="message-box">

        <img src="/images/logo-1color-white.png" alt="">

        <span class="cookie-consent__message">
            {!! trans('cookieConsent::texts.message') !!}
        </span>

        <br>

        <a href="{{ route('cookie-policy') }}"><i>Visualizza l'informativa sui cookies</i></a>

        <br>

        <h6 style="text-transform: uppercase;">{!! trans('cookieConsent::texts.age') !!} <input type="checkbox"  onchange="document.getElementById('consent').disabled = !this.checked;" /></h6>

        <br>

        <button class="js-cookie-consent-agree cookie-consent__agree" id="consent" disabled>
            {{ trans('cookieConsent::texts.agree') }}
        </button>

    </div>

</div>