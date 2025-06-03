import { usePage } from '@inertiajs/vue3'
import { HoggarInfo } from '@/HoggarLibs/stores/hoggarinfo'
import { HoggarInput } from '@/HoggarLibs/stores/hoggarinput';
import { HoggarCreate } from '@/HoggarLibs/stores/hoggarcreate';
import { HoggarListing } from '@/HoggarLibs/stores/hoggarlisting'
import { router } from '@inertiajs/vue3';



export function creationService() {

   const page = usePage()
   const hoggarinfo = HoggarInfo()
   const hoggarinput = HoggarInput();
   const hoggarcreate = HoggarCreate();
   const hoggarlisting = HoggarListing()

  function setSettings() {
   


   hoggarinfo.setRoutes(page.props.routes)
   hoggarlisting.resetActionIds()
// Initialize form values
hoggarinput.hoggarDataUrlStorage = page.props.hoggarInputs.hoggarDataUrlStorage;
hoggarinput.hoggarDataDefaultValues = page.props.hoggarInputs.hoggarDataDefaultValues;
hoggarinput.hoggarDataValues = page.props.hoggarInputs.hoggarDataValues;
hoggarinput.hoggarDataFields = page.props.hoggarInputs.hoggarDataFields;
hoggarinput.hoggarDataTypes = page.props.hoggarInputs.hoggarDataTypes;
hoggarinput.hoggarDataOptions = page.props.hoggarInputs.hoggarDataOptions;
hoggarinput.hoggarDataLabels = page.props.hoggarInputs.hoggarDataLabels;
hoggarinput.hoggarDataNullables = page.props.hoggarInputs.hoggarDataNullables;
hoggarinput.hoggarNoDatabases = page.props.hoggarInputs.hoggarNoDatabases;

hoggarinput.setRepeaterLines(page.props.hoggarInputs.hoggarRepeaters,
                            page.props.hoggarInputs.hoggarRepeaterFields);

hoggarinput.initTempUrls();
hoggarcreate.setSettings(page.props.hoggarSettings);

let currentRoute = hoggarinfo.routes.find(item => item.model === page.props.hoggarSettings.hoggarModelClassName)?.route;
if(currentRoute == undefined) {
  currentRoute = page.props.hoggarSettings.hoggarDataRouteListe
}
   
  }



function cleanQuillContent(html) {
  if (typeof html !== 'string') return html;
  return html.replace(/<p>\s*<\/p>/g, '').replace(/<p><br><\/p>/g, '').trim();
}

function afterCreate1() {
  const notyf = new Notyf({ position: { x: 'right', y: 'top' } });
  notyf.success('Record created');

  let currentRoute = hoggarinfo.routes.find(item => item.model === page.props.hoggarSettings.hoggarModelClassName)?.route;
    if(currentRoute == undefined) {
      currentRoute = page.props.hoggarSettings.hoggarDataRouteListe
    }
  router.get(currentRoute);
}

function afterCreate2() {
  const notyf = new Notyf({ position: { x: 'right', y: 'top' } });
  notyf.success('Record created Other');
  hoggarinput.resetDatas();
  hoggarinput.setRepeaterLines(page.props.hoggarInputs.hoggarRepeaters,page.props.hoggarInputs.hoggarRepeaterFields);
  hoggarinput.resetError();
}

  

// Function to prepare and submit form data
function insert(action) {
 

  const formData = new FormData();

  Object.keys(hoggarinput.hoggarDataValues).forEach((key) => {
    const value = hoggarinput.hoggarDataValues[key];

    const tab1 = ['MultipleFile','MultipleImage','MultipleVideo','MultipleAudio'];
    if (tab1.includes(hoggarinput.hoggarDataTypes[key])) {
     
    if(!value || value.length === 0) {
      formData.append(key, '');
    }
      
    else if (Array.isArray(value)) {
      value.forEach((file, index) => {
        formData.append(`${key}[]`, file);
      });
    }
    }

    const tab2 = ['File','Image','Video','Audio'];
    if(tab2.includes(hoggarinput.hoggarDataTypes[key])) {
      formData.append(key, value);
    }

    const tab3 = ['Text','Date','Hidden','Select','Number','Radio','Checkbox','CheckboxList','Password','Textarea'];
    if(tab3.includes(hoggarinput.hoggarDataTypes[key])) {
      formData.append(key, value);
    }

     const tab4 = ['Quill'];
    if(tab4.includes(hoggarinput.hoggarDataTypes[key])) {
      formData.append(key, cleanQuillContent(value || ''));
    }


    if (hoggarinput.hoggarDataTypes[key] === 'Repeater' && Array.isArray(value)) {
  value.forEach((item, i) => {
    Object.entries(item).forEach(([subKey, subValue]) => {


      if(hoggarinput.repeaterLines[key][i][subKey]['type'] == 'Quill') {
          subValue  = cleanQuillContent(subValue || '')
      }

      formData.append(`${key}[${i}][${subKey}]`, subValue);
    });
  });
}



  });

 
  router.post(hoggarcreate.settings.hoggarValidationUrl, formData, {
    forceFormData: true,
    onError: (errors) => {
      hoggarinput.setError(errors);
      console.error('Validation Errors:', hoggarinput.errors);
    },
    onSuccess: () => {
      if (action === 'creer') {
        afterCreate1();
      } else if (action === 'other') {
        afterCreate2();
      }
    }
  });
}


 function submit(action) {
   insert(action);
  }



  return {
    setSettings,
    submit
  }
}