@extends('errors::layout')

@section('title', __('Not Found'))
@section('img',asset('/storage/errors/404.jpg'))
@section('code', '404')
@section('message', __('Not Found'))
