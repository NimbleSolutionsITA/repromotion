@if($cookieConsentConfig['enabled'] && ! $alreadyConsentedWithCookies)

    @include('cookieConsent::dialogContents')

    <script>

        window.laravelCookieConsent = (function () {

            var COOKIE_VALUE = 1;

            function consentWithCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', COOKIE_VALUE, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                var dialogs = document.getElementsByClassName('js-cookie-consent');

                for (var i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = 'none';
                }
            }

            function setCookie(name, value, expirationInDays) {
                var date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value + '; ' + 'expires=' + date.toUTCString() +';path=/{{ config('session.secure') ? ';secure' : null }}';
            }

            if(cookieExists('{{ $cookieConsentConfig['cookie_name'] }}')) {
                hideCookieDialog();
            }

            var buttons = document.getElementsByClassName('js-cookie-consent-agree');

            for (var i = 0; i < buttons.length; ++i) {
                buttons[i].addEventListener('click', consentWithCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

    <style>
        .js-cookie-consent.cookie-consent {
            width: 100%;
            height: 100%;
            position: absolute;
            background: rgba(0, 0, 0, 0.75);
            z-index: 99999;
        }
        .message-box {
            margin: 10% auto;
            background-color: #359a47;
            width: 50%;
            padding: 5%;
            border-radius: 10px;
            color: white;
            text-align: justify;
            -moz-text-align-last: center;
            text-align-last: center;
            background-image: url(../images/weed-leave-pattern-white.png);
            background-repeat: repeat;
            box-shadow: 0px 2px 120px 60px #0000007a;
        }

        .message-box button#consent {
            background-color: #ffffff;
            color: #369a47;
        }
        .message-box button#consent[disabled] {
            color: #eeeeee;
            opacity: .75;
        }
        .message-box button#consent:hover {
            color: #000000;
            transition: color 3ms;
        }
        .message-box button#consent[disabled]:hover {
            color: #eeeeee;
            transition: none;
        }
        .message-box a {
            color: white;
            text-decoration: underline;
        }
        .message-box a:hover {
            color: black;
            font-weight: bold;
            transition: color 3ms;
        }
        .message-box img {
            width: 150px;
            margin-bottom: 20px;
        }
        @media (max-width: 1000px) {
            .message-box {
                width: 90%;
                margin: 20% auto;
            }

        }
    </style>

@endif
