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

class PostService  extends BaseService
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
                $this->paginateSelect()
                ,
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
            $data = $request->except('_token');
            if ($request->hasFile('image')) {
                $data['image'] = $this->convertImage($request->file('image'));
            }
            $post = $this->PostRepository->create($data);
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
            $data = $request->except(['_token']);
            if ($request->hasFile('image')) {
                $data['image'] = $this->convertImage($request->file('image'));
            }
            $Post = $this->PostRepository->updated($id, $data);
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
}
?>