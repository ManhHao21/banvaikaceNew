<?php
namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\SinglePageRepository;
use Illuminate\Support\Facades\Hash;
use App\Services\Interface\SinglePageServiceInterface;

class SinglePageService implements SinglePageServiceInterface
{
    protected $SinglePageRepository;

    public function __construct(SinglePageRepository $SinglePageRepository)
    {
        $this->SinglePageRepository = $SinglePageRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $Post = $this->SinglePageRepository
            ->pagination(
                $this->paginateSelect()
                ,
                $condition,
                [],
                ['path' => '/admin/singlepage'],
                $perpage,
                ['postCategory']
            );
        return $Post;
    }

    public function created($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except('_token');
            if ($request->hasFile('image')) {
                $data['image'] = $this->convertImage($request->file('image'), '/singlepage/image');
            }
            $post = $this->SinglePageRepository->create($data);
            DB::commit();
            return $post;
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
            $Post = $this->SinglePageRepository->updated($post['modelId'], $payload);
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
            $flag = $this->SinglePageRepository->updateByWhereIn('id', $post['id'], $payload);
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
                $data['image'] = $this->convertImage($request->file('image'), '/singlepage/image');
            }
            $Post = $this->SinglePageRepository->updated($id, $data);
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
            $singlePage = $this->SinglePageRepository->deleted($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
    private function convertImage($image = '', $path = '')
    {
        if ($image) {
            $path = $image->store($path);
            return $path;
        }
    }
    private function paginateSelect()
    {
        return [
            'id',
            'title',
            'short_description',
            'description',
            'publish',
            'content',
            'image'
        ];
    }
}
?>