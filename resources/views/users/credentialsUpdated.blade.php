@extends('miscellaneous')
@section('content')
    <div class="mail-message-template">
        <div class="container">
            <div class="content">
                <div class="brand">
                    <img src="{{ $data['company']->image }}" alt=""> {{ $data['company']->name }}
                </div>

                <div class="message">

                    <div>
                        Hi {{ $data['user']->username }} Welcome to {{ $data['company']->name }} You credentials changed by
                        the admin to :

                        Email : {{ $data['user']->email }}

                        <br>

                        Password : {{ $data['user']->password_label }}

                        <br>


                    </div>

                    <div>
                        <span> {{ $data['company']->name }} </span>
                        <span> {{ $data['company']->address }} </span>
                    </div>

                </div>
            </div>
            <div class="footer">
                Powered by {{ $data['company']->name }}
            </div>
            </p>
        </div>
    </div>
@endsection
