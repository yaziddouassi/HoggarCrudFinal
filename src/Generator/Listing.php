<?php

namespace Hoggarcrud\Hoggar\Generator;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Listing extends Controller
{
    public $hoggarSettings = [] ;
    public $allFilters = ['search' => 'search', 'paginationPerPage' => 'paginationPerPage',
     'orderByField' => 'orderByField', 'orderDirection' => 'orderDirection'];
    public $customFilters = [] ;
    public $tabFilterFields = [];
    public $tabFilterLabels = [];
    public $tabFilterTypes = [];
    public $tabFilterOptions = [];
    public $search = '' ;
    public $queryFilter;
    public $tables;
    public $groupActions = [];
    public $customs = [] ;
   
    function __construct() {
        $this->hoggarSettings['hoggarDataUrlStorage'] =  config('hoggar.urlstorage');
        $this->hoggarSettings['hoggarDataModelLabel'] =  $this->hoggarDataModelLabel ;
        $this->hoggarSettings['hoggarDataModelTitle'] =  $this->hoggarDataModelTitle ;
        $this->hoggarSettings['hoggarDataRouteListe'] =  $this->hoggarDataRouteListe ;
        $this->hoggarSettings['hoggarDataUrlCreate'] =  $this->hoggarDataUrlCreate ;
        $this->hoggarSettings['hoggarModelClass'] =  $this->hoggarModelClass ;
        $this->hoggarSettings['hoggarModelClassName'] =  $this->hoggarModelClassName ;
        $this->hoggarSettings['paginationPerPageList'] =  $this->paginationPerPageList ;
        $this->hoggarSettings['orderByFieldList'] =  $this->orderByFieldList ;
        $this->hoggarSettings['orderDirectionList'] =  $this->orderDirectionList ;
        $this->hoggarSettings['urlDelete'] =  $this->urlDelete ;
        
    }

    public function addFilter($a,$b) {
        $this->tabFilterFields[$b['field']] = $b['field'] ;
        $this->tabFilterLabels[$b['field']] = $b['field'] ;
        $this->tabFilterTypes[$b['field']] = $a;
        $this->tabFilterOptions[$b['field']] = $b;
    }

    public function addCustom($a,$b) {
        $this->customs[$a] = $b ;
    }

    public function addAction($a,$b) {
        $this->groupActions[$a] = $b ;
    }

    public function initQuery(Request $request)
     {
       // Méthode volontairement vide, pour être overridée par les enfants
     }
    
    public function allInit($request) {

        $paginationPerPage = $this->paginationPerPageList[0];
        $orderByField = $this->orderByFieldList[0];
        $orderDirection = $this->orderDirectionList[0];

        if ($request->filled('paginationPerPage')) {
            if (in_array($request->paginationPerPage, $this->paginationPerPageList)) {
                $paginationPerPage = $request->paginationPerPage ;
                 }
        }

        if ($request->filled('orderByField')) {
            if (in_array($request->orderByField, $this->orderByFieldList)) {
                $orderByField = $request->orderByField ;
                 }
        }

        if ($request->filled('orderDirection')) {
            if (in_array($request->orderDirection, $this->orderDirectionList)) {
                $orderDirection = $request->orderDirection ;
                 }
        }


        $this->customFilterList($request);
        $this->initAction($request);
        $this->initCustom($request);
        $this->customFilters['Fields'] =  $this->tabFilterFields ;
        $this->customFilters['Labels'] =  $this->tabFilterLabels ;
        $this->customFilters['Types'] =  $this->tabFilterTypes ;
        $this->customFilters['Options'] =  $this->tabFilterOptions;
        $this->queryFilter = $this->hoggarModelClass::select('*');
        $this->initQuery($request);
       
    
        $this->tables = $this->queryFilter->orderBy($orderByField,$orderDirection)
                         ->paginate($paginationPerPage)
                        ->appends($request->except('page'));
    }
}