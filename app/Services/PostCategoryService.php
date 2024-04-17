<?php
namespace App\Services;

use App\Repositories\Interface\PostCategoryRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Interface\PostCategoryServiceInterface;

class PostCategoryService implements PostCategoryServiceInterface
{
    protected $PostCategoryInterface;

    public function __construct(PostCategoryRepositoryInterface $PostCategoryInterface)
    {
        $this->PostCategoryInterface = $PostCategoryInterface;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $Post = $this->PostCategoryInterface
            ->pagination(
                $this->paginateSelect()
                ,
                $condition,
                [],
                ['path' => '/admin/Posts'],
                $perpage,
                ['Parent_id'],
                ['key' => 'esc']
            );
        return $Post;
    }
    public function created($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except(['_token']);
            $Post = $this->PostCategoryInterface->create($data);

            DB::commit();
            return $Post;
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
            $Post = $this->PostCategoryInterface->updated($post['modelId'], $payload);
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
            $flag = $this->PostCategoryInterface->updateByWhereIn('id', $post['id'], $payload);
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
            $Post = $this->PostCategoryInterface->updated($id, $data);
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
            $Post = $this->PostCategoryInterface->deleted($id);
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
            'slug',
            'parent_id',
            'meta_title',
            'meta_description',
            'meta_keyword',
            'publish'
        ];
    }
}
?>