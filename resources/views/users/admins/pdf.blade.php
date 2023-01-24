@extends('miscellaneous')
@section('content')
    <div class="roles-crud-pdf">

        <div class="container">


            <div class="row header">

                <div class="col-6">
                    <div class="count">
                        <span> Admins records : </span> {{ count($data['admins']) }}
                    </div>
                </div>

                <div class="col-6">
                    <div class="date">
                        {{ date('Y-m-d H:i:s') }}
                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Birth Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['admins'] as $admin)
                                <tr>
                                    <td><strong>{{ $admin->id }}</strong></td>
                                    <td>{{ $admin->first_name }}</td>
                                    <td>{{ $admin->last_name }}</td>
                                    <td>{{ $admin->username }}</td>
                                    <td>{{ $admin->user->email }}</td>
                                    <td>{{ $admin->gender }}</td>
                                    <td>{{ $admin->birth_date }}</td>
                                    <td>{{ $admin->user->status ? 'active' : 'blocked' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
