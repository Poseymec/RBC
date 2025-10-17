@extends('auth-layout.master')

@section('titre')
nlelectro | reinitialisation du mot de passe
@endsection
@section('contenu')
	


			<form class="form-detail" action="{{route('password.update')}}" method="POST">
				@csrf
                <h2>reinitialisation du mot de passe</h2>
				@if(session('status'))
    				<p class="success">{{session('status')}}</p>
					@endif
				<div class="form-row">
					<label for="email">Email</label>
					<input type="text" name="email" id="email" class="input-text" placeholder="Email" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" value={{request()->email}}>
					<i class="fas fa-envelope"></i>
				
					@if($errors->has('email'))
    				<p class="error">{{ $errors->first('email') }}</p>
					@endif
				</div>
				<div class="form-row">
					<label for="password">  Nouveau mot de passe</label>
					<input type="password" name="password" id="password" class="input-text" placeholder="votre mot de passe" required>
					<i id="eyeIcon" class=" fas fa-eye eye-icon" onclick="togglePasswordVisibility()"></i>
					@if($errors->has('password'))
    				<p class="error">{{ $errors->first('password') }}</p>
					@endif
				</div>
                <div class="form-row">
					<label for="password"> confirmer le mot de passe</label>
					<input type="password" name="password_confirmation" id="password" class="input-text" placeholder="votre mot de passe" required>
					<i id="eyeIcon" class=" fas fa-eye eye-icon" onclick="togglePasswordVisibility()"></i>
					@if($errors->has('password'))
    				<p class="error">{{ $errors->first('password') }}</p>
					@endif
					<input type="hidden" name="token" value="{{request()->route('token')}}">
				</div>
				
				<div class="form-row-last">
					<button type="submit" name=" submit" class="register" >Reinitialiser</button>
					
				</div>
			</form>
			<a href="{{url('login')}}" style="color: blue;"><i class="fas fa-reply"  style=" margin-bottom: 15px;">Retour</i></a>
			@endsection