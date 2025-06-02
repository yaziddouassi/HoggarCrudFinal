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
hoggarinput.hoggarRecordInput = page.props.hoggarRecordInput;
hoggarinput.hoggarDataUrlStorage = page.props.hoggarInputs.hoggarDataUrlStorage;
hoggarinput.hoggarDataDefaultValues = page.props.hoggarInputs.hoggarDataDefaultValues;
hoggarinput.hoggarDataValues = page.props.hoggarInputs.hoggarDataValues;
hoggarinput.hoggarDataFields = page.props.hoggarInputs.hoggarDataFields;
hoggarinput.hoggarDataTypes = page.props.hoggarInputs.hoggarDataTypes;
hoggarinput.hoggarDataOptions = page.props.hoggarInputs.hoggarDataOptions;
hoggarinput.hoggarDataLabels = page.props.hoggarInputs.hoggarDataLabels;
hoggarinput.hoggarDataNullables = page.props.hoggarInputs.hoggarDataNullables;
hoggarinput.hoggarNoDatabases = page.props.hoggarInputs.hoggarNoDatabases;

hoggarinput.setRepeaterLines2(page.props.hoggarInputs.hoggarRepeaters,
                           page.props.hoggarInputs.hoggarDataValues,page.props.hoggarInputs.hoggarRepeaterFields);

hoggarinput.initTempUrls();
hoggarupdate.setSettings(page.props.hoggarSettings);

let currentRoute = hoggarinfo.routes.find(item => item.model === page.props.hoggarSettings.hoggarModelClassName)?.route;
if(currentRoute == undefined) {
  currentRoute = page.props.hoggarSettings.hoggarDataRouteListe
}



    console.log(page.props)
  }



function cleanQuillContent(html) {
  if (typeof html !== 'string') return html;
  return html.replace(/<p>\s*<\/p>/g, '').replace(/<p><br><\/p>/g, '').trim();
}

function checkNullable() {
  let temoin = 0;

  Object.keys(hoggarinput.hoggarDataNullables).forEach((champ) => {
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

  let currentRoute = hoggarinfo.routes.find(item => item.model === page.props.hoggarSettings.hoggarModelClassName)?.route;
if(currentRoute == undefined) {
  currentRoute = page.props.hoggarSettings.hoggarDataRouteListe
}


  const formData = new FormData();
 
  Object.keys(hoggarinput.hoggarDataValues).forEach((key) => {
    const value = hoggarinput.hoggarDataValues[key];
    
   const tab1 = ['MultipleFileEdit','MultipleImageEdit','MultipleVideoEdit','MultipleAudioEdit']
    if (tab1.includes(hoggarinput.hoggarDataTypes[key])) {
    if(!value || value.length === 0) {
      formData.append(key, '');
    }
    else if (Array.isArray(value)) {
      value.forEach((file, index) => {
        formData.append(`${key}[]`, file);
      });
    }
     const  temp = JSON.parse(hoggarinput.hoggarRecordInput[key] || '[]');
     const index = key + '_newtab'
      formData.append(index, JSON.stringify(temp));
    } 
    
    const tab2 = ['FileEdit','ImageEdit','VideoEdit','AudioEdit'];
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

 
  router.post(hoggarupdate.settings.hoggarValidationUrl, formData, {
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