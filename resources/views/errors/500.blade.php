@extends('errors::layout')

@section('title', __('Server Error'))
@section('img', asset('storage/errors/500.jpg'))
@section('code', '500')
@section('message', __('Server Error'))
