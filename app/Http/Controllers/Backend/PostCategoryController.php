<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests\PostCategoryRequest;
use App\Repositories\Interface\PostCategoryRepositoryInterface;
use App\Services\PostCategoryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserCatalogueRequest;

class PostCategoryController extends Controller
{
    protected $PostCategoryServices, $PostCategoryRepository;
    public function __construct(PostCategoryService $PostCategoryServices, PostCategoryRepositoryInterface $PostCategoryRepository)
    {
        $this->PostCategoryServices = $PostCategoryServices;
        $this->PostCategoryRepository = $PostCategoryRepository;
    }

    public function index(Request $request)
    {

        $config['seo'] = config('apps.postCategory.index');
        $listCategory = $this->PostCategoryServices->paginate($request);
        return view('backend.post.category.index', compact('listCategory', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $config['seo'] = config('apps.postCategory.create');
        $config['method'] = 'create';
        $categorys = $this->PostCategoryRepository->getAll();
        return view('backend.post.category.create', compact('config', 'config', 'categorys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCategoryRequest $request)
    {

        if ($this->PostCategoryServices->created($request)) {
            return redirect()->route('admin.postcategory.index')->with('success', 'Tạo bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Tạo bản ghi không thành công');
    }


    public function edit($id)
    {
        $config['seo'] = config('apps.postCategory.update');
        $config['method'] = 'edit';
        $postCategory = $this->PostCategoryRepository->findById($id);
        $categorys = $this->PostCategoryRepository->getAll();

        return view('backend.post.category.create', compact('postCategory', 'config', 'categorys'));
    }


    public function update($id, Request $request)
    {
        if ($this->PostCategoryServices->updated($id, $request)) {
            return redirect()->route('admin.postcategory.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.postcategory.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function show($id)
    {
        $postCategory = $this->PostCategoryRepository->findById($id);
        if ($postCategory) {
            return view('backend.post.category.show', compact('postCategory'));

        } else {
            return redirect()->back()->with('errors', 'Không tồn tại bản ghi, vui lòng xóa sau');
        }
    }

    public function destroy($id)
    {
        $deleteUser = $this->PostCategoryServices->destroy($id);
        if ($deleteUser) {
            return redirect()->route('admin.postcategory.index')->with('success', 'Xóa bản ghi viên thành công');
        }
    }
}
