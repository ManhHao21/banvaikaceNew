<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategoryRequest;
use App\Repositories\Interface\PostRepositoryInterface;
use App\Repositories\Interface\PostCategoryRepositoryInterface;

class PostController extends Controller
{
    protected $PostServices, $PostCategoryRepository, $PostRepository;
    public function __construct(
        PostService $PostServices,
        PostCategoryRepositoryInterface $PostCategoryRepository,
        PostRepositoryInterface $PostRepository,
    ) {
        $this->PostServices = $PostServices;
        $this->PostCategoryRepository = $PostCategoryRepository;
        $this->PostRepository = $PostRepository;
    }

    public function index(Request $request)
    {

        $config['seo'] = config('apps.post.index');
        $listPosts = $this->PostServices->paginate($request);
        return view('backend.post.post.index', compact('listPosts', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $config['seo'] = config('apps.post.create');
        $config['method'] = 'create';
        $postCategory = $this->PostCategoryRepository->getAll();
        return view('backend.post.post.create', compact('config', 'config', 'postCategory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($this->PostServices->created($request)) {
            return redirect()->route('admin.post.index')->with('success', 'Tạo bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Tạo bản ghi không thành công');
    }


    public function edit($id)
    {
        $config['seo'] = config('apps.post.update');
        $config['method'] = 'edit';
        $post = $this->PostRepository->findById($id);
        $postCategory = $this->PostCategoryRepository->getAll();
        return view('backend.post.post.create', compact('post', 'config', 'postCategory'));
    }


    public function update($id, Request $request)
    {
        if ($this->PostServices->updated($id, $request)) {
            return redirect()->route('admin.post.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.post.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function show($id)
    {
        $post = $this->PostRepository->findById($id);
        if ($post) {
            return view('backend.post.post.show', compact('post'));
        } else {
            return redirect()->back()->with('errors', 'Không tồn tại bản ghi, vui lòng xóa sau');
        }
    }

    public function destroy($id)
    {
        $deleteUser = $this->PostServices->destroy($id);
        if ($deleteUser) {
            return redirect()->route('admin.post.index')->with('success', 'Xóa bản ghi viên thành công');
        }
    }
}
