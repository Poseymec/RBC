<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Support\Facades\Session;
class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);


        //vue de la page login
        Fortify::loginView(function () {
           // Session()->flash('bienvenue', 'Bienvenue,' .auth()->user()->name.'!');
            return view ('auth.login');
        });
        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
     
            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
        });


         //vue de la page register
        Fortify::registerView(function () {
           // Session()->flash('bienvenue', 'Bienvenue,' .auth()->user()->name.'!');
            return view('auth.register');
        });

         //vue de la page confirm password
         Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });
          //vue de la page forgot passwort
          Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });
        
        Fortify::resetPasswordView(function (Request $request) {
            return view('auth.reset-password', ['request' => $request]);
        });

        //verificartion par email
        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });
     

     

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

     /*   RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });*/
    }
}
