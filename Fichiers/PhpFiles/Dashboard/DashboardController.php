<?php
namespace App\Http\Controllers\Hoggar\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Database\Eloquent\Collection;



class DashboardController extends Controller
{
   
    public function index(Request $request)
    {

    
        
        return Inertia::render('HoggarPages/Dashboard/Dashboard', [
            'routes' =>  \Hoggarcrud\Hoggar\Models\Hoggarcrud::where('active',true)->get(),
            'user' => Auth::user(),
            'chart1' => ['datas' => [mt_rand(1, 12),mt_rand(1, 12),mt_rand(1, 12)],
                         'labels'  => ['Jan','Fev','Mars'] ],
            'chart2' => ['datas' => [mt_rand(1, 12),mt_rand(1, 12),mt_rand(1, 12)],
                         'labels'  => ['Avil','Mai','jUIN'] ],
            'chart3' => ['datas' => [mt_rand(1, 12),mt_rand(1, 12),mt_rand(1, 12)],
                         'labels'  => ['Juillet','Aout','septembre'] ],
            'widget1' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Sales of month',
                         'icon'  => 'account_circle'], 
            'widget2' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Number of Visiteurs',
                         'icon'  => 'account_circle'],              
            'widget3' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Bests Products',
                         'icon'  => 'account_circle'],
            'widget4' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Sales of month',
                         'icon'  => 'account_circle'], 
            'widget5' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Number of Visiteurs',
                         'icon'  => 'account_circle'],              
            'widget6' => ['value' =>  mt_rand(1, 50),
                         'title'  => 'Bests Products',
                         'icon'  => 'account_circle'],                

        ]);
    }

    
}