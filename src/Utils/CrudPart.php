<?php

namespace Hoggarcrud\Hoggar\Utils;
use Illuminate\Support\Str;

class CrudPart
{
   public $piece1;
   public $piece2;
   public $piece3 ;
   public $piece4;
   public $piece5;
   public $piece6 ;
   public $piece7;

public function getPiece1($a,$b,$c) {


    $this->piece1 = "<?php

namespace App\Http\Controllers\Hoggar\Crud\\$a;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Hoggarcrud\Hoggar\Generator\HoggarCreate;
use Illuminate\Database\Eloquent\Collection;
use Hoggarcrud\Hoggar\Fields\TextInput;

class CreatorController extends HoggarCreate
{
    public   \$hogarShowOther = true ;
    public   \$hogarDataModelLabel = '$b' ;
    public   \$hogarDataModelTitle = 'Create $b' ;
    public   \$hogarDataRouteListe = '/admin/$c';
    public   \$hogarModelClass = 'App\Models\\$a';
    public   \$hogarModelClassName = '$a';
    public   \$hogarDataUrlCreate = '/admin/$c/create' ;
    public   \$hogarValidationUrl = '/admin/$c/create/validation' ;

    public function initField()
    {

         \$this->form([
             TextInput::make('name'),
         ]); 
    }

    public function store(Request \$request)
    {  
       
        \$request->validate([
            'name' => ['required'],
          ]);
     
       
        \$this->hogarRecord = new \$this->hogarModelClass;
        \$this->createRecord(\$request);
        \$this->hogarRecord->save() ; 
    }


    public function index(Request \$request)
    {

        return Inertia::render('HoggarPages/Crud/$a/Creator', [
            'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
            'user' => Auth::user(),
            'hogarInputs'  => \$this->hogarInputs ,
            'hogarSettings'  => \$this->hogarSettings,
        ]);
    }

}

    ";

    return $this->piece1;
   }



   public function getPiece2($a,$b,$c) {
          $this->piece2 = "<?php

namespace App\Http\Controllers\Hoggar\Crud\\$a;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Hoggarcrud\Hoggar\Generator\HoggarUpdate;
use Illuminate\Database\Eloquent\Collection;
use Hoggarcrud\Hoggar\Fields\TextInput;

class UpdatorController extends HoggarUpdate
{

    public   \$hogarDataModelLabel = '$b' ;
    public   \$hogarDataModelTitle = 'Update $b' ;
    public   \$hogarDataRouteListe = '/admin/$c';
    public   \$hogarModelClass = 'App\Models\\$a';
    public   \$hogarModelClassName = '$a';
    public   \$hogarDataUrlCreate = '/admin/$c/create' ;
    public   \$hogarValidationUrl = '/admin/$c/updator/validation' ;


    public function initField()
    {   
         \$this->form([
             TextInput::make('name'),
         ]); 
    }


    public function store(Request \$request)
     {

        \$request->validate([
            'name' => ['required'],
          ]);
        
         \$this->hogarRecord = \$this->hogarModelClass::find(\$request->id);
      
       
         if (\$this->hogarRecord != null) {
            \$this->updateRecord(\$request);
            \$this->hogarRecord->save() ;
         }
         

     }


     public function checkRecord(Request \$request)
{
    \$Record = \$this->hogarModelClass::find(\$request->id);
    
    if (\$Record === null) {
        return redirect(\$this->hogarDataRouteListe); // Return the redirection
    }

    \$this->hogarRecordInput = new Collection();
    \$this->hogarRecordInput = \$Record;

    return null; // Return null to indicate no redirection needed
}

public function index(Request \$request)
{
   
    \$redirect = \$this->checkRecord(\$request);

    if (\$redirect) {
        return \$redirect; // Ensure redirection is returned
    }

    \$this->initFieldAgain();
    
 

    return Inertia::render('HoggarPages/Crud/$a/Updator', [
        'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
        'user' => Auth::user(),
        'hogarRecordInput' => \$this->hogarRecordInput,
        'hogarInputs'  => \$this->hogarInputs ,
        'hogarSettings'  => \$this->hogarSettings,
    ]);
}

   
}
          
          ";

          return $this->piece2;
   }


   
   public function getPiece3($a,$b,$c) {

      $this->piece3 = "<?php

namespace App\Http\Controllers\Hoggar\Crud\\$a;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Hoggarcrud\Hoggar\Generator\Listing;
use Illuminate\Database\Eloquent\Collection;

class ListingController extends Listing
{
  
    public   \$hogarDataModelLabel = '$b' ;
    public   \$hogarDataModelTitle = 'Create $b' ;
    public   \$hogarDataRouteListe = '/admin/$c';
    public   \$hogarModelClass = 'App\Models\\$a';
    public   \$hogarModelClassName = '$a';
    public   \$hogarDataUrlCreate = '/admin/$c/create' ;
    public   \$hogarDataUrlCheckRecord = '/admin/$c/CheckRecord' ;
    public   \$urlDelete = '/admin/$c/delete';
    public   \$paginationPerPageList = [1,2,3,4] ;
    public   \$orderByFieldList = ['id'] ;
    public   \$orderDirectionList = ['asc','desc'] ;
    public   \$sessionFilter = [/*'search','paginationPerPage','orderByField','orderDirection' */] ;
   

    public function customFilterList(Request \$request)
        {
            \$this->addFilter('Text',['field' => 'name']);
            
        }

    public function initQuery(Request \$request) {
            if (\$request->filled('name')) {
            //    \$this->queryFilter = \$this->queryFilter->where('name',\$request->name);
            }
            }
  
    
    public function initAction(Request \$request)
        {
            \$this->addAction('action1',
            ['label'=> 'Ajouter','icon' => 'description','class' => 'text-[red]',
            'url' => '/admin/$c/action1',
            'confirmation' => 'voulez-vous Ajouter ces records' ,
            'message' => 'records ajouter' ]);
        }

    public function action1(Request \$request)
        {  

        \$this->hogarModelClass::whereIn('id',\$request->actionIds )->update([
                'name' => 'Fiat',
            ]);

        }
    

    public function initCustom(Request \$request)
        {
            \$this->addCustom('custom1','/admin/$c/custom1');
        }
    
  
        public function checkRecord(Request \$request)
        {  
            \$record = \$this->hogarModelClass::find(\$request->id) ;

            if (!\$record) {
                return response()->json([
                    'success' => false,
                    'data' => [],
                    'message' => 'Enregistrement introuvable.',
                ], 404);
            }
        
            return response()->json([
                'success' => true,
                'data' => \$record,
            ]);


        }    
        
    public function custom1(Request \$request)
        {  

            \$request->validate([
                'name' => ['required'],
            ]);

            \$this->hogarModelClass::where('id',\$request->id )->update([
                'name' => \$request->name,
            ]);
        } 

    public function delete(Request \$request)
        {  
            \$this->hogarModelClass::destroy(\$request->id );
        } 



    public function index(Request \$request)
    {
        \$this->allInit(\$request);
       
        return Inertia::render('HoggarPages/Crud/$a/Listing', [
            'items' => \$this->tables,
            'user' => Auth::user(),
            'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
            'hogarSettings'  => \$this->hogarSettings,
            'allFilters' => \$this->allFilters,
            'customFilters' => \$this->customFilters,
            'sessionFilter' => \$this->sessionFilter,
            'groupActions' =>  \$this->groupActions ,
            'hogarDataUrlCheckRecord' => \$this->hogarDataUrlCheckRecord,
            'customs' => \$this->customs,
        ]);
    }

    
}
      
      
      ";

      return $this->piece3;
      }



