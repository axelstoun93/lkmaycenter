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
                <h2 class="title text-uppercase text-weight-bold m-none"><i class="fa fa-user mr-xs"></i>Вход</h2>
            </div>
            <div class="panel-body">
               @if(!empty($errors->has('name')))
                <div class="alert alert-danger">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ $errors->first('name') }}
                </div>
                @endif
                <form action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group mb-lg">
                        <label>Логин</label>
                        <div class="input-group input-group-icon">
                            <input name="name" type="text" class="form-control input-lg" value="{{old('name')}}" required />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
                        </div>
                    </div>
                    <div class="form-group mb-lg">
                        <div class="clearfix">
                            <label class="pull-left">Пароль</label>
                            <a href="{{ route('password.request') }}" class="pull-right"  >Забыли пароль ?</a>
                        </div>
                        <div class="input-group input-group-icon">
                            <input name="password" type="password" class="form-control input-lg" required />
									<span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="checkbox-custom checkbox-default">
                                <input id="RememberMe"  type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}/>
                                <label for="RememberMe">Запомнить</label>
                            </div>
                        </div>
                        <div class="col-sm-4 text-right">
                            <button type="submit" class="btn btn-primary hidden-xs">Вход</button>
                            <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Вход</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- end: page -->
@endsection