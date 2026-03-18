@extends('errors::layout')

@section('title', 'Sistema en Manteninimiento')
@section('img', asset('storage/errors/503.jpg'))
@section('code', '¡Volveremos pronto! - 503')
@section('message')
    <p>Estamos realizando mejoras importantes en nuestro sistema. Disculpa las molestias,
        estamos trabajando para ofrecerte una mejor experiencia.</p>
    <p>Agradecemos tu paciencia y comprensión.</p>
@endsection
