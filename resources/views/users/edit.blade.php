@extends('layouts.main')
@section('title', 'Einstellungen')
@section('content')
<div class="row">
	<form action="{{route('users.updateProfile', $user)}}" method="post">
		{{ csrf_field() }}
		{{ method_field('patch') }}
		<div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
			<div class="form-group">
				<label class="form-label">Benutzername <br />
					<span class="desc"></span>
					<div class="controls">
						<input type="text" name="name" value="{{ $user->name }}" class="form-control">
					</div>
				</div>
				<div class="form-group">
					<label class="form-label">E-Mail <br />
						<span class="desc"></span>
						<div class="controls">
							<input type="email" name="email" value="{{ $user->email }}" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="form-label">Passwort ändern <br />
							<span class="desc"></span>
							<div class="controls">
								<input type="password" name="password" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="form-label">Passwort bestätigen <br />
								<span class="desc"></span>
								<div class="controls">
									<input type="password" name="password_confirmation" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
							<div class="text-left">
								<button class="btn btn-success" type="submit">speichern</button>
							</div>
						</div>
					</form>
				</div>
@include('partials.alert')
@endsection