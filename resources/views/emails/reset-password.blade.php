<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <section class="hero">
        <h4 style="padding-top: 20px;"> <a href="{{env('APP_URL').'api/v1/auth/reset-password-email?token='.$token }}">Click here</a></h4>
    </section>

</body>
</html>
