@extends('layout.app')

@section('content')
<div class="container my-5">
    <div class="recommended-section my-5">
        <h2 class="fw-bolder mb-4">Recommended For You</h2>
        <x-carousel :books="$recommendedBooks" :wishlistBookIds="$wishlistBookIds" />
    </div>
    <div class="affordable-section my-5">
        <h2 class="fw-bolder mb-4">Under Rp 100.000</h2>
        <x-carousel :books="$affordableBooks" :wishlistBookIds="$wishlistBookIds" />
    </div>
</div>
@endsection