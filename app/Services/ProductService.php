<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Session;
use App\Services\Interface\ProductServiceInterface;
use App\Repositories\Interface\ImageColorProductRepositoryInterface;

class ProductService extends BaseService
{
    protected $ProductRepository, $imageColorProductRepositoryInterface;

    public function __construct(ProductRepository $ProductRepository, ImageColorProductRepositoryInterface $imageColorProductRepositoryInterface)
    {
        $this->ProductRepository = $ProductRepository;
        $this->imageColorProductRepositoryInterface = $imageColorProductRepositoryInterface;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $category = $this->ProductRepository->pagination($this->paginateSelect(), $condition, [], ['path' => '/admin/product'], $perpage, [], ['key' => 'desc']);
        return $category;
    }
    public function created($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('_token');
            $images = [];
            if ($request->hasFile('image')) {
                foreach ($data['image'] as $key => $image) {
                    $images[] = $this->convertImage($image, 'product-image');
                }
            }
            $productData = [
                'name' => $data['name'] ?? null,
                'slug' => $data['slug'] ?? null,
                'sku' => $data['sku'] ?? null,
                'price' => $data['price'] ?? null,
                'categories_id' => $data['categories_id'] ?? null,
                'description' => $data['description'] ?? null,
                'image' => json_encode($images) ?? null,
                'gms' => $data['gms'] ?? null,
                'seller' => $data['seller'] ?? null,
                'publish' => 1,
                'user_id' => Auth::guard('admin')->id(),
                'is_hot' => $data['is_hot'] ?? null,
                'top_view' => $data['top_view'] ?? null,
            ];
            $product = $this->ProductRepository->create($productData);
            // if ($request->hasFile('images_color')) {

            //     foreach ($data['images_color'] as $key => $image_color) {

            //         $data = DB::table('image_color_product')->create([
            //             'product_id' => $product->id,
            //             'image_color' => $this->convertImage($image_color)
            //         ]);
            //     }
            // }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function updateStatus(array $Product = [])
    {
        DB::beginTransaction();

        try {
            $payload[$Product['data-field']] = $Product['value'] == 'off' ? 2 : 1;
            $Product = $this->ProductRepository->updated($Product['modelId'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
    public function updateStatusAll(array $Product = [])
    {
        try {
            $payload[$Product['data-field']] = $Product['value'];
            $flag = $this->ProductRepository->updateByWhereIn('id', $Product['id'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback giao dịch nếu có lỗi
            Log::error($e->getMessage());
            return false;
        }
    }
    public function updated($id, $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            if ($request->hasFile('image')) {
                $image = $this->convertImage($data['image']);
            }
            if ($data['material_id'] && $data['material_id'] != null) {
                $data['material_id'] = json_encode($data['material_id']);
            }
            $data['user_id'] = Auth::guard('admin')->id();
            $data['publish'] = 1;
            $Product = $this->ProductRepository->updated($id, $data);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $Product = $this->ProductRepository->deleted($id, true);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    public function convertBirthday($birthday = '')
    {
        $dateCarbon = Carbon::createFromFormat('Y-m-d', $birthday);
        $birthday = $dateCarbon->format('Y-m-d H:i:s');
        return $birthday;
    }
    private function paginateSelect()
    {
        return ['id', 'name', 'sku', 'price', 'categories_id', 'description', 'image', 'material_id', 'user_id', 'gms', 'publish'];
    }

    public function getFirstById($id)
    {
        return $this->ProductRepository->getFirstById($id);
    }

    public function getCartOrder($id)
    {
        $product = $this->ProductRepository->findById($id, ['id', 'name', 'image', 'price']);
        if (!$product) {
            return false;
        }
        $cart = session()->get('carts', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $image = json_decode($product->image, true);
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->name,
                'image' => isset($image[0]) ? $image[0] : null,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
        return session()->put('carts', $cart);
    }

    public function updateQuantity($request, $id)
    {
        $cart = session()->get('carts', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
        }
        return session()->put('carts', $cart);
    }

    public function closeRowCart($id) {
        $cart = session()->get('carts', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }
        return session()->put('carts', $cart);
    }

    
}
