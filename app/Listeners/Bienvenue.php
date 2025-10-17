<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;

class Bienvenue
{
    public function handle(Authenticated $event){
        Session()->flash("success","Bienvenue,".$event->user->name);
    }
}