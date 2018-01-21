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
                <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i>Восстановить пароль</h2>
            </div>
            <div class="panel-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <p class="m-none text-weight-semibold h6">Введите свой адрес электронной почты, и мы отправим вам инструкции по восстановлению пароля!</p>
                    </div>
                @endif
                <form action="{{ route('password.email') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group mb-none">
                        <div class="input-group">
                            <input name="email" type="email" placeholder="E-mail" class="form-control input-lg" />
									<span class="input-group-btn">
										<button class="btn btn-primary btn-lg" type="submit">Далее!</button>
									</span>
                        </div>
                    </div>
                    <p class="text-center mt-lg">Вспомнили? <a href="{{route('login')}}">Вход!</a>
                </form>
            </div>
        </div>

       
    </div>
</section>
<!-- end: page -->


@endsection