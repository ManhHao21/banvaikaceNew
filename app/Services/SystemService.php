<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Services\Interface\SystemServiceInterface;
use App\Repositories\SystemRepository;

class SystemService implements SystemServiceInterface
{
    protected $SystemRepository;

    public function __construct(SystemRepository $SystemRepository)
    {
        $this->SystemRepository = $SystemRepository;
    }
    public function update($id, $request)
    {


    }
    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $System = $this->SystemRepository
            ->pagination(
                $this->paginateSelect()
                ,
                $condition,
                [],
                ['path' => '/admin/Systems'],
                $perpage
            );
        return $System;
    }
    public function created($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->all();
            $data['config']['homepage_logo'] = $this->convertImage($data['config']['homepage_logo']);
            $data['config']['homepage_favicon'] = $this->convertImage($data['config']['homepage_favicon']);
            $data['config']['seo_meta_image'] = $this->convertImage($data['config']['seo_meta_image']);
            $payload = [];
            if (count($data['config'])) {
                foreach ($data['config'] as $key => $val) {
                    $payload = [
                        'keyword' => $key,
                        'content' => $val,
                    ];
                    $condition = ['keyword' => $key];
                    $this->SystemRepository->updateOrInsert($payload, $condition);
                }
            }
            DB::commit();
            return $payload;
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
            $System = $this->SystemRepository->updated($post['modelId'], $payload);
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
            $flag = $this->SystemRepository->updateByWhereIn('id', $post['id'], $payload);
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
            $System = $this->SystemRepository->updated($id, $data);
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
            $System = $this->SystemRepository->deleted($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
    public function convertImage($images = '')
    {
        $path = $images->store('system/image');
        return $path;
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
            'email',
            'phone',
            'address',
            'name',
            'publish',
        ];
    }
}
?>