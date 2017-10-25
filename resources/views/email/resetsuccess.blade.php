<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ __('Cho Thuê Phòng Trọ') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('layouts.partials.style')

</head>
<body>
	<div class="container">
		<div class="row text-center">
	        <div class="col-sm-6 col-sm-offset-3">
	        <br><br> <h2 style="color:#0fad00">Reset Password Success</h2>
	        <img src="http://osmhotels.com//assets/check-true.jpg">
	        <h3>Hello, {{$user->name}}</h3>
	        <p style="font-size:20px;color:#5C5C5C;">Your password has been set to default: abc123, please update this to sure that nobody can access your account!</p>
	    <br><br>
	        </div>
	        
		</div>
	</div>
</body>
</html>