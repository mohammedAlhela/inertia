@extends('miscellaneous')
@section('content')
    <div class="roles-crud-pdf">


        <div class="container">


            <div class="row header">

                <div class="col-6">
                    <div class="count">
                        <span> Subjects records : </span> {{ count($data['subjects']) }}
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
                                <th>Course</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Subject Type</th>
                                <th>Students limit</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['subjects'] as $subjects)
                                <tr>
                                    <td><strong>{{ $subject->id }}</strong></td>
                                    <td>{{ $subject->department->name }}</td>
                                    <td>{{ $subject->course->name }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->type }}</td>
                                    <td>{{ $subject->subject_type }}</td>
                                    <td>{{ $subject->students_limit }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
