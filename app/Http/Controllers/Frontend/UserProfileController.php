<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;

class UserProfileController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:30'],
            'email' => ['required', 'email', 'unique:users,email,'.Auth::user()->id],
            'image' => ['image','max:2048']
           ]);

           $user = Auth::user();

        // Mengecek apabila user memiliki sebuah foto sebelumnya,
        //  maka ketika update file sebelumnya dihapus dan diganti dengan foto terbaru 
           if($request->hasFile('image')){
                if(File::exists(public_path($user->foto))){
                    File::delete(public_path($user->foto));
                }

        // menangani pengunggahan file gambar, menghasilkan nama file unik, menyimpan gambar dalam direktori public/upload
        // dan mengaitkan path gambar dengan objek pengguna
                $image = $request->image;
                $imageName = rand().'_'.$image->getClientOriginalName();
                $image->move(public_path('uploads'), $imageName);

                $path = 'uploads/'.$imageName;

                $user->foto = $path;
           }
           
        //  Menyimpan perubahan foto kedalam database  
           $user->name = $request->name;
           $user->email = $request->email;
           $user->save();

           toastr()->success('Profile Berhasil Di Update');
           return redirect()->back();
    }
}
