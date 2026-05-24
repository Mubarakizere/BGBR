@extends('errors.layout')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __('Access Forbidden'))
@section('description', __('Sorry, you are not authorized to access this page.'))
