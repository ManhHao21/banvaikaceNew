<?php
namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Repositories\Interface\ProvinceRepositoryInterface;

class UserController extends Controller
{
    protected $UserService, $ProvinceRepository, $UserRepository;
    protected $check = false;
    public function __construct(UserService $UserService, ProvinceRepositoryInterface $ProvinceRepository, UserRepositoryInterface $UserRepository)
    {
        $this->UserService = $UserService;
        $this->ProvinceRepository = $ProvinceRepository;
        $this->UserRepository = $UserRepository;
    }

    public function index(Request $request)
    {
        $config['seo'] = config('apps.user.index');
        $listUser = $this->UserService->paginate($request);
        return view('backend.user.user.index', compact('listUser', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $config['seo'] = config('apps.user.create');
        $provindes = $this->ProvinceRepository->getAll();
        $config['method'] = 'create';
        return view('backend.user.user.create', compact('config', 'provindes', 'config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {

        if ($this->UserService->created($request)) {
            return redirect()->route('admin.users.index')->with('success', 'Tạo bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Tạo bản ghi không thành công');
    }


    public function edit($id)
    {
        $provindes = $this->ProvinceRepository->getAll();
        $config['seo'] = config('apps.user.update');
        $config['method'] = 'edit';
        $user = $this->UserRepository->findById($id);
        return view('backend.user.user.create', compact('user', 'config', 'provindes', 'config'));
    }


    public function update($id, UpdateUserRequest $request)
    {
        if ($this->UserService->updated($id, $request)) {
            return redirect()->route('admin.users.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.users.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function show(User $user)
    {
        $user = $this->UserRepository->findById($user->id);

        return view('backend.user.user.show', compact('user'));
    }

    public function destroy($id)
    {
        $deleteUser = $this->UserService->destroy($id);
        if ($deleteUser) {
            return redirect()->route('admin.users.index')->with('success', 'Xóa bản ghi viên thành công');
        }
    }
}
