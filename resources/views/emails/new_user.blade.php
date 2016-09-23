@lang('email.reset_text')
<br>
<div class="text-center">
    Bienvenido al software de almacenes de la empresa Alcruz Canarias SL. Estos son los datos de acceso:
    <ul>
        <li>
            Acceso: <a href="{{ $link = url(env('APP_URL')) }}"> {{ $link }} </a>
        </li>
        <li>
            Usuario: {{ $user->email }}
        </li>
        <li>
            Contraseña: {{ $user->password }}
        </li>
    </ul>
</div>