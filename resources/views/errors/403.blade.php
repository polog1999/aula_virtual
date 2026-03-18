@extends('errors::layout')

@section('title', __('Forbidden'))
@section('img',asset('/storage/errors/403.avif'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
