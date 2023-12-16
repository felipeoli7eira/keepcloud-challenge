@extends('layouts.dashboard')

@section('content')
    <div class="dashboard-page">
        @if(session()->has('updated'))
            @if(session('updated'))
                <div class="alert alert-success shadow-sm" role="alert">
                    <p class="m-0 fw-light">Dados atualizados com sucesso</p>
                </div>
            @else
                <div class="alert alert-danger shadow-sm" role="alert">
                    <p class="m-0 fw-light">Erro ao atualizar os dados</p>
                </div>
            @endif
        @endif

        @if(session()->has('address_created'))
            @if(session('address_created'))
                <div class="alert alert-success shadow-sm" role="alert">
                    <p class="m-0 fw-light">Endereço cadastrado</p>
                </div>
            @else
                <div class="alert alert-danger shadow-sm" role="alert">
                    <p class="m-0 fw-light">Erro ao cadastrar o endereço</p>
                </div>
            @endif
        @endif

        @if($errors->any())
            <div class="errors my-5">
                @foreach($errors->all() as $key => $error)
                    <p class="m-0 fw-normal text-danger mb-1 w-100">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h3 class="text-white h3 h3-responsive fw-light">Informações básicas</h3>
            <nav>
                <a
                    href="{{ route('dashboard.partner.list') }}"
                    class="btn btn-primary btn-md text-uppercase shadow-sm fw-medium">
                    voltar
                </a>
            </nav>
        </div>

        <div class="container">
            <form action="{{ route('dashboard.partner.update', $partner->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Nome
                        </label>
                    </div>
                    <div class="col col-9">
                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Ex.: Felipe Oliveira"
                            value="{{ old('name', $partner->name) }}"
                            required
                            min="3"
                            max="191"
                        />
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col col-3">
                        <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                            <span class="text-danger me-2">*</span> Tipo (selecione)
                        </label>
                    </div>
                    <div class="col col-9">
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" name="type" required>
                            <option @if($partner->type === 'silver') selected @endif value="silver">SILVER</option>
                            <option @if($partner->type === 'gold') selected @endif value="gold">GOLD</option>
                        </select>
                    </div>
                </div>

                <footer class="text-end">
                    <button type="submit" class="btn btn-primary text-uppercase shadow-sm fw-medium">atualizar</button>
                </footer>
            </form>
        </div>

        <div class="dashboard-page-title mb-5">
            <h3 class="text-white h3 h3-responsive fw-light">Endereços</h3>
        </div>

        <div class="container mb-5 d-flex gap-2">
            @foreach($partner->addresses as $arrayIndex => $address)
                <div class="card card-partner-address bg-dark shadow border border-dark">
                    <div class="card-body">
                        <p class="card-text mb-2 text-white">{{ $address->logradouro }}, {{ $address->numero }}</p>
                        <p class="card-text mb-2 text-white">Bairro: {{ $address->bairro }}</p>
                        <p class="m-0 card-title text-white mb-2">{{ $address->cidade }} - {{ $address->estado }}</p>
                        <p class="m-0 card-title text-white mb-2">{{ $address->cep }}</p>
                        @if($address->complemento)
                            <p class="card-subtitle mb-2 text-white mt-3">Complemento:</p>
                            <p class="card-subtitle mb-2 text-white">{{ $address->complemento }}</p>
                        @endif
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('dashboard.address.destroy', $address->id) }}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="button" class="btn btn-sm p-0" onclick="confirmDeleteAddress({{ json_encode($address) }}, this)">
                                <img src="{{ asset('svg/trash.svg') }}" alt="Lixeira" width="15">
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h3 class="text-white h3 h3-responsive fw-light">Cadastro de endereço</h3>
        </div>

        <form class="container" method="post" action="{{ route('dashboard.address.store') }}" novalidate>
            @csrf
            <input type="hidden" name="partner_id" value="{{ request('id') }}">

            <div class="row mb-3">
                <div class="col col-3">
                    <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                        <span class="text-danger me-2">*</span> CEP (apenas números)
                    </label>
                </div>
                <div class="col col-9">
                    <input
                        onkeyup="getCEPData(this)"
                        type="text"
                        name="cep"
                        class="form-control @error('cep') is-invalid @enderror"
                        placeholder="Ex.: 05440000"
                        required
                        minlength="8"
                        maxlength="8"
                        value="{{ old('cep', '') }}"
                    />
                    <span class="text-white fw-light mt-1 span-cep-info">Pesquisando informações do CEP...</span>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col col-3">
                    <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                        <span class="text-danger me-2">*</span> Número
                    </label>
                </div>
                <div class="col col-9">
                    <input
                        type="text"
                        name="numero"
                        class="form-control @error('numero') is-invalid @enderror"
                        required
                        minlength="1"
                        maxlength="191"
                        value="{{ old('numero', '') }}"
                    />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col col-3">
                    <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                        <span class="text-danger me-2">*</span> Logradouro
                    </label>
                </div>
                <div class="col col-9">
                    <input
                        type="text"
                        name="logradouro"
                        class="form-control @error('logradouro') is-invalid @enderror"
                        required
                        minlength="1"
                        maxlength="191"
                        value="{{ old('logradouro', '') }}"
                    />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col col-3">
                    <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                        <span class="text-danger me-2">*</span> Bairo
                    </label>
                </div>
                <div class="col col-9">
                    <input
                        type="text"
                        name="bairro"
                        class="form-control @error('bairro') is-invalid @enderror"
                        required
                        minlength="1"
                        maxlength="191"
                        value="{{ old('bairro', '') }}"
                    />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col col-3">
                    <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                        <span class="text-danger me-2">*</span> Cidade
                    </label>
                </div>
                <div class="col col-9">
                    <input
                        type="text"
                        name="cidade"
                        class="form-control @error('cidade') is-invalid @enderror"
                        required
                        minlength="1"
                        maxlength="191"
                        value="{{ old('cidade', '') }}"
                    />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col col-3">
                    <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                        <span class="text-danger me-2">*</span> UF
                    </label>
                </div>
                <div class="col col-9">
                    <select name="uf" id="uf" class="form-control @error('uf') is-invalid @enderror" name="type" required>
                        @foreach($ufs as $uf)
                            <option value="{{ $uf }}">{{ $uf }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col col-3">
                    <label for="" class="m-0 text-white h-100 d-flex flex-col align-items-center">
                        <span class="text-danger me-2">*</span> Complemento
                    </label>
                </div>
                <div class="col col-9">
                    <input
                        type="text"
                        name="complemento"
                        class="form-control @error('complemento') is-invalid @enderror"
                        maxlength="50"
                        value="{{ old('complemento', '') }}"
                    />
                </div>
            </div>

            <footer class="text-end">
                <button type="submit" class="btn btn-primary text-uppercase shadow-sm fw-medium">cadastrar</button>
            </footer>
        </form>
    </div>
@endsection

@section('css')
    <style>
        span.span-cep-info {
            display: none;
        }

        .card-partner-address {
            min-width: 20rem;
        }
    </style>
@endsection

@section('script')
    <script defer>

        const VIA_CEP_API_URL = 'https://viacep.com.br/ws/';

        const setCepQueryFeedback = (display) => {
            const cepQueryFeedback = document.querySelector('span.span-cep-info');
            cepQueryFeedback.style.display = display;
        };

        const queryCep = async (cepNumber) => {
            try
            {
                const request = await fetch(VIA_CEP_API_URL.concat(cepNumber, '/json'));

                if (!request.ok) return false;

                const response = await request.json();

                return response;
            }
            catch (error)
            {
                console.log(error);
                return false;
            }
        };

        const getCEPData = async (context) => {
            setCepQueryFeedback('none');

            if (context.value.length === 8) {

                setCepQueryFeedback('block');
                const request = await queryCep(context.value.trim());
                setCepQueryFeedback('none');

                if (request === false) {
                    alert('Erro ao preencher os dados de endereço automaticamente. Por favor, preencha manualmente.');
                    return false;
                }

                fillAddressInputs(request);
            }
        };

        const fillAddressInputs = (data) => {
            document.querySelector('[name=cidade]').value = data.localidade;
            document.querySelector('[name=logradouro]').value = data.logradouro;
            document.querySelector('[name=bairro]').value = data.bairro;

            const ufsOptions = document.querySelector('[name=uf]').options;
            Array.from(ufsOptions).map(option => {
                if (option.value === data.uf) {
                    option.selected = true;
                }
            });
        };
    </script>

    <script defer>
        function confirmDeleteAddress(address, context)
        {
            console.log(address)

            const comfirmed = window.confirm('Continuar para a deleção do endereço em '.concat(address.logradouro, ' - ', address.cidade, '?'))

            if (comfirmed) {
                context.type = 'submit';
                console.dir(context.type)
            }
        }

        function teste() {
            console.log('..')
        }
    </script>
@endsection
