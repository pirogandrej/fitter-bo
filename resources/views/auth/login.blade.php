@extends('auth.template')

@section('content')

<form class="form-horizontal" method="POST" action="{{ route('login') }}">

    {{ csrf_field() }}

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="https://colorlib.com/etc/lf/Login_v1/images/img-01.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" autocomplete="off">
					<span class="login100-form-title">
						ВХОД МОНТАЖНИКА
					</span>

                    <div class="wrap-input100 validate-input" data-validate = "Валидный email обязателен: ex@abc.xyz">

                        <input class="input100" type="text" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="off">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif

                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate = "Пароль обязателен">

                        <input class="input100" type="password" name="password" placeholder="Пароль" autocomplete="off">

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif

                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            ВОЙТИ
                        </button>
                    </div>

                    <div class="text-center p-t-12">
						<span class="txt1">
							Восстановить
						</span>
                        <a class="txt2" href="#">
                            Логин / Пароль?
                        </a>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="#">
                            Создать аккаунт
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</form>
@endsection
