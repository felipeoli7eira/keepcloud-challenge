@extends('layouts.app', ['page_title' => 'Laravel App'])

@section('content')
<div class="login-form d-flex flex-column align-items-center justify-content-center h-100 bg-light">
    <form class="d-flex flex-column align-items-center" method="POST" action="{{ route('login') }}">
        @csrf

        <img src="{{ asset('svg/laravel-black.svg') }}" class="d-inline-block mb-4" width="200px">

        <div class="d-flex align-items-center mb-2 border p-1 px-4 bg-body rounded-pill">
            <img src="{{ asset('svg/user.svg') }}">
            <input
                name="email"
                class="form-control border-0 bg-none shadow-none @error('email') is-invalid @enderror"
                min="6"
                max="191"
                autofocus
                type="email"
                autocomplete="email"
                placeholder="E-mail"
                value="{{ old('email') }}"
            />
        </div>

        <div class="d-flex align-items-center mb-2 border p-1 px-4 bg-body rounded-pill">
            <img src="{{ asset('svg/lock.svg') }}">
            <input
                name="password"
                id="password"
                class="form-control border-0 bg-none shadow-none @error('password') is-invalid @enderror"
                min="6"
                max="191"
                type="password"
                placeholder="••••••"
                autocomplete="current-password"
            />
        </div>

        @if($errors->any())
            <p class="ps-3 m-0 fw-light text-center text-danger mb-2 w-100">Dados incorretos ou usuário não encontrado</p>
        @endif

        <div class="d-grid w-100 mt-5">
            <button class="btn btn-dark rounded-pill p-2 fw-bold shadow-sm" type="submit">LOGIN</button>
        </div>
    </form>
</div>
@endsection

@section('css')
<style>
    .form-control
    {
        background-color: #fff !important;
        color: #1f1f1f !important;
    }

    .form-control::placeholder
    {
        color: rgba(41, 41, 41, 0.671) !important
    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus,
    input:-webkit-autofill:active{
        background-color: #fff
    }
</style>
@endsection
