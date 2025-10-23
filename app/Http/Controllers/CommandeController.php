<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CommandeController extends Controller
{
    //

    public function commandeproduit($id){

        //recuperer le produit

        $produit=Product::find($id);

        //personnaliser le message avec les information sur le produit
        $message = urlencode("Bonjour, je souhaite commander ce produit: \n" .
            "Nom: " . $produit->product_name . "\n" .
            "Description: " . $produit->product_description . "\n");
        $numero = urlencode("+237697888634");
        $lien_whatsapp = "https://api.whatsapp.com/send/?phone=$numero&text=$message&app_absent=0";

       //dd($lien_whatsapp);

       // https://api.whatsapp.com/send/?phone=$numero&text=".urlencode($message)."&app_absent=0
       //rediriger vers whatsapp avec le numero*/

        return redirect()->away($lien_whatsapp);



    }
}
