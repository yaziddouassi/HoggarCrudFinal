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


class Page1Controller extends Controller
{
   
    public function index(Request $request)
    {

        $listModels = [];

        $path = app_path('Models');
        
        if (File::exists($path)) {
            foreach (File::files($path) as $file) {
                $listModels[] = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            }
        }
            

        return Inertia::render('HoggarPages/DevGenerator/Page1', [
            'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
            'user' => Auth::user(),
            'listModels' => $listModels ,
            'middlewareList' => config('hoggar.middlewareList'),
        ]);
    }

    
}