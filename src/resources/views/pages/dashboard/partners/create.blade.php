@extends('layouts.dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h1 class="text-white h1 h1-responsive fw-light">Cadastro de sócio</h1>
            <nav>
                <a href="{{ route('dashboard.partner.list') }}" class="btn btn-primary btn-md text-uppercase shadow-sm fw-medium">voltar</a>
            </nav>
        </div>

        <div class="container">
            <form action="{{ route('dashboard.partner.store') }}" method="post" class="" novalidate>
                @csrf

                <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Nome
                        </label>
                    </div>
                    <div class="col col-9">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Ex.: Felipe Oliveira" value="{{ old('name') }}" required min="3" max="191">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Tipo
                        </label>
                    </div>
                    <div class="col col-9">
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" name="type" required>
                            <option selected value="silver">SILVER</option>
                            <option value="gold">👑 GOLD</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Senha
                        </label>
                    </div>
                    <div class="col col-9">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="******" required min="6" max="191" value="">
                    </div>
                </div> --}}
                {{-- <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Repetir senha
                        </label>
                    </div>
                    <div class="col col-9">
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="******" required min="6" max="191" value="">
                    </div>
                </div> --}}
                {{-- <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Papel
                        </label>
                    </div>
                    <div class="col col-9">
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                            @foreach($user_roles as $index => $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div> --}}

                @if($errors->any())
                    <div class="errors my-5">
                        @foreach($errors->all() as $key => $error)
                            <p class="ps-3 m-0 text-end fw-normal text-danger mb-2 w-100">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <footer class="text-end">
                    <button type="submit" class="btn btn-primary text-uppercase shadow-sm fw-medium">cadastrar</button>
                </footer>
            </form>
        </div>
    </div>
@endsection

@section('css')
@endsection
