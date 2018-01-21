<div class="header-right">
<div id="userbox" class="userbox">
    <a href="#" data-toggle="dropdown">
        <figure class="profile-picture">
            <img src="{{asset(env('THEME'))}}/assets/images/manager-36.png" class="img-circle"  />
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