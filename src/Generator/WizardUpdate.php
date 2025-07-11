<?php

namespace Hoggarcrud\Hoggar\Generator;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class WizardUpdate extends Controller
{
   
    public $hoggarSettings = [] ;
    public $hoggarInputs = [] ;
    public $tabFields = [];
    public $tabLabels = [];
    public $tabTypes = [];
    public $tabOptions = [];
    public $tabValues = [];
    public $tabDefaultValues = [];
    public $tabRepeaters = [];
    public $tabRepeaterFields = [];
    public $tabNodatabases = ['id'];
    public $tabNullables = [];
    public $arrayTypes1 = ['Text','Date','Number','Hidden','Select','Radio','Textarea'];
    public $arrayTypes2 = ['Quill'];
    public $arrayTypes4 = ['FileEdit','ImageEdit','VideoEdit','AudioEdit'];
    public $arrayTypes5 = ['MultipleFileEdit','MultipleImageEdit','MultipleVideoEdit','MultipleAudioEdit'];
    public $arrayTypes6 = ['CheckboxList'];
    public $arrayTypes7 = ['Checkbox'];
    public $arrayTypes8 = ['Password'];
    public $hoggarRecord = null;
   
    function __construct() {
        
        $this->hoggarSettings['hoggarDataModelLabel'] =  $this->hoggarDataModelLabel ;
        $this->hoggarSettings['hoggarDataModelTitle'] =  $this->hoggarDataModelTitle ;
        $this->hoggarSettings['hoggarDataRouteListe'] =  $this->hoggarDataRouteListe ;
        $this->hoggarSettings['hoggarDataUrlCreate'] =   $this->hoggarDataUrlCreate ;
        $this->hoggarSettings['hoggarModelClass'] =      $this->hoggarModelClass ;
        $this->hoggarSettings['hoggarModelClassName'] =  $this->hoggarModelClassName ;
        $this->hoggarSettings['hoggarValidationUrl']=    $this->hoggarValidationUrl ;
        $this->initField();
        $this->initHoggarInputs();
    }

