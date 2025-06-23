<?php

namespace Hoggarcrud\Hoggar\Utils;
use Illuminate\Support\Str;

class WizardPart
{
   public $piece1;
   public $piece2;
   public $piece3 ;
   public $piece4;

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
use Hoggarcrud\Hoggar\Generator\WizardCreate;
use Illuminate\Database\Eloquent\Collection;
use Hoggarcrud\Hoggar\Fields\TextInput;
use Hoggarcrud\Hoggar\Fields\Number;

class CreatorController extends WizardCreate
{
    
    public   \$hoggarDataModelLabel = '$b' ;
    public   \$hoggarDataModelTitle = 'Create $b' ;
    public   \$hoggarDataRouteListe = '/admin/$c';
    public   \$hoggarModelClass = 'App\Models\\$a';
    public   \$hoggarModelClassName = '$a';
    public   \$hoggarDataUrlCreate = '/admin/$c/create' ;
    public   \$hoggarValidationUrl = '/admin/$c/create/validation' ;

    public   \$hoggarShowOther = true ;
    public   \$wizardCount = 2 ;
    public   \$wizardForm = [1 => ['name'], 2 => ['age']];
    public   \$wizardLabel = [1 => 'first', 2 => 'second'];
    public   \$wizardStop = [];


    
    public function initField()
    {

        \$this->form([
             TextInput::make('name'),
             Number::make('age'),
         ]); 
        
    }

    public function store(Request \$request)
    {  

        if (\$request->wizardStep == 1) {
            \$request->validate(['name' => ['required']]);
        }

        if (\$request->wizardStep == 2) {
            \$request->validate(['age' => ['required']]);
        }

        \$this->hoggarRecord = new  \$this->hoggarModelClass; 

        if (\$request->saveActive == 'yes') {
            \$this->createRecord( \$request);
            \$this->hoggarRecord->save();
        }
        
        
    }


    public function index(Request \$request)
    {
       
        return Inertia::render('HoggarPages/Crud/$a/Creator', [
            'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
            'user' => Auth::user(),
            'hoggarInputs'  => \$this->hoggarInputs ,
            'hoggarSettings'  => \$this->hoggarSettings,
            'wizardForm' => \$this->wizardForm,
            'wizardLabel' => \$this->wizardLabel,
            'wizardCount' => \$this->wizardCount,
            'wizardStop' => \$this->wizardStop,
        ]);
    }

}

    
       ";

    return $this->piece1 ;

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
use Hoggarcrud\Hoggar\Fields\Number;

class UpdatorController extends HoggarUpdate
{

    public   \$hoggarDataModelLabel = '$b' ;
    public   \$hoggarDataModelTitle = 'Update $b' ;
    public   \$hoggarDataRouteListe = '/admin/$c';
    public   \$hoggarModelClass = 'App\Models\\$a';
    public   \$hoggarModelClassName = '$a';
    public   \$hoggarDataUrlCreate = '/admin/$c/create' ;
    public   \$hoggarValidationUrl = '/admin/$c/updator/validation' ;

    public   \$wizardCount = 2 ;
    public   \$wizardForm = [1 => ['name'], 2 => ['age']];
    public   \$wizardLabel = [1 => 'first', 2 => 'second'];
    public   \$wizardStop = [];

    public function initField()
    {   
         \$this->form([
             TextInput::make('name'),
             Number::make('age'),
         ]); 
    }


    public function store(Request \$request)
     {
        
        if (\$request->wizardStep == 1) {
            \$request->validate(['name' => ['required']]);
        }

        if (\$request->wizardStep == 2) {
            \$request->validate(['age' => ['required']]);
        }

        \$this->hoggarRecord = \$this->hoggarModelClass::find(\$request->id);

        if (\$request->saveActive == 'yes' && \$this->hoggarRecord) {
            \$this->updateRecord(\$request);
            \$this->hoggarRecord->save();
        }
       

     }


     public function checkRecord(Request \$request)
{
      return \$this->hoggarcheckRecord(\$request) ;
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
        'hoggarRecordInput' => \$this->hoggarRecordInput,
        'hoggarInputs'  => \$this->hoggarInputs ,
        'hoggarSettings'  => \$this->hoggarSettings,
        'wizardForm' => \$this->wizardForm,
        'wizardLabel' => \$this->wizardLabel,
        'wizardCount' => \$this->wizardCount,
        'wizardStop' => \$this->wizardStop,
    ]);
}

   
}
    
    ";

    return $this->piece2 ;

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
use Hoggarcrud\Hoggar\Filters\FilterText;
use Hoggarcrud\Hoggar\Actions\Action ;
use Hoggarcrud\Hoggar\Customs\CustomAction ;

class ListingController extends Listing
{
  
    public   \$hoggarDataModelLabel = '$b' ;
    public   \$hoggarDataModelTitle = 'Create $b' ;
    public   \$hoggarDataRouteListe = '/admin/$c';
    public   \$hoggarModelClass = 'App\Models\\$a';
    public   \$hoggarModelClassName = '$a';
    public   \$hoggarDataUrlCreate = '/admin/$c/create' ;
    public   \$hoggarDataUrlCheckRecord = '/admin/$c/CheckRecord' ;
    public   \$urlDelete = '/admin/$c/delete';
    public   \$paginationPerPageList = [1,2,3,4] ;
    public   \$orderByFieldList = ['id'] ;
    public   \$orderDirectionList = ['asc','desc'] ;
    public   \$sessionFilter = [/*'search','paginationPerPage','orderByField','orderDirection' */] ;
   

    public function customFilterList(Request \$request)
        {
            \$this->filterList([
                FilterText::make('name'),
            ]);
            
        }

    public function initQuery(Request \$request) {
            if (\$request->filled('name')) {
            //    \$this->queryFilter = \$this->queryFilter->where('name',\$request->name);
            }
            }
  
    
    public function initAction(Request \$request)
        {
           \$this->ActionList([
               Action::make('action1')
                 ->params([
                    'label' => 'Ajouter',
                    'icon' => 'description',
                    'class' => 'text-[red]',
                    'url' => '/admin/$c/action1',
                    'confirmation' => 'voulez-vous Ajouter ces records',
                    'message' => 'records ajoutés'
                 ])
            ]);
        }

    public function action1(Request \$request)
        {  

        \$this->hoggarModelClass::whereIn('id',\$request->actionIds )->update([
                'name' => 'Fiat',
            ]);

        }


    public function initCustom(Request \$request)
        {
            \$this->CustomActionList([
                CustomAction::make('custom1')
                    ->url('/admin/$c/custom1') 
            ]);
        }


     public function custom1(Request \$request)
        {  

            \$request->validate([
                'name' => ['required'],
            ]);

            \$this->hoggarModelClass::where('id',\$request->id )->update([
                'name' => \$request->name,
            ]);
        } 
    
  
        public function checkRecord(Request \$request)
        {  
           return \$this->hoggarcheckRecord(\$request);
        }    
        
   

    public function delete(Request \$request)
        {  
            \$this->hoggarModelClass::destroy(\$request->id );
        } 



    public function index(Request \$request)
    {
        \$this->allInit(\$request);
       
        return Inertia::render('HoggarPages/Crud/$a/Listing', [
            'items' => \$this->tables,
            'user' => Auth::user(),
            'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
            'hoggarSettings'  => \$this->hoggarSettings,
            'allFilters' => \$this->allFilters,
            'customFilters' => \$this->customFilters,
            'sessionFilter' => \$this->sessionFilter,
            'groupActions' =>  \$this->groupActions ,
            'hoggarDataUrlCheckRecord' => \$this->hoggarDataUrlCheckRecord,
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