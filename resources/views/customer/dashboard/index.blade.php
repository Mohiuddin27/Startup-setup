<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Dashboard</title>
</head>
<body>
    <h1>Customer Dashboard</h1>
    <a href="{{route('customer.login.seller')}}">Login as seller</a>
    <a href="{{route('customer.login.affiliate')}}">Login as affiliate</a>
    <a href="{{url('logout')}}">logout</a>
</body>
</html>
