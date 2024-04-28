<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;

class UserService  extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] =  $request->integer('publish');
        $user = $this->userRepository
            ->pagination(
                $this->paginateSelect()
                ,
                $condition,
                [],
                ['path' => '/admin/users'],
                $perpage
            );
        return $user;
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
            $user = $this->userRepository->create($data);

            DB::commit();
            return $user;
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
            $user = $this->userRepository->updated($post['modelId'], $payload);
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
            $flag = $this->userRepository->updateByWhereIn('id', $post['id'], $payload);
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
            $user = $this->userRepository->updated($id, $data);
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
            $user = $this->userRepository->deleted($id);
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
            'publish',
        ];
    }
}
?>