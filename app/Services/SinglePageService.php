<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\SinglePageRepository;
use Illuminate\Support\Facades\Hash;
use App\Services\Interface\SinglePageServiceInterface;

class SinglePageService extends BaseService
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
        $Post = $this->SinglePageRepository->pagination($this->paginateSelect(), $condition, [], ['path' => '/admin/singlepage'], $perpage, ['postCategory']);
        return $Post;
    }

    public function created($request)
    {
        DB::beginTransaction();

        try {
            $data = $request->except('_token');
            // Xử lý ảnh
            $images = [];
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $key => $image) {
                    // Xử lý và lưu ảnh
                    $images[] = $this->convertImage($image, 'post-image');
                }
            }

            // Đóng gói dữ liệu
            $data['image'] = json_encode($images);
            $post = $this->SinglePageRepository->create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'short_description' => $data['short_description'],
                'content' => $data['content'],
                'image' => $data['image'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'meta_keyword' => $data['meta_keyword'],
                'publish' => 1,
            ]);
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
            $payload[$post['data-field']] = $post['value'] == 'off' ? 2 : 1;
            $Post = $this->SinglePageRepository->updated($post['modelId'], $payload);
            DB::commit();
            return true;
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
            $data = $request->except('_token');
            // Xử lý ảnh
            $images = [];
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $key => $image) {
                    // Xử lý và lưu ảnh
                    $images[] = $this->convertImage($image, 'post-image');
                }
            }
            $data['image'] = json_encode($images);

            $Post = $this->SinglePageRepository->updated($id, [
                'title' => $data['title'],
                'slug' => $data['slug'],
                'short_description' => $data['short_description'],
                'content' => $data['content'],
                'image' => $data['image'],
                'meta_title' => $data['meta_title'],
                'meta_description' => $data['meta_description'],
                'meta_keyword' => $data['meta_keyword'],
                'publish' => 1,
            ]);
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

    private function paginateSelect()
    {
        return ['id', 'title', 'short_description', 'description', 'publish', 'content', 'image'];
    }
}
