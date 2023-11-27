@extends('voyager::auth.master')

@section('content')
    <div class="login-container">

        <p>{{ __('messages.reset_password') }}</p>

        <form action="{{ route('voyager.postreset_password') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group form-group-default" id="emailGroup">
                <label>{{ __('messages.Enter your email') }}</label>
                <div class="controls">
                    <input type="text" name="email" id="email" value="{{ old('email')?old('email'):request()->get('email') }}"
                           placeholder="{{ __('voyager::generic.email') }}" class="form-control" required>
                </div>
            </div>
            <div class="form-group form-group-default" id="emailGroup">
                <label>{{ __('messages.Enter The Token') }}</label>
                <div class="controls">
                    <input type="text" name="code" id="code"
                           class="form-control" required>
                </div>
            </div>
            <div class="form-group form-group-default" id="emailGroup">
                <label>{{ __('messages.Enter The Password') }}</label>
                <div class="controls">
                    <input type="password" name="password" id="password"
                           class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-block login-button">
                <span class="signingin hidden"><span class="voyager-refresh"></span> {{ __('messages.submit') }}...</span>
                <span class="signin">{{ __('messages.submit') }}</span>
            </button>

        </form>

        <div style="clear:both"></div>

        @if(!$errors->isEmpty())
            <div class="alert alert-red">
                <ul class="list-unstyled">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div> <!-- .login-container -->
@endsection

@section('post_js')

    <script>
        var btn = document.querySelector('button[type="submit"]');
        var form = document.forms[0];
        var email = document.querySelector('[name="email"]');
        var password = document.querySelector('[name="password"]');
        btn.addEventListener('click', function (ev) {
            if (form.checkValidity()) {
                btn.querySelector('.signingin').className = 'signingin';
                btn.querySelector('.signin').className = 'signin hidden';
            } else {
                ev.preventDefault();
            }
        });
        email.focus();
        document.getElementById('emailGroup').classList.add("focused");

        // Focus events for email and password fields
        email.addEventListener('focusin', function (e) {
            document.getElementById('emailGroup').classList.add("focused");
        });
        email.addEventListener('focusout', function (e) {
            document.getElementById('emailGroup').classList.remove("focused");
        });

        password.addEventListener('focusin', function (e) {
            document.getElementById('passwordGroup').classList.add("focused");
        });
        password.addEventListener('focusout', function (e) {
            document.getElementById('passwordGroup').classList.remove("focused");
        });

    </script>
@endsection
