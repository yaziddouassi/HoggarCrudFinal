import { defineStore } from 'pinia'

export const WizardUpdate  = defineStore('magicien', {
    state: () => ({ 
      settings: {}, 
     
    }),
    getters: {
     
    },
    actions: {
     
        setSettings(a) {
            this.settings = a
          },

    },
  }) 