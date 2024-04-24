<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;

class ProfileController extends Controller
{
    // Menampilkan halaman profile
    public function index()
    {
        return view('admin.profile.index');
    }

    // Ubah Profil
    public function updateProfile(Request $request)
    {
       $request->validate([
        'name' => ['required', 'max:30'],
        'email' => ['required', 'email', 'unique:users,email,'.Auth::user()->id],
        'image' => ['image','max:2048']
       ]);
       
    // Mengecek apakah foto sudah ada atau belum jika sudah ada maka akan disimpan di folder public/uploads
    $user = Auth::user();
    
    if($request->has('image')){

        // Menghapus file apabila user telah mengupdate foto 
        if(File::exists(public_path($user->foto))){
            File::delete(public_path($user->foto));
        }
        
        $image = $request->image;
        $imageName = rand().'_'.$image->getClientOriginalName();
        $image->move(public_path('uploads'),$imageName);

        $path = "/uploads/".$imageName;

        $user->foto = $path;
       }

    //  Menyimpan foto kedalam database  

       $user->name = $request->name;
       $user->email = $request->email;
       $user->save();

       toastr()->success('Profile Berhasil Di Update');
       return redirect()->back();
    }

    // Ubah Password
    public function updatePassword(Request $request)
    {
        // Memvalidasi password yang lama dengan password yang baru
       $request->validate([
        'current_password' => ['required','current_password'],
        'password' => ['required','confirmed','min:8'],
       ]);

        //  Menyimpan password baru di database   
       $request->user()->update([
        'password' => bcrypt($request->password)
       ]);

       toastr()->success('Password Berhasil Di Update');
       return redirect()->back();
    }
}
