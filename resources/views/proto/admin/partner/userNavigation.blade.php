<div class="header-right">
    @if(!empty($userInfo->day))
    <span class="separator"></span>

    <ul class="notifications">

        <li>
            <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                <i class="fa fa-calendar"></i>
                <span class="badge">{!! $userInfo->day !!}</span>
            </a>

            <div class="dropdown-menu notification-menu">
                <div class="notification-title">
                    <span class="pull-right label label-default">{!! $userInfo->day !!}</span>
                    У вас осталось
                </div>

                <div class="content">
                    <ul>
                      <li>
                          <span class="message">дней до блокировки аккаунта.</span>
                      </li>
                    </ul>
                </div>

            </div>
        </li>
        <li>
            <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                <i class="fa fa-bell"></i>
                @if(!empty($alert))
                <span class="badge">{{count($alert)}}</span>
                @endif
            </a>
            @if(!empty($alert))
            <div class="dropdown-menu notification-menu">

                <div class="notification-title">
                    <span class="pull-right label label-default">{{count($alert)}}</span>
                    Оповещения
                </div>

                <div class="content">
                    <ul>
                        @if(!empty($alert))
                            @foreach($alert as $value)
                        <li>
                            <a href="{{(!empty($value->href)) ? $value->href : '' }}" class="clearfix">
                                <div class="image">
                                    <i class="{{$value->image}}"></i>
                                </div>
                                <span class="title">{{$value->title}}</span>
                                <span class="message">{!! $value->message !!}</span>
                            </a>
                        </li>
                            @endforeach
                            @endif
                    </ul>
                </div>
            </div>
            @endif
        </li>
    </ul>

    <span class="separator"></span>
    @endif
<div id="userbox" class="userbox">
    <a href="#" data-toggle="dropdown">
        <figure class="profile-picture">
            <img src="{{asset(env('THEME'))}}/images/partners/icons/partner-36.png"  class="img-circle"  />
        </figure>
        @if(!empty($userInfo))
        <div class="profile-info">
            <span class="name">{!! $userInfo->name!!}</span>
            <span class="role">{!! $userInfo->role !!}</span>
        </div>
         @else
            <div class="profile-info">
                <span class="name">Не удалось получить данные о пользователе</span>
            </div>
          @endif
        <i class="fa custom-caret"></i>
    </a>
    <div class="dropdown-menu">
        <ul class="list-unstyled">
            <li class="divider"></li>
            @if(!empty($userMenu))
            @foreach($userMenu as $key => $value)
                <li>
                 <a role="menuitem" tabindex="-1" href="{{ route($value['route'])}}"><i class="{!! $value['class'] !!}"></i> {!! $value['title'] !!}</a>
                </li>
            @endforeach
            @endif
            <li>
                <a role="menuitem" tabindex="-1" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Выход</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</div>
</div>