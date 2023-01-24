@extends('miscellaneous')
@section('content')
    <div class="roles-crud-pdf">


        <div class="container">


            <div class="row header">

                <div class="col-6">
                    <div class="count">
                        <span> Academic terms records : </span> {{ count($academicTerms) }}
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
                                <th>Academic year</th>
                                <th>Name</th>
                                <th>Start date</th>
                                <th>End date</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($academicTerms as $academicTerm)
                                <tr>
                                    <td><strong>{{ $academicTerm->id }}</strong></td>
                                    
                                    <td>



                                        {{ $academicTerm->academicYear->name }}



                                    </td>
                                    <td>{{ $academicTerm->name }}</td>
                                    <td>{{ $academicTerm->start_date }}</td>
                                    <td>{{ $academicTerm->end_date }}</td>




                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
