@extends('auth-layout.master')

@section('titre')
nlelectro | connexion
@endsection
@section('contenu')
					@if(session('status'))
    				<p class="error">{{session('status')}}</p>
					@endif

		
			<form class="form-detail" action="{{route('login')}}" method="POST">
				@csrf
                <h2>Si vous n'avez pas de compte, <a href="{{url('register')}}">Inscrivez-vous</a></h2>
			
				@if($errors->has('email'))
				<p class="error">{{ $errors->first('email') }}</p>
				@endif
			
				<div class="form-row">
					<label for="email">Email</label>
					<input type="text" name="email" id="email" class="input-text" placeholder="Email" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
					<i class="fas fa-envelope"></i>
					
				</div>
				<div class="form-row">
					<label for="password">Mot de passe</label>
					<input type="password" name="password" id="password" class="input-text" placeholder="votre mot de passe" required>
					<i id="eyeIcon" class=" fas fa-eye eye-icon" onclick="togglePasswordVisibility()"></i>

					
				</div>
			
				<p  style="font-weight: 400;"><input type="checkbox" name="remember" id="remember" class="input-checkbox"> se souvenir de moi</p>

				
				<div class="form-row-last">
					<button type="submit" name=" submit" class="register" >connexion</button>
					
				</div>
			</form>
			<p style=" text-align: center;"" ><a href="{{url('forgot-password')}}" style="color:blue ;">Mot de passe oublié?</a></p>
            @endsection
