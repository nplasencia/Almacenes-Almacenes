<!-- #menu -->
<ul id="menu" class="bg-dark dker">
    <li class="nav-divider"></li>

    @foreach($items as $routeName => $values)
        <li class="">
            <a href="{{ route($values['link']) }}">
                <i class="{{ $values['icon'] }}"></i>
                <span class="link-title">&nbsp; @lang($routeName)</span>
            </a>
        </li>
    @endforeach

    <li class="nav-divider"></li>
    <li>
        <a href="{{ route('user_profile.resume') }}">
            <i class="fa fa-edit"></i>
            <span class="link-title">&nbsp; @lang('menu.user_profile')</span>
        </a>
    </li>
    @can('admin')
        <li>
            <a href="{{ route('users.resume') }}">
                <i class="fa fa-users"></i>
                <span class="link-title">&nbsp; @lang('menu.users')</span>
            </a>
        </li>
    @endcan

</ul><!-- /#menu -->