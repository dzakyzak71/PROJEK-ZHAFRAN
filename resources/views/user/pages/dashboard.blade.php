@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Selamat Datang, {{ Auth::user()->name }}</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    @foreach($admins as $admin)
        @include('user.pages.components.admin-card', ['admin' => $admin])
    @endforeach
</div>
@endsection
