<!DOCTYPE html>
<html>
<head>
    <title>Confirmation Email</title>
</head>

<body>
  <h2>Welcome {{$user['name']}}</h2>
  <br/>
  Your registered email-id is {{$user['email']}} , Please use below otp number to verify your email account
  HI, 
  <br/>
  {{ $user->verifyUser->otp }}
  {{-- <a href="{{url('verifyUser', $user->verifyUser->token)}}">Verify User</a> --}}
</body>
</html>
