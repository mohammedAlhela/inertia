<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company data</title>


    <style>

    </style>
</head>

<body>



    <div class="address">
        <div>
            {{ $data['name'] }}
        </div>

        <div>
            {{ $data['address'] }}
        </div>

        <div>
            Email : {{ $data['email'] }}
        </div>

        <div>
            Phone : {{ $data['mobile'] }}
        </div>
    </div>


    <div class="logo">
        <img src="images/main/company.webp" alt="sdsd" width="60px">

    </div>

    <div class="informations">

        <span>Company register : {{ $data['company_register'] }}</span>

    </div>


</body>

</html>
