<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\AdminRepository;

class AdminService extends BaseService
{
    protected $AdminRepository;

    public function __construct(AdminRepository $AdminRepository)
    {
        $this->AdminRepository = $AdminRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $Admin = $this->AdminRepository
            ->pagination(
                $this->paginateSelect()
                ,
                $condition,
                [],
                ['path' => '/admin/Admins'],
                $perpage
            );
        return $Admin;
    }
    public function created($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_token', 're_password']);
            if ($data['birthday'] != null) {
                $data['birthday'] = $this->convertBirthday($data['birthday']);
            }
            $data['password'] = Hash::make($data['password']);
            $Admin = $this->AdminRepository->create($data);

            DB::commit();
            return $Admin;
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
            $payload[$post['data-field']] = ($post['value'] == "off" ? 0 : 1);
            $Admin = $this->AdminRepository->updated($post['modelId'], $payload);
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
            $flag = $this->AdminRepository->updateByWhereIn('id', $post['id'], $payload);
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
            $data = $request->except(['_token', 're_password']);
            if ($data['birthday'] != null) {
                $data['birthday'] = $this->convertBirthday($data['birthday']);
            }
            $Admin = $this->AdminRepository->updated($id, $data);
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
            $Admin = $this->AdminRepository->deleted($id);
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
            'email',
            'phone',
            'address',
            'name',
            'is_active',
        ];
    }
}
?>