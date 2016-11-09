@extends('layouts.email')
@section('content')
    · Usuario: {{ $user->email }}
    <br>
    · Contraseña: {{ $user->password }}
@endsection