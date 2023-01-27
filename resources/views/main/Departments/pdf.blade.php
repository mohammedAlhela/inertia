@extends('miscellaneous')
@section('content')
    <div class="roles-crud-pdf">


        <div class="container">


            <div class="row header">

                <div class="col-6">
                    <div class="count">
                        <span> Departments records : </span> {{ count($data['records']) }}
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
                                <th>Name</th>
                                <th>Courses</th>
                                <th>Subjects</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['records'] as $department)
                                <tr>
                                    <td><strong>{{ $department->id }}</strong></td>
                                    <td>{{ $department->name }}</td>


                                    <td>
                                        @foreach ($department->courses as $course)
                                            <span>
                                                {{ $course->name }}
                                            </span>
                                        @endforeach
                                    </td>

                                    <td>
                                        @foreach ($department->subjects as $subject)
                                            <span>
                                                {{ $subject->name }}
                                            </span>
                                        @endforeach

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
