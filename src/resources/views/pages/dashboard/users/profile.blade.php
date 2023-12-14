@extends('layouts.dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h1 class="text-white h1 h1-responsive fw-light">Meu perfil de usuário</h1>
        </div>

        <div class="container">
            @if(session()->has('updated'))
                @if(session('updated'))
                    <div class="alert alert-success shadow-sm" role="alert">
                        <p class="m-0 fw-light">Perfil atualizado com sucesso</p>
                    </div>
                @else
                    <div class="alert alert-danger shadow-sm" role="alert">
                        <p class="m-0 fw-light">Erro ao atualizar o perfil</p>
                    </div>
                @endif
            @endif
            <form action="{{ route('dashboard.user.profile.update', $user->id) }}" method="post" class="">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Nome
                        </label>
                    </div>
                    <div class="col col-9">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Ex.: Maria de Almeida" value="{{ old('name', $user->name) }}" min="3" max="191">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> E-mail
                        </label>
                    </div>
                    <div class="col col-9">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Ex.: maria@email.com" value="{{ old('email', $user->email) }}" min="5" max="191">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Senha
                        </label>
                    </div>
                    <div class="col col-9">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••" min="6" max="191">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Confirmar senha
                        </label>
                    </div>
                    <div class="col col-9">
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="••••••" min="6" max="191">
                    </div>
                </div>

                @if($errors->any())
                    <div class="errors my-5">
                        @foreach($errors->all() as $key => $error)
                            <p class="ps-3 m-0 text-end fw-normal text-danger mb-2 w-100">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <footer class="text-end">
                    <button type="submit" class="btn btn-primary text-uppercase shadow-sm fw-medium">atualizar</button>
                </footer>
            </form>
        </div>
    </div>
@endsection

@section('css')
@endsection
