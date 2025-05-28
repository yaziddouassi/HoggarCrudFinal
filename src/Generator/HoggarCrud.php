<?php

namespace Hoggarcrud\Hoggar\Generator;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class Hoggarcrud extends Controller
{
    
    public function create(Request $request)
    {

        $request->validate([
            'model' => ['required'],
            'middleware' => ['required'],
          ]);


        $transformString = new \Hoggarcrud\Hoggar\Utils\TransformString();

        $modelLink  = $transformString->transformLink($request->model) ;
        $modelUrl  = $transformString->transformUrl($request->model) ;

        $crudPart = new \Hoggarcrud\Hoggar\Utils\CrudPart();

        $piece1 = $crudPart->getPiece1($request->model,$modelLink,$modelUrl);
        $piece2 = $crudPart->getPiece2($request->model,$modelLink,$modelUrl);
        $piece3 = $crudPart->getPiece3($request->model,$modelLink,$modelUrl);
        $piece4 = $crudPart->getPiece4($request->model,$request->middleware,$modelUrl);
        $piece5 = $crudPart->getPiece5($request->model,$modelLink,$modelUrl);
       

        $tempdossier1  =  'app/Http/Controllers/Hoggar/Crud/' . $request->model ;
        $tempdossier2  =  'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/Customs';
        $dossier1 = base_path($tempdossier1);
        $dossier2 = base_path($tempdossier2);

        $tempchemin1  = 'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/CreatorController.php' ;
        $tempchemin2  = 'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/UpdatorController.php' ;
        $tempchemin3  = 'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/ListingController.php' ;
        $tempchemin4 = "routes/hoggar.php" ;
        $tempchemin5  = 'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/Customs/Page1Controller.php' ;

        $chemin1 = base_path($tempchemin1);
        $chemin2 = base_path($tempchemin2);
        $chemin3 = base_path($tempchemin3);
        $chemin4 = base_path($tempchemin4);
        $chemin5 = base_path($tempchemin5);

        if (File::exists($dossier1)) {
            return back()->withErrors([
                'message' => 'CRUD already exist for this model.'
            ]);
        }

        if (!File::exists($dossier1)) {
            File::makeDirectory($dossier1, 0755, true);
        }

         if (!File::exists($dossier2)) {
            File::makeDirectory($dossier2, 0755, true);
        }

        if (!File::exists($chemin1)) {
          
            File::put($chemin1,$piece1);
        }

        if (!File::exists($chemin2)) {
            
            File::put($chemin2, $piece2);
        }

        if (!File::exists($chemin3)) {
            
            File::put($chemin3, $piece3);
        }

        if (!File::exists($chemin5)) {
            
            File::put($chemin5, $piece5);
        }

        File::append($chemin4 , $piece4);
        /////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////

        $sourcePath = base_path('vendor/hoggarcrud/hoggar/Fichiers/CrudFiles');
       
        $temp = 'resources/js/Pages/HoggarPages/Crud/' . $request->model ;

        $directory = base_path($temp);

        File::copyDirectory($sourcePath, $directory);

        if (!File::exists($directory)) {
            return response()->json(['error' => 'Dossier non trouvé.'], 404);
        }
    
        // Récupère tous les fichiers (même dans les sous-dossiers)
        $files = File::allFiles($directory);
    
        foreach ($files as $file) {
            if ($file->getExtension() === 'txt') {
                // Nouveau nom avec extension .vue
                $newFileName = str_replace('.txt', '.vue', $file->getFilename());
    
                // Nouveau chemin complet
                $newFilePath = $file->getPath() . '/' . $newFileName;
    
                // Renommer le fichier
                File::move($file->getPathname(), $newFilePath);
            }
        }
    

        
        $crud = new \Hoggarcrud\Hoggar\Models\Hoggarcrud() ;
        $crud->model  =  $request->model;
        $crud->label  = $transformString->transformLink($request->model) ;
        $crud->route  = '/admin/' .  $transformString->transformUrl($request->model) ;
        $crud->icon  = 'description' ;
        $crud->active  = true ;
        $crud->save()  ;


    }

   

