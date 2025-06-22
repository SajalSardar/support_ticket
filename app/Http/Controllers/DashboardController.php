<?php

namespace App\Http\Controllers;

use App\Decorators\DashboardDecorator;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller {
    /**
     * Invoke the dashboard page
     * @return View
     */
    public function __invoke() {

        $chart      = DashboardDecorator::chart();
        $state      = DashboardDecorator::state();
        $traffic    = DashboardDecorator::traffic();
        $agents     = DashboardDecorator::agents();
        $categories = DashboardDecorator::categories();
        $teams      = DashboardDecorator::teams();

        // return $state;
        return view('dashboard', compact('chart', 'state', 'traffic', 'agents', 'categories', 'teams'));
    }
}
