
<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">
            Меню
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>
    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    @foreach($menu as $value)
                    <li {!! (Route::currentRouteName() == $value['route']) ? 'class="nav-active"' : '' !!}>
                        <a href="{{route($value['route'])}}" {!! (!empty($value['l-access'])) ? $value['l-access']: '' !!}>
                            <i class="{!! $value{'class'} !!}" aria-hidden="true"></i>
                            <span>{!! $value{'title'} !!}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </nav>
        </div>
    </div>
</aside>