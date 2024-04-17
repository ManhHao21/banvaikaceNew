<?php
namespace App\Http\Controllers\Backend;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Http\Requests\AdminRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAdminRequest;
use App\Repositories\Interface\AdminRepositoryInterface;
use App\Repositories\Interface\ProvinceRepositoryInterface;

class AdminController extends Controller
{
    protected $AdminService, $ProvinceRepository, $AdminRepository;
    protected $check = false;
    public function __construct(AdminService $AdminService, ProvinceRepositoryInterface $ProvinceRepository, AdminRepositoryInterface $AdminRepository)
    {
        $this->AdminService = $AdminService;
        $this->ProvinceRepository = $ProvinceRepository;
        $this->AdminRepository = $AdminRepository;
    }

    public function index(Request $request)
    {
        $config['seo'] = config('apps.user.index');
        $listAdmin = $this->AdminService->paginate($request);
        return view('backend.Admin.index', compact('listAdmin', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $config['seo'] = config('apps.user.create');
        $provindes = $this->ProvinceRepository->getAll();
        $config['method'] = 'create';
        return view('backend.Admin.create', compact('config', 'provindes', 'config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminRequest $request)
    {

        if ($this->AdminService->created($request)) {
            return redirect()->route('admin.Admins.index')->with('success', 'Tạo bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Tạo bản ghi không thành công');
    }


    public function edit($id)
    {
        $provindes = $this->ProvinceRepository->getAll();
        $config['seo'] = config('apps.user.update');
        $config['method'] = 'edit';
        $Admin = $this->AdminRepository->findById($id);
        return view('backend.Admin.create', compact('Admin', 'config', 'provindes', 'config'));
    }


    public function update($id, UpdateAdminRequest $request)
    {
        if ($this->AdminService->updated($id, $request)) {
            return redirect()->route('admin.Admins.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.Admins.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function show(Admin $Admin)
    {
        $Admin = $this->AdminRepository->findById($Admin->id);

        return view('backend.Admin.show', compact('Admin'));
    }

    public function destroy($id)
    {
        $deleteAdmin = $this->AdminService->destroy($id);
        if ($deleteAdmin) {
            return redirect()->route('admin.Admins.index')->with('success', 'Xóa bản ghi viên thành công');
        }
    }
}
