<?php

namespace App\Http\Controllers\Web;

use Illuminate\View\View;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

class DashboardController extends Controller
{
    public function swaggerDocs(): View
    {
        $documentation = 'default';
        $documentationTitle = Config::get("l5-swagger.documentations.$documentation.api.title", "API Documentation");
        $urlsToDocs = [
            'Documentation API' => url('/api-docs.json'),
        ];
        $operationsSorter = null;
        $configUrl = null;
        $validatorUrl = null;
        $useAbsolutePath = false;

        return view('l5-swagger::index', compact(
            'documentation',
            'documentationTitle',
            'urlsToDocs',
            'operationsSorter',
            'configUrl',
            'validatorUrl',
            'useAbsolutePath'
        ));
    }
}
