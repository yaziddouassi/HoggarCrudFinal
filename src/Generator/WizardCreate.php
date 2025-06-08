<?php

namespace Hoggarcrud\Hoggar\Generator;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class WizardCreate extends Controller
{
   
    public $hoggarSettings = [] ;
    public $hoggarInputs = [] ;
  
    public $tabFields = [];
    public $tabLabels = [];
    public $tabTypes = [];
    public $tabOptions = [];
    public $tabValues = [];
    public $tabDefaultValues = [];
    public $tabNodatabases = [];
    public $tabNullables = [];
    public $tabRepeaters = [];
    public $tabRepeaterFields = [];
    public $arrayTypes1 = ['Text','Date','Number','Hidden','Select','Radio','Textarea'];
    public $arrayTypes2 = ['Quill'];
    public $arrayTypes3 = ['File','Image','Video','Audio'];
    public $arrayTypes4 = ['FileEdit','ImageEdit','VideoEdit','AudioEdit'];
    public $arrayTypes5 = ['MultipleFile','MultipleImage','MultipleVideo','MultipleAudio'];
    public $arrayTypes6 = ['CheckboxList'];
    public $arrayTypes7 = ['Checkbox'];
    public $arrayTypes8 = ['Password'];
    public $arrayTypes9 = ['Repeater'];
    public $hoggarRecord = null;
   
    function __construct() {
        $this->hoggarSettings['hoggarShowOther'] =       $this->hoggarShowOther ;
        $this->hoggarSettings['hoggarDataModelLabel'] =  $this->hoggarDataModelLabel ;
        $this->hoggarSettings['hoggarDataModelTitle'] =  $this->hoggarDataModelTitle ;
        $this->hoggarSettings['hoggarDataRouteListe'] =  $this->hoggarDataRouteListe ;
        $this->hoggarSettings['hoggarDataUrlCreate'] =   $this->hoggarDataUrlCreate ;
        $this->hoggarSettings['hoggarModelClass'] =      $this->hoggarModelClass ;
        $this->hoggarSettings['hoggarModelClassName'] =  $this->hoggarModelClassName ;
        $this->hoggarSettings['hoggarValidationUrl']=    $this->hoggarValidationUrl ;
        $this->initField();
        $this->initHoggarInputs() ;
        
    }

    public function initHoggarInputs() {

        $this->hoggarInputs['hoggarDataUrlStorage'] =  env('HOGGAR_STORAGE_URL');
        $this->hoggarInputs['hoggarDataFields'] = $this->tabFields ;
        $this->hoggarInputs['hoggarDataLabels'] = $this->tabLabels ;
        $this->hoggarInputs['hoggarDataTypes'] = $this->tabTypes ;
        $this->hoggarInputs['hoggarDataValues'] = $this->tabValues ;
        $this->hoggarInputs['hoggarDataDefaultValues'] = $this->tabDefaultValues ;
        $this->hoggarInputs['hoggarDataOptions'] = $this->tabOptions ;
        $this->hoggarInputs['hoggarDataNullables'] = $this->tabNullables ;
        $this->hoggarInputs['hoggarNoDatabases'] = $this->tabNodatabases ;
        $this->hoggarInputs['hoggarRepeaters'] = $this->tabRepeaters ;
        $this->hoggarInputs['hoggarRepeaterFields'] = $this->tabRepeaterFields ;

    }


     public function form(array $fields): void
{

    foreach ($fields as $field) {

         $field->registerTo($this);   
 
    }


}



    public function createRecord(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if (array_key_exists($key, $this->tabFields) && !array_key_exists($key, $this->tabNodatabases)) {
                if (in_array($this->tabTypes[$key], $this->arrayTypes3)) {
                    // Handle single file uploads
                    if ($request->hasFile($key)) {
                        $file = $request->file($key);
                        $uniqueName = Str::uuid() . '.' . $file->getClientOriginalName();
                        $file->storeAs('uploads', $uniqueName, env('HOGGAR_STORAGE_DISK'));
                        $path = 'uploads/' . $uniqueName ;
                        $this->hoggarRecord->$key = $path;
                    }
                } elseif (in_array($this->tabTypes[$key], $this->arrayTypes5)) {
                    // Handle multiple file uploads
                    $temp = [];
                    if ($request->hasFile($key)) {
                        foreach ($request->file($key) as $file) {
                            $uniqueName = Str::uuid() . '.' . $file->getClientOriginalName();
                            $file->storeAs('uploads', $uniqueName, env('HOGGAR_STORAGE_DISK'));
                            $path = 'uploads/' . $uniqueName ;
                            $temp[] = $path;
                        }
                    }
                    $this->hoggarRecord->$key = json_encode($temp);
                } elseif (in_array($this->tabTypes[$key], $this->arrayTypes1)) {
                    $this->hoggarRecord->$key = $value;
                }

                elseif (in_array($this->tabTypes[$key], $this->arrayTypes2)) {
                $this->hoggarRecord->$key = $value;
               }
               
               elseif (in_array($this->tabTypes[$key], $this->arrayTypes6)) {
                $this->hoggarRecord->$key = is_array($value) ? json_encode($value) : json_encode(explode(',', $value));
               }
               elseif (in_array($this->tabTypes[$key], $this->arrayTypes7)) {
                
                if($value == 'true') {
                    $value2 = true;
                 }
                 if($value == 'false') {
                    $value2 = false;
                 } 
                 $this->hoggarRecord->$key = $value2;    
               }

               elseif (in_array($this->tabTypes[$key], $this->arrayTypes8)) {
                if($value) {
                  $this->hoggarRecord->$key = Hash::make($value);
                }
             }


            elseif (in_array($this->tabTypes[$key], $this->arrayTypes9)) {
    $cleanedRepeater = [];

    foreach ($value as $repeaterItem) {
        $cleanedItem = [];

        foreach ($repeaterItem as $subKey => $subValue) {
            $subType = $this->tabRepeaterFields[$key][$subKey]['type'] ?? null;

            if ($subType === 'CheckboxList') {
                // ✅ NE PAS utiliser json_encode ici
                $cleanedItem[$subKey] = is_array($subValue) ? $subValue : explode(',', $subValue);
            }
            else {
                $cleanedItem[$subKey] = $subValue;
            }


        }

        $cleanedRepeater[] = $cleanedItem;
    }

    // ✅ On encode seulement à la fin
    $this->hoggarRecord->$key = json_encode($cleanedRepeater);
}






            }
        }
    }



    public function initAll(Request $request) {
    
       
    }

    
}