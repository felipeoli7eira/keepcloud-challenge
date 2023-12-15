@extends('layouts.dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h1 class="text-white h1 h1-responsive fw-light">Atualização de dados</h1>
            <nav>
                <a href="{{ route('dashboard.partner.list') }}" class="btn btn-primary btn-md text-uppercase shadow-sm fw-medium">voltar</a>
            </nav>
        </div>

        <div class="container">
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

            @if(session()->has('address_added'))
                @if(session('address_added'))
                    <div class="alert alert-success shadow-sm" role="alert">
                        <p class="m-0 fw-light">Endereço cadastrado</p>
                    </div>
                @else
                    <div class="alert alert-danger shadow-sm" role="alert">
                        <p class="m-0 fw-light">Erro ao cadastrar o endereço</p>
                    </div>
                @endif
            @endif

            <form action="{{ route('dashboard.partner.update', $partner->id) }}" method="post" class="">
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
                            <span class="text-danger me-2">*</span> Tipo
                        </label>
                    </div>
                    <div class="col col-9">
                        <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" name="type" required>
                            <option @if($partner->type === 'silver') selected @endif value="silver">Silver</option>
                            <option @if($partner->type === 'gold') selected @endif value="gold">Gold</option>
                        </select>
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

        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h1 class="text-white h1 h1-responsive fw-light">Endereços</h1>
        </div>

        <div class="container mb-5">
            @foreach($partner->addresses as $arrayIndex => $address)
                <div class="card bg-dark shadow border border-dark" style="width: 18rem">
                    <div class="card-body">
                        <p class="card-text mb-2 text-white">{{ $address->logradouro }}, {{ $address->numero }} - {{ $address->bairro }}</p>
                        <p class="m-0 card-title text-white mb-2">{{ $address->cidade }} {{ $address->estado }}</p>
                        <p class="m-0 card-title text-white">{{ $address->cep }}</p>
                        @if($address->complemento)
                            <p class="card-subtitle mb-2 text-white">({{ $address->complemento }})</p>
                        @endif

                        <hr>

                        <button type="button" class="btn btn-sm btn-danger shadow text-uppercase fw-bold">Excluir</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h1 class="text-white h1 h1-responsive fw-light">Cadastro de endereço</h1>
        </div>

        <form class="container" method="post" action="{{ route('dashboard.address.store') }}" novalidate>

            @csrf

            <input type="hidden" name="modelid" value="{{ request('id') }}">

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
                        maxlength="191"
                        value="{{ old('complemento', '') }}"
                    />
                </div>
            </div>

                {{-- @if($errors->any())
                    <div class="errors my-5">
                        @foreach($errors->all() as $key => $error)
                            <p class="ps-3 m-0 text-end fw-normal text-danger mb-2 w-100">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif --}}

            <footer class="text-end">
                <button onclick="enableInputs()" type="button" class="btn btn-dark text-uppercase shadow-sm fw-medium">preencher manualmente</button>
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
</style>
@endsection

@section('script')
<script defer>

    const VIA_CEP_API_URL = 'https://viacep.com.br/ws/';

    const enableInputs = () => {
        const disabledInputs = Array.from(document.querySelectorAll('[disabled]'));
        disabledInputs.map(input => input.disabled = false);
    };

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

            autoFillAddressInputs(request);
        }
    };

    const autoFillAddressInputs = (data) => {
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
@endsection
