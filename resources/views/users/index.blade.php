@extends('layout.index')
@section('title', 'Users Page')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                @include('users.create')
                <x-card class="h-100">
                    <div class="d-flex justify-content-between mb-3">
                        <form class="d-flex">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        </form>
                        <button class="btn btn-primary-color" data-bs-toggle="modal" data-bs-target="#createModal">
                            Tambah Data
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" style="width:100%">
                            <thead class="table primary-thead">
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr id="user_{{ $user->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <form action="{{ route('user.toggle-active', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('POST')
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input toggle-active" type="checkbox"
                                                        role="switch" id="toggle_{{ $user->id }}"
                                                        data-id="{{ $user->id }}"
                                                        {{ $user->isActive() ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="toggle_{{ $user->id }}">
                                                        {{ $user->userStatus->name }}
                                                    </label>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $rolename)
                                                    <label class="badge bg-primary mx-1">{{ $rolename }}</label>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $user->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @include('users.edit', ['user' => $user])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-card>
                @if (session('success'))
                    <x-toast status='success' title='Berhasil!'>
                        {{ session('success') }}
                    </x-toast>
                @endif
                @if (session('error'))
                    <x-toast status='error' title='Gagal!'>
                        {{ session('error') }}
                    </x-toast>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.querySelectorAll('.toggle-active').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    </script>
@endsection
