<?php
namespace App\Http\Controllers\Backend;

use App\Models\UserCatelogue;
use App\Repositories\Interface\UserCatelogueRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\UserCatelogueService;
use App\Http\Requests\StoreUserCatalogueRequest;

class UserCatelogueController extends Controller
{
    protected $UserCatelogueServices, $UserCatelogueRepository;
    protected $check = false;
    public function __construct(UserCatelogueService $UserCatelogueServices, UserCatelogueRepositoryInterface $UserCatelogueRepository)
    {
        $this->UserCatelogueServices = $UserCatelogueServices;
        $this->UserCatelogueRepository = $UserCatelogueRepository;
    }

    public function index(Request $request)
    {

        $config['seo'] = config('apps.userCatelog.create');
        $listUser = $this->UserCatelogueServices->paginate($request);
        return view('backend.user.usercatelog.index', compact('listUser', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $config['seo'] = config('apps.userCatelog.create');
        $config['method'] = 'create';
        return view('backend.user.usercatelog.create', compact('config', 'config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserCatalogueRequest $request)
    {

        if ($this->UserCatelogueServices->created($request)) {
            return redirect()->route('admin.catelogue.index')->with('success', 'Tạo bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Tạo bản ghi không thành công');
    }


    public function edit($id)
    {
        $config['seo'] = config('apps.userCatelog.update');
        $config['method'] = 'edit';
        $userCatelog = $this->UserCatelogueRepository->findById($id);
        return view('backend.user.usercatelog.create', compact('userCatelog', 'config'));
    }


    public function update($id, Request $request)
    {
        if ($this->UserCatelogueServices->updated($id, $request)) {
            return redirect()->route('admin.catelogue.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.catelogue.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function show($id)
    {
        $userCatelog = $this->UserCatelogueRepository->findById($id);
        if ($userCatelog) {
            return view('backend.user.usercatelog.show', compact('userCatelog'));

        } else {
            return redirect()->back()->with('errors', 'Không tồn tại bản ghi, vui lòng xóa sau');
        }
    }

    public function destroy($id)
    {
        $deleteUser = $this->UserCatelogueServices->destroy($id);
        if ($deleteUser) {
            return redirect()->route('admin.catelogue.index')->with('success', 'Xóa bản ghi viên thành công');
        }
    }
}
