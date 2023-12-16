@extends('layouts.dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h3 class="text-white h3 h3-responsive fw-light">Sócios</h3>
            <nav>
                <a
                    href="{{ route('dashboard.partner.create') }}"
                    class="btn btn-primary btn-md text-uppercase shadow-sm fw-medium"
                >cadastrar</a>
            </nav>
        </div>

        @if(session()->has('delete_error'))
            <div class="alert alert-danger shadow">
                <p class="m-0 fw-light">Desculpe, um erro ocorreu durante a deleção.</p>
            </div>
        @enderror

        @if(session()->has('partner_deleted'))
            @if(session('partner_deleted'))
                <div class="alert alert-info shadow">
                    <p class="m-0 fw-light">Sócio deletado.</p>
                </div>
            @else
                <div class="alert alert-danger shadow">
                    <p class="m-0 fw-light">Erro ao deletar o sócio.</p>
                </div>
            @endif
        @enderror

        <table class="table table-dark table-rounded shadow-sm m-0 table-hover">
            <thead>
                <tr>
                    <th scope="col" class="p-3 fw-semibold border-0">NOME</th>
                    <th scope="col" class="p-3 fw-semibold border-0">TIPO</th>
                    <th scope="col" class="p-3 fw-semibold border-0"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($partners as $arrayIndex => $partner)
                    <tr>
                        <td class="p-3 fw-light border-0">{{ $partner->name }}</td>
                        <td class="p-3 fw-light border-0">
                            @if($partner->type === 'gold') 👑 @endif

                            <span @class([
                                'badge fw-normal text-uppercase shadow rounded-pill',
                                'text-bg-dark'    => $partner->type === 'silver',
                                'text-bg-warning' => $partner->type === 'gold',
                            ])>
                                {{ $partner->type }}
                            </span>
                        </td>

                        <td class="p-3 fw-light border-0">
                            <button type="button" class="btn p-0 m-0 px-2 delete-user-btn" onclick="destroy({
                                name: '{{ $partner->name }}',
                                type: '{{ $partner->type }}',
                                id: {{ $partner->id }}
                            })">
                                <img src="{{ asset('svg/trash.svg') }}" alt="ver" width="22">
                            </button>

                            <a href="{{ route('dashboard.partner.show', $partner->id) }}" class="btn p-0 m-0 px-2">
                                <img src="{{ asset('svg/edit.svg') }}" alt="Icone de caneta" width="22">
                            </a>
                        </td>
                    </tr>
                @endforeach

                @if(count($partners) === 0)
                    <tr>
                        <td colspan="3" class="text-center border-0 fw-light">
                            Nenhum sócio cadastrado até o momento...
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <form action="{{ route('dashboard.partner.destroy', ['id' => 0]) }}" method="post" class="form_delete d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('script')
<script>
    function destroy(partnet)
    {
        const confirmed = window.confirm('Confirmar deleção do sócio "'.concat(partnet.name, '"?'));

        if (confirmed) {
            const form_delete = document.querySelector('form.form_delete');

            // muda o zero (padrao, para o Laravel nao reclamar de parametro faltando) para o id do usuario clicado:
            form_delete.action = form_delete.action.replace('partner/0', 'partner/'.concat(partnet.id));

            form_delete.submit();
        }
    }
</script>
@endsection
