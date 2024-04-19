<?php

namespace App\Http\Controllers\backend;

use App\Repositories\Interface\MaterialRepositoryInterface;
use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Repositories\Interface\ProductRepositoryInterface;
use App\Repositories\Interface\ProductCategoryRepositoryInterface;

class ProductController extends Controller
{
    protected $ProductServices, $ProductRepository, $ProductCategoryRepository, $materialRepository;
    public function __construct(
        ProductService $ProductServices,
        ProductRepositoryInterface $ProductRepository,
        ProductCategoryRepositoryInterface $ProductCategoryRepository,
        MaterialRepositoryInterface $materialRepository
    ) {
        $this->ProductServices = $ProductServices;
        $this->ProductRepository = $ProductRepository;
        $this->ProductCategoryRepository = $ProductCategoryRepository;
        $this->materialRepository = $materialRepository;
    }

    public function index(Request $request)
    {

        $config['seo'] = config('apps.Product.index');
        $listProducts = $this->ProductServices->paginate($request);
        return view('backend.product.product.index', compact('listProducts', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = $this->ProductCategoryRepository->getAll();
        $config['seo'] = config('apps.Product.create');
        $config['method'] = 'create';
        $ProductCategory = $this->ProductRepository->getAll();
        $materials = $this->materialRepository->getAll();
        return view('backend.product.product.create', compact('config', 'ProductCategory', 'categories', 'materials'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        if ($this->ProductServices->created($request)) {
            return redirect()->route('admin.product.index')->with('success', 'Tạo bản ghi thành công');

        }
        return redirect()->back()->with('error', 'Tạo bản ghi không thành công');
    }


    public function edit($id)
    {
        $config['seo'] = config('apps.Product.update');
        $config['method'] = 'edit';
        $product = $this->ProductRepository->findById($id);
        $categories = $this->ProductCategoryRepository->getAll();
        $materials = $this->materialRepository->getAll();

        return view('backend.Product.Product.create', compact('product', 'config', 'categories', 'materials'));
    }


    public function update($id, Request $request)
    {
        if ($this->ProductServices->updated($id, $request)) {
            return redirect()->route('admin.product.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('admin.product.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function show($id)
    {
        $product = $this->ProductRepository->findById($id);
        if ($product) {
            return view('backend.Product.Product.show', compact('product'));
        } else {
            return redirect()->back()->with('errors', 'Không tồn tại bản ghi, vui lòng xóa sau');
        }
    }

    public function destroy($id)
    {
        $deleteUser = $this->ProductServices->destroy($id);
        if ($deleteUser) {
            return redirect()->route('admin.product.index')->with('success', 'Xóa bản ghi viên thành công');
        }
    }
}