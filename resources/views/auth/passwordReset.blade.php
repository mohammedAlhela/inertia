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
                        User reset link to =>  <strong> {{ $data['email'] }} </strong>
                    </div>

                    <div>
                        Please click on following password reset link to reset your password.
                        <br>
                        <a href="http://127.0.0.1:8000/password-reset/{{  $data['token']  }}/{{  $data['email'] }}">
                           {{ 'http://127.0.0.1:8000/password-reset/' . $data['token'] . '/' .  $data['email']  }} </a>
                    </div>

                    <div>
                        <span> {{ $data['company']->name  }} </span>
                        <span> {{ $data['company']->address  }} </span>
                    </div>

                </div>
            </div>
            <div class="footer">
                Powered by {{$data['company']->name  }}
            </div>
            </p>
        </div>
    </div>
@endsection
