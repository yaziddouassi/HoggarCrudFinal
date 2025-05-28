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


class Page4Controller extends Controller
{
   
    public function ajouter(Request $request)
    {
     
        $request->validate([
            'selected' => ['required'],
         ]);
        
        foreach ($request->selected as $key => $value) {

            $transformString = new \Hoggarcrud\Hoggar\Utils\TransformString();
            $crud = new \Hoggarcrud\Hoggar\Models\Hoggarcrud() ;
            $crud->model  =  $value;
            $crud->label  = $transformString->transformLink($value) ;
            $crud->route  = '/admin/' .  $transformString->transformUrl($value) ;
            $crud->icon  = 'description' ;
            $crud->active  = true ;
            $crud->save()  ;
        }
    

    }




    public function index(Request $request)
    {

        $listModels = [];

        $path = app_path('Models');
        
        if (File::exists($path)) {
            foreach (File::files($path) as $file) {
                $listModels[] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            }
        }


        return Inertia::render('HoggarPages/DevGenerator/Page4', [
            'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
            'user' => Auth::user(),
            'listModels' => $listModels ,
        ]);
    }

    
}