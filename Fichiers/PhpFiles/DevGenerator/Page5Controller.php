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



class Page5Controller extends Controller
{

  public function store(Request $request)
  {
    $request->validate([
      'icon' => ['required'],
      'label' => ['required'],
      'active' => ['required'],
    ]);

    
    \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('id',$request->id)->update([
      'icon' => $request->icon,
      'label' => $request->label ,
      'active' => (bool) $request->active,
  ]);
  }
    
   
    public function index(Request $request)
    {
      $record =  \Hoggarcrud\Hoggar\Models\Hoggarcrud::find($request->id);
 
      if ($record === null) {
            return redirect('/admin/route-generator');
      }


        return Inertia::render('HoggarPages/DevGenerator/Page5', [
          'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
          'user' => Auth::user(),
          'record' => $record ,
        ]);
    }

    
}