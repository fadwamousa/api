Hello {{ $user->name }}

Thank you for create the account ,,
 you should verify the acount by going to the link:
{{ route('verify',$user->verification_token) }}
