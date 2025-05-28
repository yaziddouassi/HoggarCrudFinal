import { defineStore } from 'pinia'

export const HoggarCreate  = defineStore('montre', {
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
