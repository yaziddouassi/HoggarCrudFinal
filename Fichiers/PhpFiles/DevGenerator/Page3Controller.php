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



class Page3Controller extends Controller
{
    public function updateActive(Request $request)
    {  
        \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('id',$request->id)->update([
            'active' => (bool) $request->active,
        ]);
    } 
   
    public function delete(Request $request)
    {  
        \Hoggarcrud\Hoggar\Models\Hoggarcrud::destroy($request->id);
    }  

    public function index(Request $request)
    {
        return Inertia::render('HoggarPages/DevGenerator/Page3', [
            'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
            'user' => Auth::user(),
            'allRoutes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::get(),
        ]);
    }

    
}