<?php

namespace App\Providers;

use App\Models\Table\Qrgad\User;
use App\Models\View\Qrgad\VwKeluhan;
use App\Models\View\Qrgad\VwTabelInventory;
use App\Models\View\Qrgad\VwTrip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        // Gate::define('admin', function(User $user) {
        //     return $user->level === 'LV00000001';
        // });

        // Gate::define('GAD', function(User $user) {
        //     return $user->level === 'LV00000002';
        // });

        view()->composer("Qrgad/layout/notification", function($view){
            if(Auth::user()->level == "LV00000001" || Auth::user()->level == "LV00000002"){

                $view->with([
                    "notif_keluhan" => VwKeluhan::where('status', 0)->orderBy('input_time', 'DESC')->get(),
                    "notif_trip" => VwTrip::where('status', 1)->orWhere('status', 2)->orWhere('status', 3)->whereNull('set_trip_time')->orderBy('input_time', 'DESC')->get(),
                    "notif_inventory" => VwTabelInventory::where("stock", "<=" , VwTabelInventory::raw('minimal_stock'))->orderBy('last_out', 'DESC')->get()
                ]);

            } else if(Auth::user()->level == "LV00000004"){

                $view->with([
                    "notif_keluhan" => VwKeluhan::where('username', Auth::user()->username)->where('status', 1)->orderBy('input_time', 'DESC')->get(),
                    "notif_trip" => VwTrip::where('username', Auth::user()->username)->where('status', 0)->orWhere('status', 2)->orWhere('status', 3)->WhereNotNull('set_trip_time')->orderBy('input_time', 'DESC')->get(),
                    "notif_inventory" => []
                ]);
                
            } else {
                $view->with([
                    "notif_keluhan" => [],
                    "notif_trip" => [],
                    "notif_inventory" => []
                ]);

            }
        });
      
    }
}
