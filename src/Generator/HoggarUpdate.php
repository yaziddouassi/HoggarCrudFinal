<?php

namespace Hoggarcrud\Hoggar\Generator;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class HoggarUpdate extends Controller
{

    public $hogarSettings = [] ;
    public $hogarInputs = [] ;
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
    public $arrayTypes9 = ['Repeater'];
    public $hogarRecord = null;
   
    function __construct() {
        
        $this->hogarSettings['hogarDataModelLabel'] =  $this->hogarDataModelLabel ;
        $this->hogarSettings['hogarDataModelTitle'] =  $this->hogarDataModelTitle ;
        $this->hogarSettings['hogarDataRouteListe'] =  $this->hogarDataRouteListe ;
        $this->hogarSettings['hogarDataUrlCreate'] =  $this->hogarDataUrlCreate ;
        $this->hogarSettings['hogarModelClass'] =  $this->hogarModelClass ;
        $this->hogarSettings['hogarModelClassName'] =  $this->hogarModelClassName ;
        $this->hogarSettings['hogarValidationUrl']=  $this->hogarValidationUrl ;
        $this->initField();
       
        $this->initHogarInputs();
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

    public function addRepeater($a) {

         if($a['addLine'] === true) {
        $a['addLine'] = 'yes';
        }

        elseif($a['addLine'] !== true) {
        $a['addLine'] = 'no';
        }

        if($a['draggable'] === true) {
        $a['draggable'] = 'yes';
        }

        elseif($a['draggable'] !== true) {
        $a['draggable'] = 'no';
        }

        if($a['removeLine'] === true) {
        $a['removeLine'] = 'yes';
        }

        elseif($a['removeLine'] !== true) {
        $a['removeLine'] = 'no';
        }



        $this->tabFields[$a['field']] = $a['field'] ;
        $this->tabLabels[$a['field']] = ucfirst($a['field']);
        $this->tabTypes[$a['field']] = 'Repeater';
        $this->tabOptions[$a['field']] = $a;
        $this->tabRepeaters[$a['field']] = $a;
    }


    public function repeaterField($a,$b) {

       $this->tabRepeaterFields[$a][$b['field']] = $b ;

    }


    public function setFieldNodatabase($a) {

           $this->tabNodatabases[$a] = $a;

    }


    public function setFieldNotNullable($a) {
        
           $this->tabNullables[$a] = $a;

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
                            $file->storeAs('uploads', $uniqueName, 'public');
                            $path = 'uploads/' . $uniqueName ;
                            
                            $this->hogarRecord->$key = $path;
                            
                        }
                    }
                   
                }


                elseif (in_array($this->tabTypes[$key], $this->arrayTypes5)) { 
                 $tab1 = json_decode($request->input($key . '_newtab')) ;

                 if($value) {
                    foreach ($value as $file) {
                      
                        $uniqueName = Str::uuid() . '.' . $file->getClientOriginalName();
                        $path = $file->storeAs('uploads', $uniqueName, 'public');
                        array_push($tab1, $path);
                    }
                 }
                 
                $this->hogarRecord->$key = json_encode($tab1) ;
                   
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
}


    
    public function initFieldAgain() {

        $this->addField('Hidden',['field' => 'id']);
        $this->setFieldValue('id',$this->hogarRecordInput->id);
        $this->initHogarInputs();

       foreach ($this->tabFields as $cle => $value) {
        if (!array_key_exists($cle,$this->tabNodatabases)) { 
            
                 if (in_array($this->tabTypes[$cle], $this->arrayTypes4)) {

                    $this->tabValues[$cle] = '';
                    $this->tabDefaultValues[$cle] = '';
                    $this->initHogarInputs();
                }  

                else if (in_array($this->tabTypes[$cle], $this->arrayTypes5))  {

                    $this->tabValues[$cle] = [];
                    $this->tabDefaultValues[$cle] = [];
                    $this->initHogarInputs();

                }
                else if (in_array($this->tabTypes[$cle], $this->arrayTypes1))  {

                    $this->tabValues[$cle] = $this->hogarRecordInput[$cle];
                    $this->tabDefaultValues[$cle] = $this->hogarRecordInput[$cle];
                    $this->initHogarInputs();

                }
            
                else if (in_array($this->tabTypes[$cle], $this->arrayTypes2))  {

                    $this->tabValues[$cle] = $this->hogarRecordInput[$cle];
                    $this->tabDefaultValues[$cle] = $this->hogarRecordInput[$cle];
                    $this->initHogarInputs();

                }

                else if (in_array($this->tabTypes[$cle], $this->arrayTypes6))  {

                    $this->tabValues[$cle] = $this->hogarRecordInput[$cle];
                    $this->tabDefaultValues[$cle] = $this->hogarRecordInput[$cle];
                    $this->initHogarInputs();

                }

                else if (in_array($this->tabTypes[$cle], $this->arrayTypes7))  {

                    $this->tabValues[$cle] = $this->hogarRecordInput[$cle];
                    $this->tabDefaultValues[$cle] = $this->hogarRecordInput[$cle];
                    $this->initHogarInputs();

                }


                 
else if (in_array($this->tabTypes[$cle], $this->arrayTypes9)) {
    $raw = json_decode($this->hogarRecordInput[$cle], true); // les repeaters sont souvent en JSON
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
    $this->initHogarInputs();
}





        

           }  
       }
       
    } 
    
    
}