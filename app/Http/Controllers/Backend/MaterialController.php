<?php

namespace App\Http\Controllers\Backend;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Services\MaterialService;
use App\Http\Controllers\Controller;
use App\Http\Requests\MaterialRequest;
use App\Repositories\Interface\MaterialRepositoryInterface;

class MaterialController extends Controller
{
    protected $MaterialService, $MaterialRepository;
    protected $check = false;
    public function __construct(MaterialService $MaterialService, MaterialRepositoryInterface $MaterialRepository)
    {
        $this->MaterialService = $MaterialService;
        $this->MaterialRepository = $MaterialRepository;
    }
    public function index(Request $request)
    {
        $config['seo'] = config('apps.material.index');
        $listMaterials = $this->MaterialService->paginate($request);
        return view('backend.product.material.index', compact('listMaterials', 'config'));
    }
    public function create()
    {
        $config['seo'] = config('apps.material.create');
        $config['method'] = 'create';
        return view('backend.product.material.create', compact('config', 'config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($this->MaterialService->created($request)) {
            return redirect()->route('admin.material.index')->with('success', 'Tạo bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Tạo bản ghi không thành công');
    }


    public function edit($id)
    {
        $config['seo'] = config('apps.material.update');
        $config['method'] = 'edit';
        $Material = $this->MaterialRepository->findById($id);
        return view('backend.product.material.create', compact('Material', 'config'));
    }


    public function update($id, Request $request)
    {
        if ($this->MaterialService->updated($id, $request)) {
            return redirect()->route('admin.material.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.material.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function show($id)
    {
        $Material = $this->MaterialRepository->findById($id);

        return view('backend.product.material.show', compact('Material'));
    }

    public function destroy($id)
    {
        $Material = $this->MaterialService->destroy($id);
        if ($Material) {
            return redirect()->route('admin.material.index')->with('success', 'Xóa bản ghi viên thành công');
        }
    }
}
