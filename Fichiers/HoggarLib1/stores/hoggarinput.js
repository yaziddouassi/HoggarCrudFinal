import { defineStore } from 'pinia'
import { useForm } from '@inertiajs/vue3'

export const HoggarInput = defineStore('counter', {
  state: () => ({
    errors: {}, 
    nom: 'hello wesh',
    hogarRecordInput: {},
    hogarDataUrlStorage: '',
    hogarDataDefaultValues: {},
    hogarDataLabels: {},
    hogarDataValues: {},
    hogarDataFields: {},
    hogarDataTypes: {},
    hogarDataOptions: {},
    hogarDataNullables: {},
    hogarNoDatabases: {},
    tempUrls: {},
    tempUrlTabs: {},
    existingFiles: {},
    removedFiles: {},
    wizardForm: {},
    wizardLabel: {},
    wizardCount: 1,
    wizardStop: {},
    wizardCurrent: 1,
    repeaterLines : {},
    repeaterFields : {},
    repeaterOrders : {},
    cleRepeater : '9f2d8e7a0c3b10de9873b821f4b637ced410f17c9b75598f3b3972bda7264925c2e7bb6f5e0cdd2a89c17a33411393ae47a5ae8544e39715c5865f7e2b2a6e2b',
    form: useForm({}),
  }),

  actions: {
    setError(err) {
      this.errors = err
    },

    resetError() {
      this.errors = {}
    },

    setFormData(data) {
      this.form = useForm(data)
    },

 
setRepeaterLines(a, b) {
  Object.entries(a).forEach(([key, value]) => {

   if (!this.hogarDataValues[key]) {
      this.hogarDataValues[key] = [];
    }

    if (this.hogarDataValues[key]) {
      this.hogarDataValues[key] = [];
    }

    if (!this.repeaterLines[key]) {
      this.repeaterLines[key] = [];
    }

     if (this.repeaterLines[key]) {
      this.repeaterLines[key] = [];
    }

    if (!this.repeaterOrders[key]) {



      
      const array1 = []; 
      Object.entries(b[key]).map(([key, value], index) => {
       array1.push(key) ;
     });

     this.repeaterOrders[key] = array1

    }

     if (this.repeaterOrders[key]) {
       const array1 = []; 
      Object.entries(b[key]).map(([key, value], index) => {
       array1.push(key) ;
     });

     this.repeaterOrders[key] = array1
    }


    // Générer les lignes avec un ID unique et les ajouter avec push
    for (let i = 0; i < a[key]['numberOflines']; i++) {

      if (!this.hogarDataValues[key][i]) {
      this.hogarDataValues[key][i] = [] ;
    } 

     if (!this.repeaterLines[key][i]) {
      this.repeaterLines[key][i] = [];
    }

      Object.entries(b[key]).forEach(([key2, value2]) => {
        this.hogarDataValues[key][i][key2] = value2['value']
        this.repeaterLines[key][i][key2] = value2
     
        
      });
       
    
    }

    
  });

 
},


setRepeaterLines2(repeaters, values, repeaterFields) {
  Object.entries(repeaters).forEach(([key, config]) => {
    const lignes = values[key] || [] // tableau des lignes (chaque ligne = objet)
    const fields = repeaterFields[key] || {}

    // Initialise les structures
    this.repeaterLines[key] = []
    this.hogarDataValues[key] = []
    this.repeaterOrders[key] = Object.keys(fields)

    lignes.forEach((ligne, index) => {
      this.repeaterLines[key][index] = {}
      this.hogarDataValues[key][index] = {}

      Object.entries(fields).forEach(([champ, configChamp]) => {
        const valeur = ligne[champ] ?? ''
        this.hogarDataValues[key][index][champ] = valeur
        this.repeaterLines[key][index][champ] = {
          ...configChamp,
          value: valeur
        }
      })
    })
  })
},


setRepeaterLines3(a, b,c) {
  Object.entries(a).forEach(([key, value]) => {

  
    if (!this.repeaterLines[key]) {
      this.repeaterLines[key] = [];
    }

     if (this.repeaterLines[key]) {
      this.repeaterLines[key] = [];
    }

    if (!this.repeaterOrders[key]) {

      const array1 = []; 
      Object.entries(c[key]).map(([key, value], index) => {
       array1.push(key) ;
     });

     this.repeaterOrders[key] = array1

    }

     if (this.repeaterOrders[key]) {
       const array1 = []; 
      Object.entries(c[key]).map(([key, value], index) => {
       array1.push(key) ;
     });

     this.repeaterOrders[key] = array1
    }


    // Générer les lignes avec un ID unique et les ajouter avec push
    for (let i = 0; i < b[key].length; i++) {

    

     if (!this.repeaterLines[key][i]) {
      this.repeaterLines[key][i] = [];
    }

      Object.entries(b[key]).forEach(([key2, value2]) => {
        this.repeaterLines[key][i][key2] = value2
      });
       
    
    }

    
  });

 
},



addRepeaterLine(a,b) {

},



    resetDatas() {
      Object.entries(this.hogarDataDefaultValues).forEach(([key, value]) => {
        // 🛠 Corrige les valeurs de type checkbox multiple (string JSON → tableau JS)
        if (this.hogarDataTypes[key] === 'CheckBoxMultiple') {
          this.hogarDataValues[key] = this.parseArray(value)
        } else {
          this.hogarDataValues[key] = value
        }

        this.tempUrls[key] = null
        this.tempUrlTabs[key] = []
        this.existingFiles[key] = []
        this.removedFiles[key] = []
      })
    },

    initTempUrls() {
      Object.entries(this.hogarDataDefaultValues).forEach(([key, value]) => {
        this.tempUrls[key] = null
        this.tempUrlTabs[key] = []
        this.existingFiles[key] = []
        this.removedFiles[key] = []
      })
    },

    parseArray(value) {
      
      if (Array.isArray(value)) return value
      if (typeof value === 'string') {
        try {
          const parsed = JSON.parse(value)
          if (Array.isArray(parsed)) return parsed
        } catch {
          return []
        }
      }
      return []
    }
  }
})