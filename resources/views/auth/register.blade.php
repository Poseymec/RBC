@extends('auth-layout.master')

@section('titre')
nlelectro | inscription
@endsection
@section('contenu')
	

			<form class="form-detail" action="{{route('register')}}" method="POST">
				@csrf
				<h2>  <a href="{{url('login')}}">connectez-vous</a>, si vous avez deja un compte</h2>
				<div class="form-row">
					<label for="username">Nom</label>
					<input type="text" name="name" id="username" class="input-text" placeholder="votre Nom" required>
					<i class="fas fa-user"></i>
					@if($errors->has('name'))
    				<p class="error">{{ $errors->first('name') }}</p>
					@endif
				</div>
				<div class="form-row">
					<label for="email">Email</label>
					<input type="text" name="email" id="email" class="input-text" placeholder="Email" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
					<i class="fas fa-envelope"></i>
					@if($errors->has('email'))
    				<p class="error">{{ $errors->first('email') }}</p>
					@endif
				</div>
				<div class="form-row">
					<label for="password">Mot de passe</label>
					<input type="password" name="password" id="password" class="input-text" placeholder="votre mot de passe" required>
					<i id="eyeIcon" class=" fas fa-eye eye-icon" onclick="togglePasswordVisibility()"></i>
					@if($errors->has('password'))
    				<p class="error">{{ $errors->first('password') }}</p>
					@endif
				</div>
				<div class="form-row">
					<label for="password">Confirmez le mot de passe</label>
					<input type="password" name="password_confirmation" id="password" class="input-text" placeholder="votre mot de passe" required>
					<i id="eyeIcon" class=" fas fa-eye eye-icon" onclick="togglePasswordVisibility()"></i>
					@if($errors->has('password'))
    				<p class="error">{{ $errors->first('password') }}</p>
					@endif
				</div>
				<div class="form-row">
					<label for="phone">Téléphone</label>
					<input type="number" name="number" id="phone" class="input-text" placeholder="votre numero de telephone" required>
					<i class="fas fa-phone"></i>
					@if($errors->has('number'))
    				<p class="error">{{ $errors->first('number') }}</p>
					@endif
				</div>
				<div class="form-row-last">
					<button type="submit" name=" submit" class="register" > S'inscrire</button>
					
				</div>
			</form>

			@endsection
	
