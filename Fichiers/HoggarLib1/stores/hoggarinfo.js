import { defineStore } from 'pinia'

export const HoggarInfo = defineStore('info', {
  state: () => ({
    routes: {},
    show : false,
    show2 : false,
    allFilters: {},
    customFilters: {},
    sessionFilter: {},
  }),
  
  actions: {
    setUser(a) {
      this.user = a
    },

    setRoutes(a) {
      // 🔧 Copie profonde pour ne pas modifier props.routes
     let b = JSON.parse(JSON.stringify(a))

    
      if (!localStorage.getItem('hoggar')) {
        localStorage.setItem('hoggar', JSON.stringify({}))
      }

      const hoggar = JSON.parse(localStorage.getItem('hoggar'))

      Object.keys(b).forEach((key) => {
        const model = b[key]['model']
        if (!hoggar.hasOwnProperty(model)) {
          hoggar[model] = {}
          localStorage.setItem('hoggar', JSON.stringify(hoggar))
        }
      })

      const hoggar2 = JSON.parse(localStorage.getItem('hoggar'))

      Object.keys(b).forEach((key) => {
        const model = b[key]['model']
        const temp = b[key]['route']
        let temp2 = ''

        Object.keys(hoggar2[model]).forEach((cle) => {
          if (hoggar2[model][cle] != '') {
            if (temp2 === '') {
              temp2 += '?' + cle + '=' + hoggar2[model][cle]
            } else {
              temp2 += '&' + cle + '=' + hoggar2[model][cle]
            }
          }
        })

      
        b[key]['route'] = temp + temp2
      })

      this.routes = b 
      
    },

    addFilter() {
      // à implémenter plus tard
    },
  },
})