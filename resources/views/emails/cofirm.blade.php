Hello {{ $user->name }}

The email chenged ,, verfiy the new address :
{{ route('verify',$user->verification_token) }}
