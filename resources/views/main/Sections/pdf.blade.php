@extends('miscellaneous')
@section('content')
    <div class="roles-crud-pdf">


        <div class="container">


            <div class="row header">

                <div class="col-6">
                    <div class="count">
                        <span> Sections records : </span> {{ count($data['sections']) }}
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
                                <th>Course</th>
                                <th>Name</th>
                                <th>Students limit</th>


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['sections'] as $sections)
                                <tr>
                                    <td><strong>{{ $section->id }}</strong></td>
                                    <td>{{ $section->course->name }}</td>
                                    <td>{{ $section->name }}</td>
                                    <td>{{ $section->students_limit }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
