@extends('miscellaneous')
@section('content')
    <div class="roles-crud-pdf">


        <div class="container">


            <div class="row header">

                <div class="col-6">
                    <div class="count">
                        <span> Academic years records : </span> {{ count($academicYears) }}
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
                                <th>Start date</th>
                                <th>End date</th>
                                <th>Academic terms</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($academicYears as $academicYear)
                                <tr>
                                    <td><strong>{{ $academicYear->id }}</strong></td>
                                    <td>{{ $academicYear->name }}</td>
                                    <td>{{ $academicYear->start_date }}</td>
                                    <td>{{ $academicYear->end_date }}</td>


                                    <td>
                                        @foreach ($academicYear->academicTerms as $academicTerm)
                                            <span>
                                                {{ $academicTerm->name }}
                                            </span>
                                        @endforeach


                                        {{ $academicYear->academicTerms }}



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
