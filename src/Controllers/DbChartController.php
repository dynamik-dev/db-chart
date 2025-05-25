<?php

namespace Dynamik\DbChart\Controllers;

use Dynamik\DbChart\DbChartServiceProvider;
use Dynamik\DbChart\Transformers\ToMermaid;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class DbChartController extends Controller
{
    public function __construct(
        public ToMermaid $toMermaid,
    ) {}

    public function index(): View
    {
        $callback = DbChartServiceProvider::$authorized;

        if (! $callback || ! $callback()) {
            return abort(403);
        }

        /** 
         * This is pretty stupid.
         * @var view-string */
        $view = 'db-chart::index';
        
        return view($view, ['schema' => $this->toMermaid->handle()]);
    }
}
