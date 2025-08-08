@extends('layouts.user')

@section('title', 'Ubah Profil')

@section('content')
<h1 class="text-2xl font-semibold mb-4">Ubah Profil</h1>

@include('user.pages.components.profil-form', ['user' => $user])
@endsection