    public function create2(Request $request)
    {
        $request->validate([
            'model' => ['required'],
            'middleware' => ['required'],
          ]);


          $transformString = new \Hoggarcrud\Hoggar\Utils\TransformString();

          $modelLink  = $transformString->transformLink($request->model) ;
          $modelUrl  = $transformString->transformUrl($request->model) ;
  
          $crudPart = new \Hoggarcrud\Hoggar\Utils\WizardPart();
  
          $piece1 = $crudPart->getPiece1($request->model,$modelLink,$modelUrl);
          $piece2 = $crudPart->getPiece2($request->model,$modelLink,$modelUrl);
          $piece3 = $crudPart->getPiece3($request->model,$modelLink,$modelUrl);
          $piece4 = $crudPart->getPiece4($request->model,$request->middleware,$modelUrl);
          $piece5 = $crudPart->getPiece5($request->model,$modelLink,$modelUrl);

        $tempdossier1  =  'app/Http/Controllers/Hoggar/Crud/' . $request->model ;
        $tempdossier2  =  'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/Customs';
        $dossier1 = base_path($tempdossier1);
        $dossier2 = base_path($tempdossier2);

        $tempchemin1  = 'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/CreatorController.php' ;
        $tempchemin2  = 'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/UpdatorController.php' ;
        $tempchemin3  = 'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/ListingController.php' ;
        $tempchemin4 = "routes/hoggar.php" ;
        $tempchemin5  = 'app/Http/Controllers/Hoggar/Crud/' . $request->model . '/Customs/Page1Controller.php' ;

        $chemin1 = base_path($tempchemin1);
        $chemin2 = base_path($tempchemin2);
        $chemin3 = base_path($tempchemin3);
        $chemin4 = base_path($tempchemin4);
        $chemin5 = base_path($tempchemin5);

        if (File::exists($dossier1)) {
            return back()->withErrors([
                'message' => 'CRUD already exist for this model.'
            ]);
        }

        if (!File::exists($dossier1)) {
            File::makeDirectory($dossier1, 0755, true);
        }

        if (!File::exists($dossier2)) {
            File::makeDirectory($dossier2, 0755, true);
        }

        if (!File::exists($chemin1)) {
          
            File::put($chemin1,$piece1);
        }

        if (!File::exists($chemin2)) {
            
            File::put($chemin2,$piece2);
        }

        if (!File::exists($chemin3)) {
            
            File::put($chemin3,$piece3);
        }

        if (!File::exists($chemin5)) {
            
            File::put($chemin5,$piece5);
        }

        File::append($chemin4 , $piece4);
        /////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////////


          $sourcePath = base_path('vendor/hoggarcrud/hoggar/Fichiers/WizardFiles');
       
          $temp = 'resources/js/Pages/HoggarPages/Crud/' . $request->model ;
  
          $directory = base_path($temp);
  
          File::copyDirectory($sourcePath, $directory);
  
          if (!File::exists($directory)) {
              return response()->json(['error' => 'Dossier non trouvé.'], 404);
          }
      
          // Récupère tous les fichiers (même dans les sous-dossiers)
          $files = File::allFiles($directory);
      
          foreach ($files as $file) {
              if ($file->getExtension() === 'txt') {
                  // Nouveau nom avec extension .vue
                  $newFileName = str_replace('.txt', '.vue', $file->getFilename());
      
                  // Nouveau chemin complet
                  $newFilePath = $file->getPath() . '/' . $newFileName;
      
                  // Renommer le fichier
                  File::move($file->getPathname(), $newFilePath);
              }
          }


        $crud = new \Hoggarcrud\Hoggar\Models\Hoggarcrud() ;
        $crud->model  =  $request->model;
        $crud->label  = $transformString->transformLink($request->model) ;
        $crud->route  = '/admin/' .  $transformString->transformUrl($request->model) ;
        $crud->icon  = 'description' ;
        $crud->active  = true ;
        $crud->save()  ;

    }

    
}