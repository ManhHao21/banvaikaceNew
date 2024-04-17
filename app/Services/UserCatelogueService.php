<?php
namespace App\Services;

use App\Repositories\Interface\UserCatelogueRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Services\Interface\UserCatelogueServiceInterface;

class UserCatelogueService implements UserCatelogueServiceInterface
{
    protected $UserCatelogueRepository;

    public function __construct(UserCatelogueRepositoryInterface $UserCatelogueRepository)
    {
        $this->UserCatelogueRepository = $UserCatelogueRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $UserCatelog = $this->UserCatelogueRepository
            ->pagination(
                $this->paginateSelect()
                ,
                $condition,
                [],
                ['path' => '/admin/catelogue'],
                $perpage,
                ['users']
            );

        return $UserCatelog;
    }
    public function created($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_token']);
            $User = $this->UserCatelogueRepository->create($data);
            DB::commit();
            return $User;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
    public function updateStatus(array $post = [])
    {
        DB::beginTransaction();

        try {
            $payload[$post['data-field']] = ($post['value'] == "off" ? 2 : 1);
            $User = $this->UserCatelogueRepository->updated($post['modelId'], $payload);
            DB::commit();
            return $User;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }

    }
    public function updateStatusAll(array $post = [])
    {
        try {
            $payload[$post['data-field']] = $post['value'];
            $flag = $this->UserCatelogueRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return TRUE;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }


    }
    public function updated($id, $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token']);
            $User = $this->UserCatelogueRepository->updated($id, $data);
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
            $User = $this->UserCatelogueRepository->deleted($id);
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
            'description',
            'publish',
        ];
    }
}
?>