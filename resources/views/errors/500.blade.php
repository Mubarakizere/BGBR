@extends('errors.layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Internal Server Error'))
@section('description', __('Whoops, something went wrong on our servers. We are looking into it.'))
