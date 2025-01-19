@extends('layout.master')
@section('content')
    <section class="section">
        <div class="row">
            <div class="card">
                <div class="col-lg-12">
                    <div class="iq-card">
                        <div class="iq-card-header d-flex justify-content-between align-items-center">
                            <div class="iq-header-title">
                                <h4 class="card-title">Liste des clients</h4>
                            </div>
                        </div>
                        <div class="iq-card-body">
                            <div class="table-responsive">
                                <table id="user-list-table" class="table table-striped mt-4" role="grid"
                                    aria-describedby="user-list-page-info">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Statut</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->firstname }}  {{ $user->lastname }}</td>
                                                <td>{{ $user->phone }}</td>
                                                <td>{{ $user->email }}</td>
                                                @if ($user->client->status == 0)
                                                    <td><span class="badge badge-danger">Désactivé</span></td>
                                                @else
                                                    <td><span class="badge badge-success">Activé</span></td>
                                                @endif
                                                <td>
                                                    <div class="flex align-items-center">
                                                        <a class="btn btn-outline-info btn-sm" data-toggle="tooltip"
                                                            title="Modifier" data-placement="top" data-original-title="Edit"
                                                            href="{{ route('clients.edit', $user->client->id) }}"><i
                                                                class="far fa-edit"></i></a>
                                                        @if ($user->status == 1)
                                                            <form class="d-inline" method="post"
                                                                action="{{ route('clients.disable', $user->client->id) }}">
                                                                @csrf
                                                                <input type="hidden" name="status" id="status-input"
                                                                    value="0">
                                                                <button class="btn btn-outline-danger btn-sm disable-user"
                                                                    data-user-id="{{ $user->client->id }}" data-toggle="tooltip"
                                                                    title="Désactivé" data-placement="top"
                                                                    data-original-title="Disable">
                                                                    <i class="fas fa-stop"></i>
                                                                </button>
                                                            </form>
                                                        @else
                                                            <form class="d-inline" method="post"
                                                                action="{{ route('clients.enable', $user->client->id) }}">
                                                                @csrf
                                                                <input type="hidden" name="status" id="status-input-enable"
                                                                    value="1">
                                                                <button type="submit"
                                                                    class="btn btn-outline-primary btn-sm enable-user"
                                                                    data-user-id="{{ $user->client->id }}" data-toggle="tooltip"
                                                                    title="Activé" data-placement="top"
                                                                    data-original-title="Enable">
                                                                    <i class="fas fa-play"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                        <a class="btn btn-outline-success btn-sm"
                                                            href="clients/{{ $user->id }}" data-toggle="tooltip"
                                                            title="Voir" data-original-title="View"><i
                                                                class="fa fa-eye"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Script de désactivation -->
                <script>
                    $(document).on('click', '.disable-user', function(e) {
                        e.preventDefault();
                        var button = $(this);
                        var userId = button.data('user-id');

                        Swal.fire({
                            text: 'Voulez-vous désactiver cet utilisateur ?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Annuler'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route('clients.disable', ':id') }}'.replace(':id', userId),
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: userId,
                                        status: $('#status-input').val()
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            title: 'Success',
                                            text: response.message,
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false,
                                        });

                                        // actualiser le tableau avec ajax
                                        // $('#user-list-table').load(window.location.href + ' #user-list-table');
                                        location.reload();
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'An error occurred while disabling the user.',
                                            icon: 'error'
                                        });
                                    }
                                });
                            }
                        });
                    });
                </script>
                <!-- Script d'activation -->
                <script>
                    $(document).on('click', '.enable-user', function(e) {
                        e.preventDefault();
                        var button = $(this);
                        var userId = button.data('user-id');

                        Swal.fire({
                            text: 'Voulez-vous activer cet utilisateur ?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Oui',
                            cancelButtonText: 'Annuler'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route('clients.enable', ':id') }}'.replace(':id', userId),
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        id: userId,
                                        status: $('#status-input-enable').val()
                                    },
                                    success: function(response) {
                                        Swal.fire({
                                            title: 'Success',
                                            text: response.message,
                                            icon: 'success',
                                            timer: 2000,
                                            showConfirmButton: false,
                                        });

                                        location.reload();
                                    },
                                    error: function(xhr) {
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'An error occurred while enabling the user.',
                                            icon: 'error'
                                        });
                                    }
                                });
                            }
                        });
                    });
                </script>
            </div>
    </section>
@endsection
