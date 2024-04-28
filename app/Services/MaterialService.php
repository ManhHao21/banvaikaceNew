<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Services\Interface\MaterialServiceInterface;
use App\Repositories\MaterialRepository;

class MaterialService extends BaseService
{
    protected $MaterialRepository;

    public function __construct(MaterialRepository $MaterialRepository)
    {
        $this->MaterialRepository = $MaterialRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $Material = $this->MaterialRepository
            ->pagination(
                $this->paginateSelect()
                ,
                $condition,
                [],
                ['path' => '/admin/material'],
                $perpage
            );
        return $Material;
    }
    public function created($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_token']);
            $Material = $this->MaterialRepository->create($data);

            DB::commit();
            return $Material;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback giao dịch nếu có lỗi
            Log::error($e->getMessage());
            return false;
        }
    }
    public function updateStatus(array $post = [])
    {
        DB::beginTransaction();

        try {
            $payload[$post['data-field']] = ($post['value'] == "off" ? 2 : 1);
            $Material = $this->MaterialRepository->updated($post['modelId'], $payload);
            DB::commit();
            return TRUE;
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback giao dịch nếu có lỗi
            Log::error($e->getMessage());
            return false;
        }

    }
    public function updateStatusAll(array $post = [])
    {
        try {
            $payload[$post['data-field']] = $post['value'];
            $flag = $this->MaterialRepository->updateByWhereIn('id', $post['id'], $payload);
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
            $Material = $this->MaterialRepository->updated($id, $data);
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
            $Material = $this->MaterialRepository->deleted($id);
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
        return [
            'id',
            'name',
            'des',
            'publish',
        ];
    }
}
?>