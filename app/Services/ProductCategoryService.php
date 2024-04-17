<?php
namespace App\Services;

use App\Repositories\Interface\ProductCategoryRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Services\Interface\ProductCategoryServiceInterface;

class ProductCategoryService implements ProductCategoryServiceInterface
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
        $category = $this->ProductCategoryInterface
            ->pagination(
                $this->paginateSelect()
                ,
                $condition,
                [],
                ['path' => '/admin/category'],
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
            $data = $request->except(['_token']);
            $Product = $this->ProductCategoryInterface->create($data);
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
            $payload[$Product['data-field']] = ($Product['value'] == "off" ? 2 : 1);
            $Product = $this->ProductCategoryInterface->updated($Product['modelId'], $payload);
            DB::commit();
            return TRUE;
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
            $Product = $this->ProductCategoryInterface->updated($id, $data);
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
            $Product = $this->ProductCategoryInterface->deleted($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
    private function convertBirthday($birthday = '')
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
            'parent_id',
            'publish',
        ];
    }
}
?>