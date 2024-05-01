<?php
namespace App\Services;

use App\Repositories\Interface\ProductCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductCategoryService extends BaseService
{
    protected $ProductCategoryInterface;

    public function __construct(ProductCategoryRepositoryInterface $ProductCategoryInterface)
    {
        $this->ProductCategoryInterface = $ProductCategoryInterface;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $category = $this->ProductCategoryInterface->pagination($this->paginateSelect(), $condition, [], ['path' => '/admin/category'], $perpage, [], ['key' => 'desc']);
        return $category;
    }
    public function created($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_token']);
            $images = null;
            if ($request->hasFile('image')) {
                $images = $this->convertImage($data['image'], 'category-product');
            }
            $category = [
                'name' => $data['name'],
                'slug' => $data['slug'],
                'parent_id' => $data['parent_id'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'meta_keyword' => $data['meta_keyword'],
                'image' => $images,
                'publish' => 1,
            ];
            $Product = $this->ProductCategoryInterface->create($category);
            DB::commit();
            return $Product;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback giao dịch nếu có lỗi
            Log::error($e->getMessage());
            return false;
        }
    }
    public function updateStatus(array $Product = [])
    {
        DB::beginTransaction();

        try {
            $payload[$Product['data-field']] = $Product['value'] == 'off' ? 0 : 1;
            $Product = $this->ProductCategoryInterface->updated($Product['modelId'], $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback giao dịch nếu có lỗi
            Log::error($e->getMessage());
            return false;
        }
    }
    public function updateStatusAll(array $Product = [])
    {
        try {
            $payload[$Product['data-field']] = $Product['value'];
            $flag = $this->ProductCategoryInterface->updateByWhereIn('id', $Product['id'], $payload);
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
            $images = null;
            if ($request->hasFile('image')) {
                $images = $this->convertImage($data['image'], 'category-product');
            }
            $category = [
                'name' => $data['name'],
                'slug' => $data['slug'],
                'parent_id' => $data['parent_id'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'meta_keyword' => $data['meta_keyword'],
                'image' => $images,
                'publish' => 1,
            ];
            $Product = $this->ProductCategoryInterface->updated($id, $category);
            DB::commit();
            return $Product;
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
            $Product = $this->ProductCategoryInterface->deleted($id, true);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
    private function paginateSelect()
    {
        return ['id', 'name', 'parent_id', 'publish', 'image'];
    }

    public function getProductbyCategory($request, $slug)
    {
        // Gọi phương thức để lấy sản phẩm từ danh mục
        $category = $this->ProductCategoryInterface->findBySlug($request, $slug);
        return  $category;
        
    }

}
?>