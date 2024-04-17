<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Interface\SystemRepositoryInterface;
use App\Services\SystemService;
use Illuminate\Http\Request;
use App\Classes\System;

class SystemController extends Controller
{
    protected $system, $SystemService, $SystemRepository;
    public function __construct(System $system, SystemService $SystemService, SystemRepositoryInterface $SystemRepository)
    {
        $this->system = $system;
        $this->SystemService = $SystemService;
        $this->SystemRepository = $SystemRepository;
    }

    public function system()
    {
        $config['seo'] = config('apps.system.index');
        $systemAll = convert_array($this->SystemRepository->getAll(), 'keyword', 'content');
        $system = $this->system->config();
        return view('backend.system.system', compact('system', 'config', 'systemAll'));
    }

    public function store(Request $request)
    {

        if ($this->SystemService->created($request)) {
            return redirect()->route('admin.system.system')->with('success', 'Cập nhật bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Cập nhật bản ghi không thành công');
    }
}
