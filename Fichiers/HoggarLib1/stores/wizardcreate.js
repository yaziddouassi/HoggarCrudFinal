import { defineStore } from 'pinia'

export const WizardCreate  = defineStore('wizard', {
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