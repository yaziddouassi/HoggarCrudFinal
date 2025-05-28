<?php
namespace App\Http\Controllers\Hoggar\DevGenerator;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;



class Page6Controller extends Controller
{
   
   
    public function index(Request $request)
    {
        
        return Inertia::render('HoggarPages/DevGenerator/Page6',[
            'company' => config('hoggar.company'),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect('/admin');
        }

        return back()->withErrors([
            'email' => 'Wrong Credentials.',
        ])->onlyInput('email');
    }



    public function logout(Request $request)
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    
        return redirect('/');
    }




    
}