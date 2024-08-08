@extends('layouts.customers.customers')

@section('content')
    @include('components.customers.home.carousel')
    @include('components.customers.home.categories')
    @include('components.customers.global.promotionalSec')
    @include('components.customers.home.productList')
@endsection
