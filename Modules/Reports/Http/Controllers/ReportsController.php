<?php

namespace Modules\Reports\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class ReportsController extends Controller
{
    
    protected function checkPermission($permissionName)
    {
        $user = auth()->user();
        if (!$user->hasAccessToPermission($permissionName)) {
            abort(403, 'Unauthorized');
        }
    }
    public function profitLossReport() {
        // abort_if(Gate::denies('access_reports'), 403);
         $this->checkPermission('access_reports');
        $this->checkPermission('access_reports');

        return view('reports::profit-loss.index');
    }

    public function paymentsReport() {
        // abort_if(Gate::denies('access_reports'), 403);
         $this->checkPermission('access_reports');

        return view('reports::payments.index');
    }

    public function salesReport() {
        // abort_if(Gate::denies('access_reports'), 403);
         $this->checkPermission('access_reports');

        return view('reports::sales.index');
    }

    public function purchasesReport() {
        // abort_if(Gate::denies('access_reports'), 403);
         $this->checkPermission('access_reports');

        return view('reports::purchases.index');
    }

    public function salesReturnReport() {
        // abort_if(Gate::denies('access_reports'), 403);
         $this->checkPermission('access_reports');

        return view('reports::sales-return.index');
    }

    public function purchasesReturnReport() {
        // abort_if(Gate::denies('access_reports'), 403);
         $this->checkPermission('access_reports');

        return view('reports::purchases-return.index');
    }
}
