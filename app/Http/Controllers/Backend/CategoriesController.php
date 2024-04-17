<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Repositories\Interface\ProductCategoryRepositoryInterface;
use App\Services\ProductCategoryService;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    protected $ProductCategoryService, $ProductCategoryRepository;
    public function __construct(ProductCategoryService $productCategoryService, ProductCategoryRepositoryInterface $ProductCategoryRepository)
    {
        $this->ProductCategoryService = $productCategoryService;
        $this->ProductCategoryRepository = $ProductCategoryRepository;
    }
    public function index(Request $request)
    {
        $categories = $this->ProductCategoryService->paginate($request);

        $config['seo'] = config('apps.ProductCategory.index');
        return view("backend.product.categoryProduct.index", compact("categories", 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->ProductCategoryRepository->getAll();
        $config['method'] = 'create';
        $config['seo'] = config('apps.ProductCategory.index');

        return view("backend.product.categoryProduct.create", compact("categories", 'config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:Categories,slug',
                'parent_id' => 'nullable',
            ],
            [
                'required' => 'Trường :attribute không được để trống.',
                'string' => 'Trường :attribute phải là một chuỗi.',
                'unique' => 'Trường :attribute đã tồn tại.',

                'max' => [
                    'string' => 'Trường :attribute không được vượt quá :max ký tự.',
                ],
                'unique' => 'Trường :attribute đã tồn tại trong hệ thống.',
            ],
            [
                'name' => "Tên",
                'slug' => "đường dẫn",
                'parent_id' => 'parent_id',
            ]
        );
        if ($this->ProductCategoryService->created($request)) {
            return redirect()->route('admin.category.index')->with('success', 'Tạo bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Tạo bản ghi không thành công');

    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $postCategory = $this->ProductCategoryRepository->findById($id);

        return view('backend.product.categoryProduct.show', compact('postCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $config['seo'] = config('apps.ProductCategory.update');
        $config['method'] = 'edit';
        $category = $this->ProductCategoryRepository->findById($id);
        $categories = $this->ProductCategoryRepository->getAll();

        return view('backend.product.categoryProduct.create', compact('config', 'categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|',
                'parent_id' => 'nullable',
            ],
            [
                'required' => 'Trường :attribute không được để trống.',
                'string' => 'Trường :attribute phải là một chuỗi.',
                'max' => [
                    'string' => 'Trường :attribute không được vượt quá :max ký tự.',
                ],
                'unique' => 'Trường :attribute đã tồn tại trong hệ thống.',
            ],
            [
                'name' => "Tên",
                'slug' => "đường dẫn",
                'parent_id' => 'parent_id',
            ]
        );
        if ($this->ProductCategoryService->updated($id, $request)) {
            return redirect()->route('admin.category.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.category.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleteProductCategory = $this->ProductCategoryService->destroy($id);
        if ($deleteProductCategory) {
            return redirect()->route('admin.category.index')->with('success', 'Xóa bản ghi viên thành công');
        }
    }
}