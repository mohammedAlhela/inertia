<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    
    <link rel="icon" href="{{ asset('images/main/favicon.ico') }}" type="image/x-icon" /> 



    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>
    @inertiaHead
  </head>
  <body>
    @inertia

    <script>
      window.User = {!! json_encode(optional(auth()->user())->only('id', 'username' , 'status', 'permissions' , 'role' )) !!}
  </script>
  </body>
</html>
