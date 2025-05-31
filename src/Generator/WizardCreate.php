<?php

namespace Hoggarcrud\Hoggar\Generator;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class WizardCreate extends Controller
{
   
   public $hogarSettings = [] ;
    public $hogarInputs = [] ;
  
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
    public $hogarRecord = null;
   
    function __construct() {
        $this->hogarSettings['hogarShowOther'] = $this->hogarShowOther ;
        $this->hogarSettings['hogarDataModelLabel'] =  $this->hogarDataModelLabel ;
        $this->hogarSettings['hogarDataModelTitle'] =  $this->hogarDataModelTitle ;
        $this->hogarSettings['hogarDataRouteListe'] =  $this->hogarDataRouteListe ;
        $this->hogarSettings['hogarDataUrlCreate'] =  $this->hogarDataUrlCreate ;
        $this->hogarSettings['hogarModelClass'] =  $this->hogarModelClass ;
        $this->hogarSettings['hogarModelClassName'] =  $this->hogarModelClassName ;
        $this->hogarSettings['hogarValidationUrl']=  $this->hogarValidationUrl ;
        $this->initField();
        $this->initHogarInputs() ;
        
    }

    public function initHogarInputs() {

        $this->hogarInputs['hogarDataUrlStorage'] =  config('hoggar.urlstorage');
        $this->hogarInputs['hogarDataFields'] = $this->tabFields ;
        $this->hogarInputs['hogarDataLabels'] = $this->tabLabels ;
        $this->hogarInputs['hogarDataTypes'] = $this->tabTypes ;
        $this->hogarInputs['hogarDataValues'] = $this->tabValues ;
        $this->hogarInputs['hogarDataDefaultValues'] = $this->tabDefaultValues ;
        $this->hogarInputs['hogarDataOptions'] = $this->tabOptions ;
        $this->hogarInputs['hogarDataNullables'] = $this->tabNullables ;
        $this->hogarInputs['hogarNoDatabases'] = $this->tabNodatabases ;
        $this->hogarInputs['hogarRepeaters'] = $this->tabRepeaters ;
        $this->hogarInputs['hogarRepeaterFields'] = $this->tabRepeaterFields ;

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
                        $file->storeAs('uploads', $uniqueName, 'public');
                        $path = 'uploads/' . $uniqueName ;
                        $this->hogarRecord->$key = $path;
                    }
                } elseif (in_array($this->tabTypes[$key], $this->arrayTypes5)) {
                    // Handle multiple file uploads
                    $temp = [];
                    if ($request->hasFile($key)) {
                        foreach ($request->file($key) as $file) {
                            $uniqueName = Str::uuid() . '.' . $file->getClientOriginalName();
                            $file->storeAs('uploads', $uniqueName, 'public');
                            $path = 'uploads/' . $uniqueName ;
                            $temp[] = $path;
                        }
                    }
                    $this->hogarRecord->$key = json_encode($temp);
                } elseif (in_array($this->tabTypes[$key], $this->arrayTypes1)) {
                    $this->hogarRecord->$key = $value;
                }

                elseif (in_array($this->tabTypes[$key], $this->arrayTypes2)) {
                $this->hogarRecord->$key = $value;
               }
               
               elseif (in_array($this->tabTypes[$key], $this->arrayTypes6)) {
                $this->hogarRecord->$key = is_array($value) ? json_encode($value) : json_encode(explode(',', $value));
               }
               elseif (in_array($this->tabTypes[$key], $this->arrayTypes7)) {
                
                if($value == 'true') {
                    $value2 = true;
                 }
                 if($value == 'false') {
                    $value2 = false;
                 } 
                 $this->hogarRecord->$key = $value2;    
               }

               elseif (in_array($this->tabTypes[$key], $this->arrayTypes8)) {
                if($value) {
                  $this->hogarRecord->$key = Hash::make($value);
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
    $this->hogarRecord->$key = json_encode($cleanedRepeater);
}






            }
        }
    }



    public function initAll(Request $request) {
    
       
    }

    
}