    public function initHoggarInputs() {

        $this->hoggarInputs['hoggarDataUrlStorage'] = config('hoggar.storage_url') ;
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


    public function addField($a,$b) {
        $this->tabFields[$b['field']] = $b['field'] ;
        $this->tabLabels[$b['field']] = ucfirst($b['field']) ;
        $this->tabTypes[$b['field']] = $a;
        $this->tabOptions[$b['field']] = $b;

        if (in_array($a, $this->arrayTypes1)) {
            $this->tabValues[$b['field']] = '';
            $this->tabDefaultValues[$b['field']] = '';
        }

        if (in_array($a, $this->arrayTypes2)) {
            $this->tabValues[$b['field']] = '';
            $this->tabDefaultValues[$b['field']] = '';
        }

        if (in_array($a, $this->arrayTypes4)) {
            $this->tabValues[$b['field']] = '';
            $this->tabDefaultValues[$b['field']] = '';
        }

        if (in_array($a, $this->arrayTypes5)) {
            $this->tabValues[$b['field']] = [];
            $this->tabDefaultValues[$b['field']] = [];
        }

        if (in_array($a, $this->arrayTypes6)) {
            $this->tabValues[$b['field']] = [];
            $this->tabDefaultValues[$b['field']] = [];
        }

        if (in_array($a, $this->arrayTypes7)) {
            $this->tabValues[$b['field']] = false;
            $this->tabDefaultValues[$b['field']] = false;
        }

        if (in_array($a, $this->arrayTypes8)) {
            $this->tabValues[$b['field']] = '';
            $this->tabDefaultValues[$b['field']] = '';
        }

    }

    public function setFieldValue($a,$b) {

        if (in_array($a, $this->tabFields)) {
            $this->tabValues[$a] = $b;
           $this->tabDefaultValues[$a] = $b;
        }

    }



    public function setFieldLabel($a,$b) {

        if (in_array($a, $this->tabFields)) {
            $this->tabLabels[$a] = $b;
         
        }

    }


     


      public function form(array $fields): void
{

    foreach ($fields as $field) {

        $field->updateTo($this); 
     
    }

}



   
    public function updateRecord(Request $request)
{

  
    foreach ($request->all() as $key => $value) {
      
        if (array_key_exists($key, $this->tabFields)) {
            if (!array_key_exists($key, $this->tabNodatabases)) {  
            
                if (in_array($this->tabTypes[$key], $this->arrayTypes4)) {
                   
                    if ($value) {
                        if ($request->hasFile($key)) {
                            $file = $request->file($key);
                            $uniqueName = Str::uuid() . '.' . $file->getClientOriginalName();
                            $file->storeAs('uploads', $uniqueName, config('hoggar.storage_disk'));
                            $path = 'uploads/' . $uniqueName ;
                            
                            $this->hoggarRecord->$key = $path;
                            
                        }
                    }
                   
                }


                elseif (in_array($this->tabTypes[$key], $this->arrayTypes5)) { 
                 $tab1 = json_decode($request->input($key . '_newtab')) ;

                 if($value) {
                    foreach ($value as $file) {
                      
                        $uniqueName = Str::uuid() . '.' . $file->getClientOriginalName();
                        $path = $file->storeAs('uploads', $uniqueName, config('hoggar.storage_disk'));
                        array_push($tab1, $path);
                    }
                 }
                 
                $this->hoggarRecord->$key = json_encode($tab1) ;
                   
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
}


 public function hoggarcheckRecord(Request $request)
{
    $Record = $this->hoggarModelClass::find($request->id);
    
    if ($Record === null) {
        return redirect($this->hoggarDataRouteListe); // Return the redirection
    }

    $this->hoggarRecordInput = new Collection();
    $this->hoggarRecordInput = $Record;

    return null; // Return null to indicate no redirection needed
}

    
    public function initFieldAgain() {

        $this->addField('Hidden',['field' => 'id']);
        $this->setFieldValue('id',$this->hoggarRecordInput->id);
        $this->initHoggarInputs();

       foreach ($this->tabFields as $cle => $value) {
        if (!array_key_exists($cle,$this->tabNodatabases)) { 
            
                 if (in_array($this->tabTypes[$cle], $this->arrayTypes4)) {

                    $this->tabValues[$cle] = '';
                    $this->tabDefaultValues[$cle] = '';
                    $this->initHoggarInputs();
                }  

                else if (in_array($this->tabTypes[$cle], $this->arrayTypes5))  {

                    $this->tabValues[$cle] = [];
                    $this->tabDefaultValues[$cle] = [];
                    $this->initHoggarInputs();

                }
                else if (in_array($this->tabTypes[$cle], $this->arrayTypes1))  {

                    $this->tabValues[$cle] = $this->hoggarRecordInput[$cle];
                    $this->tabDefaultValues[$cle] = $this->hoggarRecordInput[$cle];
                    $this->initHoggarInputs();

                }
            
                else if (in_array($this->tabTypes[$cle], $this->arrayTypes2))  {

                    $this->tabValues[$cle] = $this->hoggarRecordInput[$cle];
                    $this->tabDefaultValues[$cle] = $this->hoggarRecordInput[$cle];
                    $this->initHoggarInputs();

                }
        
                else if (in_array($this->tabTypes[$cle], $this->arrayTypes6))  {

                    $this->tabValues[$cle] = $this->hoggarRecordInput[$cle];
                    $this->tabDefaultValues[$cle] = $this->hoggarRecordInput[$cle];
                    $this->initHoggarInputs();

                }

                else if (in_array($this->tabTypes[$cle], $this->arrayTypes7))  {

                    $this->tabValues[$cle] = $this->hoggarRecordInput[$cle];
                    $this->tabDefaultValues[$cle] = $this->hoggarRecordInput[$cle];
                    $this->initHoggarInputs();

                }



else if (in_array($this->tabTypes[$cle], $this->arrayTypes9)) {
    $raw = json_decode($this->hoggarRecordInput[$cle], true); // les repeaters sont souvent en JSON
    $structured = [];

    if (is_array($raw)) {
        foreach ($raw as $line) {
            $row = [];

            foreach ($this->tabRepeaterFields[$cle] as $subKey => $subField) {
                $row[$subKey] = $line[$subKey] ?? '';

            }

            $structured[] = $row;
        }
    }

    $this->tabValues[$cle] = $structured;
    $this->initHoggarInputs();
}








           }  
       }
       
    }
   
    
}