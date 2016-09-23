<div class="media user-media bg-dark dker">
    <div class="user-media-toggleHover">
        <span class="fa fa-user"></span>
    </div>
    <div class="user-wrapper bg-dark">
        <a class="user-link" href="{{ route('user_profile.resume') }}">
            <img class="media-object img-thumbnail user-img" alt="User Picture"  width="64px" src="
                @if(Auth::user()->hasProfileImage())
                    {{ route('user_profile.image') }}
                @else
                    {{ asset('assets/img/user.gif') }}
                @endif
            ">
            {{--<span class="label label-danger user-label">16</span>--}}
        </a>
        <div class="media-body">
            <h5 class="media-heading">{{ Auth::user()->completeName }}</h5>
            <ul class="list-unstyled user-info">
                <li>{{ trans('general.'.Auth::user()->role) }}</li>
                <li>Último acceso:
                    <br>
                    <small>
                        <i class="fa fa-calendar"></i>
                        &nbsp;{{ Auth::user()->updated_at->format('d M - H:i') }}
                    </small>
                </li>
            </ul>
        </div>
    </div>
</div>