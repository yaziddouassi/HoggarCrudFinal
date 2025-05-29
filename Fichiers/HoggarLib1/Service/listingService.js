import { usePage } from '@inertiajs/vue3'
import { HoggarInfo } from '@/HoggarLibs/stores/hoggarinfo'
import { HoggarListing } from '@/HoggarLibs/stores/hoggarlisting'

export function listingService() {
  

  function setSettings() {
   const page = usePage()
   const hoggarinfo = HoggarInfo()
   const hoggarlisting = HoggarListing()

   hoggarlisting.setSettings(page.props.hogarSettings)
   hoggarinfo.setRoutes(page.props.routes)

   hoggarlisting.groupActions = page.props.groupActions


   hoggarinfo.allFilters = page.props.allFilters
   hoggarinfo.customFilters = page.props.customFilters
   hoggarinfo.sessionFilter = page.props.sessionFilter
   hoggarinfo.show = false

    console.log(page.props)
  }

 

  return {
    setSettings
  }
}