<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Services\Interface\ProductServiceInterface;
use App\Repositories\ProductRepository;

class ProductService implements ProductServiceInterface
{
    protected $ProductRepository;

    public function __construct(ProductRepository $ProductRepository)
    {
        $this->ProductRepository = $ProductRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $category = $this->ProductRepository
            ->pagination(
                $this->paginateSelect()
                ,
                $condition,
                [],
                ['path' => '/admin/product'],
                $perpage,
                [],
                ['key' => 'desc']

            );
        return $category;
    }
    public function created($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('_token');
            if ($request->hasFile('image')) {
                $images = [];
                dd($data['image']);
                foreach ($data['image'] as $key => $image) {
                    $images[] = $this->convertImage($image);
                }
                $data['image'] = json_encode($images);
            }
            if ($data['material_id'] && $data['material_id'] != NULL) {
                $data['material_id'] = json_encode($data['material_id']);
            }
            $data['user_id'] = Auth::guard('admin')->id();
            $data['publish'] = 1;
            $data['is_hot'] = $data['is_hot'] == 'on' ? '1' : '0';
            $data['is_sale'] = $data['is_sale'] == 'on' ? '1' : '0';
            $data['top_view'] = $data['top_view'] == 'on' ? '1' : '0';
            $product = $this->ProductRepository->create($data);
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
            $payload[$Product['data-field']] = ($Product['value'] == "off" ? 2 : 1);
            $Product = $this->ProductRepository->updated($Product['modelId'], $payload);
            DB::commit();
            return TRUE;
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
            return TRUE;
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
            if ($data['material_id'] && $data['material_id'] != NULL) {
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
            $Product = $this->ProductRepository->deleted($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
    public function convertImage($image)
    {
        $path = $image->store('product/image');
        return $path;
    }

    public function convertBirthday($birthday = '')
    {
        $dateCarbon = Carbon::createFromFormat('Y-m-d', $birthday);
        $birthday = $dateCarbon->format('Y-m-d H:i:s');
        return $birthday;
    }
    private function paginateSelect()
    {
        return [
            'id',
            'name',
            'sku',
            'price',
            'categories_id',
            'description',
            'image',
            'material_id',
            'user_id',
            'gms',
            'publish'
        ];
    }

    public function getFirstById($id)
    {
        return $this->ProductRepository->getFirstById($id);
    }

    public function getCartToOrder($request)
    {
        if ($request['action'] == 'cart') {

        } else if ($request['action'] == 'detail') {
            $data =  $this->ProductRepository->getFirstById($request['id']);
            $data['image'] = json_decode($data['image']);
            return $data;
        }
    }
}
?>