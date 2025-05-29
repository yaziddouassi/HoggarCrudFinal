import { usePage } from '@inertiajs/vue3'
import { HoggarInfo } from '@/HoggarLibs/stores/hoggarinfo'
import { HoggarListing } from '@/HoggarLibs/stores/hoggarlisting'
import { HoggarInput } from '@/HoggarLibs/stores/hoggarinput';
import { HoggarUpdate } from '@/HoggarLibs/stores/hoggarupdate';

import { router } from '@inertiajs/vue3';



export function updateService() {

  const page = usePage()
  const hoggarinfo = HoggarInfo();
  const hoggarinput = HoggarInput();
  const hoggarupdate = HoggarUpdate();
  const hoggarlisting = HoggarListing()



  function setSettings() {
   
    hoggarinfo.setRoutes(page.props.routes)
   
    hoggarlisting.resetActionIds()
// Initialize form values
hoggarinput.hogarRecordInput = page.props.hogarRecordInput;
hoggarinput.hogarDataUrlStorage = page.props.hogarInputs.hogarDataUrlStorage;
hoggarinput.hogarDataDefaultValues = page.props.hogarInputs.hogarDataDefaultValues;
hoggarinput.hogarDataValues = page.props.hogarInputs.hogarDataValues;
hoggarinput.hogarDataFields = page.props.hogarInputs.hogarDataFields;
hoggarinput.hogarDataTypes = page.props.hogarInputs.hogarDataTypes;
hoggarinput.hogarDataOptions = page.props.hogarInputs.hogarDataOptions;
hoggarinput.hogarDataLabels = page.props.hogarInputs.hogarDataLabels;
hoggarinput.hogarDataNullables = page.props.hogarInputs.hogarDataNullables;
hoggarinput.hogarNoDatabases = page.props.hogarInputs.hogarNoDatabases;

hoggarinput.setRepeaterLines2(page.props.hogarInputs.hogarRepeaters,
                           page.props.hogarInputs.hogarDataValues,page.props.hogarInputs.hogarRepeaterFields);

hoggarinput.initTempUrls();
hoggarupdate.setSettings(page.props.hogarSettings);

let currentRoute = hoggarinfo.routes.find(item => item.model === page.props.hogarSettings.hogarModelClassName)?.route;
if(currentRoute == undefined) {
  currentRoute = page.props.hogarSettings.hogarDataRouteListe
}



    console.log(page.props)
  }



function cleanQuillContent(html) {
  if (typeof html !== 'string') return html;
  return html.replace(/<p>\s*<\/p>/g, '').replace(/<p><br><\/p>/g, '').trim();
}

function checkNullable() {
  let temoin = 0;

  Object.keys(hoggarinput.hogarDataNullables).forEach((champ) => {
    const existing = hoggarinput.existingFiles[champ] || [];
    const temps = hoggarinput.tempUrlTabs[champ] || [];

    if (existing.length === 0 && temps.length === 0) {
      temoin++;
      console.log(`Champ requis vide : ${champ}`);
    }
  });

  return temoin;
}




function update() {

const temoin = checkNullable();

if (temoin > 0) {
  const notyf = new Notyf({ position: { x: 'right', y: 'top' } });
  notyf.error(`${temoin} fields(s) required are missing(s).`);
  return;
}

  let currentRoute = hoggarinfo.routes.find(item => item.model === page.props.hogarSettings.hogarModelClassName)?.route;
if(currentRoute == undefined) {
  currentRoute = page.props.hogarSettings.hogarDataRouteListe
}


  const formData = new FormData();
 
  Object.keys(hoggarinput.hogarDataValues).forEach((key) => {
    const value = hoggarinput.hogarDataValues[key];
    
   const tab1 = ['MultipleFileEdit','MultipleImageEdit','MultipleVideoEdit','MultipleAudioEdit']
    if (tab1.includes(hoggarinput.hogarDataTypes[key])) {
    if(!value || value.length === 0) {
      formData.append(key, '');
    }
    else if (Array.isArray(value)) {
      value.forEach((file, index) => {
        formData.append(`${key}[]`, file);
      });
    }
     const  temp = JSON.parse(hoggarinput.hogarRecordInput[key] || '[]');
     const index = key + '_newtab'
      formData.append(index, JSON.stringify(temp));
    } 
    
    const tab2 = ['FileEdit','ImageEdit','VideoEdit','AudioEdit'];
    if(tab2.includes(hoggarinput.hogarDataTypes[key])) {
      formData.append(key, value);
    }

    const tab3 = ['Text','Date','Hidden','Select','Number','Radio','Checkbox','CheckboxList','Password','Textarea'];
    if(tab3.includes(hoggarinput.hogarDataTypes[key])) {
      formData.append(key, value);
    }

     const tab4 = ['Quill'];
    if(tab4.includes(hoggarinput.hogarDataTypes[key])) {
      formData.append(key, cleanQuillContent(value || ''));
    }

    if (hoggarinput.hogarDataTypes[key] === 'Repeater' && Array.isArray(value)) {
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

 
  router.post(hoggarupdate.settings.hogarValidationUrl, formData, {
    forceFormData: true,
    onError: (errors) => {
      hoggarinput.setError(errors);
    },
    onSuccess: () => {
      router.get(currentRoute);
    }
  });
}

 

  return {
    setSettings,
    update
  }
}