@extends('miscellaneous')
@section('content')
    <div class="roles-crud-pdf">


        <div class="container">


            <div class="row header">

                <div class="col-6">
                    <div class="count">
                        <span> Courses records : </span> {{ count($data['courses']) }}
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
                                <th>Department</th>
                                <th>Name</th>
                                <th>Students limit</th>
                                <th>Evaluation type</th>
                                <th>Subjects</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['courses'] as $course)
                                <tr>
                                    <td><strong>{{ $course->id }}</strong></td>
                                    <td>{{ $course->department->name }}</td>
                                    <td>{{ $course->name }}</td>
                                 



                                    <td>{{ $course->students_limit }}</td>
                                    <td>{{ $course->evaluation_type }}</td>

                                    <td>
                                        @foreach ($course->subjects as $subject)
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
