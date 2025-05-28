import { defineStore } from 'pinia'

export const HoggarUpdate  = defineStore('maison', {
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