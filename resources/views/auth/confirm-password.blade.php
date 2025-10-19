@extends('auth-layout.master')

@section('titre')
	NLelectro | confirmation de mot de passe
@endsection
@section('contenu')
	


			<form class="form-detail" action="{{route('password.confirm')}}" method="POST">
				@csrf
               <h2>
                   Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer."
               </h2>
				<div class="form-row">
					<label for="password">Mot de passe</label>
					<input type="password" name="password" id="password" class="input-text" placeholder="votre mot de passe" required>
					<i id="eyeIcon" class=" fas fa-eye eye-icon" onclick="togglePasswordVisibility()"></i>
					@if($errors->has('password'))
    				<p class="error">{{ $errors->first('password') }}</p>
					@endif
				</div>
				
				<div class="form-row-last">
					<button type="submit" name=" submit" class="register" >Confirmer</button>
					
				</div>
			</form>
			@endsection