<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Services\SinglePageService;
use App\Http\Controllers\Controller;
use App\Repositories\Interface\SinglePageRepositoryInterface;

class SinglePageController extends Controller
{
    protected $SinglePageServices, $SinglePageRepository;
    public function __construct(
        SinglePageService $SinglePageServices,
        SinglePageRepositoryInterface $SinglePageRepository,
    ) {
        $this->SinglePageServices = $SinglePageServices;
        $this->SinglePageRepository = $SinglePageRepository;
    }

    public function index(Request $request)
    {
        $config['seo'] = config('apps.SinglePage.index');
        $listSinglePages = $this->SinglePageServices->paginate($request);
        return view('backend.post.singlepage.index', compact('listSinglePages', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $config['seo'] = config('apps.SinglePage.create');
        $config['method'] = 'create';
        $SinglePageCategory = $this->SinglePageRepository->getAll();
        return view('backend.post.singlepage.create', compact('config', 'config', 'SinglePageCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($this->SinglePageServices->created($request)) {
            return redirect()->route('admin.singlepage.index')->with('success', 'Tạo bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Tạo bản ghi không thành công');
    }


    public function edit($id)
    {
        $config['seo'] = config('apps.SinglePage.update');
        $config['method'] = 'edit';
        $singlepage = $this->SinglePageRepository->findById($id);
        $SinglePageCategory = $this->SinglePageRepository->getAll();
        return view('backend.post.singlepage.create', compact('singlepage', 'config', 'SinglePageCategory'));
    }


    public function update($id, Request $request)
    {
        if ($this->SinglePageServices->updated($id, $request)) {
            return redirect()->route('admin.singlepage.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.singlepage.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function show($id)
    {
        $singlepage = $this->SinglePageRepository->findById($id);
        if ($singlepage) {
            return view('backend.post.singlepage.show', compact('singlepage'));
        } else {
            return redirect()->back()->with('errors', 'Không tồn tại bản ghi, vui lòng xóa sau');
        }
    }

    public function destroy($id)
    {
        if ($this->SinglePageServices->destroy($id)) {
            return redirect()->route('admin.singlepage.index')->with('success', 'Xóa bản ghi viên thành công');

        }
    }
}
