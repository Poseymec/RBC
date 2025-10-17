@extends('auth-layout.master')

@section('titre')
nlelectro | verification-email
@endsection
@section('contenu')
	


			<form class="form-detail" action="{{route('verification.send')}}" method="POST">
                @csrf
                <h2>Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer par e-mail ? Si vous n'avez pas reçu l'e-mail, nous vous en enverrons volontiers un autre.</h2>

                @if(session('status')=='verification-link-sent')
    				<p class="alert alert-success">Un nouveau lien de verification  a été envoyé </p>
					@endif
				<div class="form-row-last">
					<button type="submit" name=" submit" class="register" >Renvoyer l'e-mail de vérification</button>
                </div>
                </form>
				
                <form action="{{route('logout')}}" method="POST" style="text-align: center; margin-bottom: 3px;">
                  
                    @csrf
                <button type="submit"  name="logout" class="register" >Deconnexion</button>
             
                      
            </form>
    @endsection