      public function getPiece4($a,$b,$c) {

           $this->piece4 = " 
Route::get('/admin/$c', [\App\Http\Controllers\Hoggar\Crud\\$a\ListingController::class, 'index'])->middleware('$b');
Route::get('/admin/$c/create', [\App\Http\Controllers\Hoggar\Crud\\$a\CreatorController::class, 'index'])->middleware('$b');
Route::post('/admin/$c/create/validation', [\App\Http\Controllers\Hoggar\Crud\\$a\CreatorController::class, 'store'])->middleware('$b');
Route::get('/admin/$c/update/{id}', [\App\Http\Controllers\Hoggar\Crud\\$a\UpdatorController::class, 'index'])->middleware('$b');
Route::post('/admin/$c/updator/validation', [\App\Http\Controllers\Hoggar\Crud\\$a\UpdatorController::class, 'store'])->middleware('$b');
Route::post('/admin/$c/delete', [\App\Http\Controllers\Hoggar\Crud\\$a\ListingController::class, 'delete'])->middleware('$b');
Route::post('/admin/$c/CheckRecord', [\App\Http\Controllers\Hoggar\Crud\\$a\ListingController::class, 'checkRecord'])->middleware('$b');
Route::post('/admin/$c/action1', [\App\Http\Controllers\Hoggar\Crud\\$a\ListingController::class, 'action1'])->middleware('$b');
Route::post('/admin/$c/custom1', [\App\Http\Controllers\Hoggar\Crud\\$a\ListingController::class, 'custom1'])->middleware('$b');
           " ; 


           return $this->piece4;
      }



     public function getPiece5($a,$b,$c) {


    $this->piece5 = "<?php

namespace App\Http\Controllers\Hoggar\Crud\\$a\Customs;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class Page1Controller extends Controller
{

    public function index(Request \$request)
    {

        return Inertia::render('HoggarPages/Crud/$a/Customs/Page1', [
            'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
            'user' => Auth::user(),
        ]);
    }

}

    ";

    return $this->piece5;
   }







}