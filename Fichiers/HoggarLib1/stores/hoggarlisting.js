import { defineStore } from 'pinia'
import { HoggarInfo } from './hoggarinfo';

export const HoggarListing  = defineStore('listing', {
    state: () => ({ 
      settings: {}, 
      actionIds : [],
      groupActions : [],
    }),
    getters: {
     
    },
    actions: {

      resetActionIds() {
        this.actionIds = []
      },

      
      AddActionIds(a) {

        const hoggarinfo = HoggarInfo()
        hoggarinfo.show = false
        if (!this.actionIds.includes(a)) {
          this.actionIds.push(a);
        }
         if(this.actionIds.length == 1) {
        hoggarinfo.show2 = false
         }
      },

      RemoveActionIds(a) {
        const hoggarinfo = HoggarInfo()
         hoggarinfo.show = false
        const index = this.actionIds.indexOf(a);
          if (index !== -1) {
                 this.actionIds.splice(index, 1);
                }
      },


        setSettings(a) {
            this.settings = a
          },

    },
  }) 