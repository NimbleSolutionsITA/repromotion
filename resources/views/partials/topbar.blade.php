<!-- topBar section -->
<div class="xs-top-bar d-none d-md-none d-lg-block">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-lg-12">
                        <span style="color: #555555; font-size: .92857143em;"><b>Hai bisogno di aiuto? scrivi a <a href="mailto:ordini@aurorapromotion.it">ordini@aurorapromotion.it</a> o chiama il 333 9523601 </b></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <ul class="xs-top-bar-info right-content">
                    <li>
                        <a href="{{ route('terms-and-conditions') }}">Info spedizioni e resi</a>
                    </li>
                    @auth
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" style="background: none; border: none; font-size: 0.92857143em; color: #074e99;">logout {{ Auth::user()->name }}</button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li><a href="{{ route('login') }}" data-toggle="modal" data-target=".xs-modal">Accedi</a></li>
                    @endguest
                </ul><!-- .xs-top-bar-info END -->
            </div>
        </div><!-- .row END -->
    </div><!-- .container END -->
</div>

<!-- xs modal -->
<div class="modal xs-modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span class="icon icon-cross"></span>
            </button>
            <ul class="nav nav-tabs xs-tab-nav" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#login" role="tab" data-toggle="tab">
                        Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#signup" role="tab" data-toggle="tab">
                        Registrati
                    </a>
                </li>
            </ul><!-- xs-tab-nav -->
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fadeInRights show fade in active" id="login">
                    <form method="POST" action="{{ route('login') }}" class="xs-customer-form">
                        @csrf
                        <div class="input-group input-group-append">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif

                            <i class="icon icon-profile-male input-group-text"></i>
                        </div>
                        <div class="input-group input-group-append">
                            <input placeholder="{{ __('Password') }}" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                            <i class="icon icon-key2 input-group-text"></i>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                    </form><!-- .xs-customer-form END -->
                </div><!-- tab-pane #login -->
                <div role="tabpanel" class="tab-pane fadeInRights fade" id="signup">
                    <form method="POST" action="{{ route('register') }}" class="xs-customer-form">
                        @csrf
                        <div class="input-group input-group-append">
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="{{ __('Name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                            @endif
                            <i class="icon icon-profile-male input-group-text"></i>
                        </div>
                        <div class="input-group input-group-append">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="{{ __('E-Mail Address') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                            @endif
                            <i class="icon icon-envelope2 input-group-text"></i>
                        </div>
                        <div class="input-group input-group-append">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                            <i class="icon icon-key2 input-group-text"></i>
                        </div>
                        <div class="input-group input-group-append">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                            <i class="icon icon-key2 input-group-text"></i>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
                    </form><!-- .xs-customer-form END -->
                </div><!-- tab-pane #signup -->
            </div><!-- tab-content -->
        </div>
    </div>
</div><!-- End xs modal --><!-- End topBar section -->