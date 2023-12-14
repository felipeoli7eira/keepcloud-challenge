@extends('layouts.dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h1 class="text-white h1 h1-responsive fw-light">Sócios</h1>
            <nav>
                <a href="{{ route('dashboard.partner.create') }}" class="btn btn-primary btn-md text-uppercase shadow-sm fw-medium">cadastrar</a>
            </nav>
        </div>

        {{-- @if(session()->has('delete_error'))
            <div class="alert alert-danger shadow">
                <p class="m-0 fw-light">Erro ao deletar o usuário</p>
            </div>
        @enderror --}}

        <table class="table table-dark table-rounded shadow-sm m-0 table-hover">
            <thead>
                <tr>
                    <th scope="col" class="p-3 fw-medium border-0">NOME</th>
                    <th scope="col" class="p-3 fw-medium border-0">TIPO</th>
                    <th scope="col" class="p-3 fw-medium border-0"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($partners as $index => $partner)
                    <tr>
                        <td class="p-3 fw-light border-0">{{ $partner->name }}</td>
                        <td class="p-3 fw-light border-0">
                            @if($partner->type === 'gold') 👑 @endif

                            <span @class([
                                'badge fw-normal text-uppercase shadow',

                                'text-bg-dark' => $partner->type === 'silver',
                                'text-bg-warning' => $partner->type === 'gold',
                            ])>
                                {{ $partner->type }}
                            </span>
                        </td>

                        <td class="p-3 fw-light border-0">
                            <button class="btn p-0 m-0 px-2 delete-user-btn" onclick="destroy({
                                name: '{{ $partner->name }}',
                                id:   {{ $partner->id   }}
                            })">
                                <img src="{{ asset('svg/trash.svg') }}" alt="ver" width="22">
                            </button>

                            <a href="{{ route('dashboard.partner.show', $partner->id) }}" class="btn p-0 m-0 px-2">
                                <img src="{{ asset('svg/edit.svg') }}" alt="ver" width="22">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- @if($users->count() === 0)
            <p class="m-0 text-center text-white fw-light mt-5">Nenhum usuário para listar</p>
        @endif --}}
    </div>

    {{-- <form action="{{ route('dashboard.users.destroy', 0) }}" method="post" class="form_delete d-none">
        @csrf
        @method('DELETE')
    </form> --}}
@endsection

@section('script')
<script>
    // function destroy(user_data)
    // {
    //     const decision = window.confirm('Confirmar deleção do usuário "'.concat(user_data.name, '"?'));

    //     if (decision)
    //     {
    //         const form_delete = document.querySelector('form.form_delete');

    //         // muda o zero (padrao para o Laravel nao reclamar de parametro faltando) para o id do usuario clicado:
    //         form_delete.action = form_delete.action.replace('users/0', 'users/'.concat(user_data.id));

    //         form_delete.submit();
    //     }
    // }
</script>
@endsection
