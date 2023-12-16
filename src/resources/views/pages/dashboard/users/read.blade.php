@extends('layouts.dashboard')

@section('content')
    <div class="dashboard-page">
        <div class="dashboard-page-title mb-5 d-flex align-items-center justify-content-between">
            <h3 class="text-white h3 h3-responsive fw-light">Usuários do sistema</h3>
            <nav>
                <a
                    href="{{ route('dashboard.users.create') }}"
                    class="btn btn-primary btn-md text-uppercase shadow-sm fw-medium">cadastrar
                </a>
            </nav>
        </div>

        @if(session()->has('delete_error'))
            <div class="alert alert-danger shadow">
                <p class="m-0 fw-light">Erro ao deletar o usuário</p>
            </div>
        @enderror

        <table class="table table-dark table-rounded shadow-sm m-0 table-hover">
            <thead>
                <tr>
                    <th scope="col" class="p-3 fw-semibold border-0">NOME</th>
                    <th scope="col" class="p-3 fw-semibold border-0">E-MAIL</th>
                    <th scope="col" class="p-3 fw-semibold border-0">DATA DE CADASTRO</th>
                    <th scope="col" class="p-3 fw-semibold border-0"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td class="p-3 fw-light border-0">{{ $user->name }}</td>
                        <td class="p-3 fw-light border-0">{{ $user->email }}</td>
                        <td class="p-3 fw-light border-0">{{ $user->created_at }}</td>

                        <td class="p-3 fw-light border-0 d-flex">
                            <form action="{{ route('dashboard.users.destroy', $user->id) }}" method="post">
                                @method('DELETE')
                                @csrf
                                <button type="button" class="btn p-0 m-0 px-2 delete-user-btn" onclick="destroy({{ json_encode($user) }}, this)">
                                    <img src="{{ asset('svg/trash.svg') }}" alt="ver" width="22">
                                </button>
                            </form>

                            <a href="{{ route('dashboard.users.show', $user->id) }}" class="btn p-0 m-0 px-2">
                                <img src="{{ asset('svg/edit.svg') }}" alt="ver" width="22">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if($users->count() === 0)
            <p class="m-0 text-center text-white fw-light mt-5">Nenhum usuário para listar</p>
        @endif
    </div>
@endsection

@section('script')
<script>
    function destroy(user, context)
    {
        const confirmed = window.confirm('Deletar usuário '.concat(user.name, '?'));

        if (confirmed) {
            context.type = 'submit';
        }
    }
</script>
@endsection
