@extends('layouts.main')

@section('content')
<form method="post" action="{{route('users.updateProfile', $user)}}">
    {{ csrf_field() }}
    {{ method_field('patch') }}
	<p>
	<label>User <br />
    <input type="text" name="name"  value="{{ $user->name }}" />
	</p>
	<p>
	<label>Mail <br />
    <input type="email" name="email"  value="{{ $user->email }}" />
	</p>
	<label>Change Password <br />
    <input type="password" name="password" />
	<p>
	<label>Confirm Password <br />
    <input type="password" name="password_confirmation" />
	</p>
    <button class="btn btn-orange" type="submit">Change Password</button>
</form>
@include('partials.alert')
@endsection