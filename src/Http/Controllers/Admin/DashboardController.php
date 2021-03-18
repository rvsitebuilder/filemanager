<?php

namespace Rvsitebuilder\Filemanager\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the items.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $disk = isset($request->disk) ? $request->disk : '';
        $path = isset($request->path) ? $request->path : '';

        return view('rvsitebuilder/filemanager::admin.dashboard.index', compact('disk', 'path'));
    }
}
