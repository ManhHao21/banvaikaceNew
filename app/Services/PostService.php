<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\Interface\PostServiceInterface;

class PostService extends BaseService
{
    protected $PostRepository;

    public function __construct(PostRepository $PostRepository)
    {
        $this->PostRepository = $PostRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $perpage = $request->integer('perpage');
        $condition['publish'] = $request->integer('publish');
        $Post = $this->PostRepository
            ->pagination(
                $this->paginateSelect(),
                $condition,
                [],
                ['path' => '/admin/Posts'],
                $perpage,
                ['postCategory']
            );
        return $Post;
    }

    public function created($request)
    {
        DB::beginTransaction();

        try {
            // Lấy dữ liệu đầu vào từ request
            $data = $request->only([
                'title',
                'short_description',
                'description',
                'category_post_id',
                'content',
                'slug',
                'meta_title',
                'meta_description',
                'meta_keyword',
            ]);

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
            $post = $this->PostRepository->create([
                "title" => $data['title'],
                "short_description" => $data['short_description'],
                "category_post_id" => $data['category_post_id'],
                "content" => $data['content'],
                "slug" => $data['slug'],
                "meta_title" => $data['meta_title'],
                "meta_description" => $data['meta_description'],
                "meta_keyword" => $data['meta_keyword'],
                "image" => $data['image'],
                'publish' => 1
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
            $payload[$post['data-field']] = ($post['value'] == "off" ? 2 : 1);
            $Post = $this->PostRepository->updated($post['modelId'], $payload);
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
            $flag = $this->PostRepository->updateByWhereIn('id', $post['id'], $payload);
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
            $data = $request->only([
                'title',
                'short_description',
                'description',
                'category_post_id',
                'content',
                'slug',
                'meta_title',
                'meta_description',
                'meta_keyword',
            ]);

            // Xử lý ảnh
            $images = [];
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $key => $image) {
                    $images[] = $this->convertImage($image, 'post-image');
                }
            }
            $data['image'] = json_encode($images);
            $Post = $this->PostRepository->updated($id, [
                "title" => $data['title'],
                "short_description" => $data['short_description'],
                "category_post_id" => $data['category_post_id'],
                "content" => $data['content'],
                "slug" => $data['slug'],
                "meta_title" => $data['meta_title'],
                "meta_description" => $data['meta_description'],
                "meta_keyword" => $data['meta_keyword'],
                "image" => $data['image'],
                'publish' => 1
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
            $Post = $this->PostRepository->deleted($id);
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
            'title',
            'short_description',
            'description',
            'publish',
            'content',
            'category_post_id',
            'image'
        ];
    }

    public function getPostRequest($request)
    {
        return $this->PostRepository->getAll();
    }
}
