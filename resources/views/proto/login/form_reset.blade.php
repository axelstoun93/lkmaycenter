@extends(env('THEME').'.layouts.site_login')
@section('content')
        <!-- start: page -->
<section class="body-sign">
    <div class="center-sign">
        <a href="/" class="logo pull-left">
            <img src="{{asset(env('THEME'))}}/assets/images/logo.png" height="54" alt="Porto Admin" />
        </a>
        <div class="panel panel-sign">
            <div class="panel-title-sign mt-xl text-right">
                <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i>Восстановление пароля</h2>
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                        </div>
                    @endif
                    @if ($errors->has('password'))
                        <div class="alert alert-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                <form method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group mb-lg">
                        <label>E-mail адресс</label>
                        <input name="email" type="email" class="form-control input-lg" required />
                    </div>
                    <div class="form-group mb-none">
                        <div class="row">
                            <div class="col-sm-6 mb-lg">
                                <label>Пароль</label>
                                <input name="password" type="password" class="form-control input-lg" required />
                            </div>
                            <div class="col-sm-6 mb-lg">
                                <label>Подтвердите пароль</label>
                                <input name="password_confirmation" type="password" class="form-control input-lg" required/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="checkbox-custom checkbox-default">
                                <input id="AgreeTerms" name="agreeterms" type="checkbox"/>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <button type="submit" class="btn btn-primary hidden-xs">Сменить</button>
                            <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Сменить</button>
                        </div>
                    </div>
                    <p class="text-center mt-lg">Вспомнили? <a href="{{route('login')}}">Вход!</a>
                </form>
            </div>
        </div>
        <p class="text-center text-muted mt-md mb-md">&copy; Copyright 2014. All Rights Reserved.</p>
    </div>
</section>
<!-- end: page -->

@endsection