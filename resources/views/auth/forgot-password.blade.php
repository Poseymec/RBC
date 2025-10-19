@extends('auth-layout.master')

@section('titre')
nlelectro | mot de passe oublie
@endsection
@section('contenu')


			<form class="form-detail" action="{{route('password.email')}}" method="POST">
				@csrf
                <h2>
                    Mot de passe oublié ? Aucun problème. Il vous suffit de nous indiquer votre adresse e-mail et nous vous enverrons un lien de réinitialisation de mot de passe par e-mail, vous permettant ainsi d'en choisir un nouveau.
                </h2>
				@if(session('status'))
    				<p class="success">{{session('status')}}</p>
					@endif
				<div class="form-row">
					<label for="email">Email</label>
					<input type="text" name="email" id="email" class="input-text" placeholder="Email" required pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}">
					<i class="fas fa-envelope"></i>
					@if($errors->has('email'))
    				<p class="error">{{ $errors->first('email') }}</p>
					@endif
				</div>
				
				
				<div class="form-row-last">
					<button type="submit" name=" submit" class="register" >Envoyer</button>
					
				</div>
			</form>
            <a href="{{url('login')}}" style="color: blue;"><i class="fas fa-reply"  style=" margin-bottom: 15px;">Retour</i></a>
	
			@endsection