<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

use Laravel\Fortify\Fortify;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;

use App\Models\User;

class RegisteredUserController extends Controller
{
     public function deleteuser($id){
        $user=User::find($id);

        return view('admin.deleteuser')->with('user',$user);
      }

      public function yesdeleteuser($id){
        $user=User::find($id);
        $user->delete();
        return redirect('admin/userregister')->with('status',' utilisateur supprimé avec succès');

      }


      public function editeroleuser($id){
        $roles=Role::get();
        $user=User::find($id);
        $userRole=$user->getRoleNames();

        return view('admin.editeroleuser',compact('user','roles','userRole'));

      }

      public function assignroleuser($id, Request $request){
        $this->validate($request, [
            'role' => 'required|exists:roles,name',
        ]);
    
        $roleName = $request->input('role');
        $role = Role::where('name', $roleName)->first();
    
        $user = User::find($id);
        //dd($user);
        //($role);
     
        $user->syncRoles([$role]);
       
            return redirect('admin/userregister')->with('status', 'Rôle de l\'utilisateur modifié avec succès');
      
    }
    
    


}
