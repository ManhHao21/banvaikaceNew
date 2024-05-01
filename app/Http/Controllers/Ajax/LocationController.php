<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Comment;
use App\Models\District;
use App\Models\Province;
use App\Repositories\Interface\DistrictRepositoryInterface;
use App\Repositories\Interface\ProvinceRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;

class LocationController extends Controller
{
    protected $districtRepository, $provinceRepository;
    public function __construct(DistrictRepositoryInterface $districtRepository, ProvinceRepositoryInterface $provinceRepository)
    {
        $this->districtRepository = $districtRepository;
        $this->provinceRepository = $provinceRepository;
    }
    public function getAddress(Request $request)
    {
        $get = $request->input();
        $html = '';
        if ($get['target'] == "districts") {
            $provinces = $this->provinceRepository->findById($get['data']['province_id'], ['code', 'name'], ['districts']);
            $html = $this->renderHtml($provinces->districts);
        } else if ($get['target'] == "wards") {
            $district = $this->districtRepository->findById($get['data']['province_id'], ['code', 'name'], ['wards']);
            $html = $this->renderHtml($district->wards, '[ Chọn phường xã ]');
        }

        return response()->json(['html' => $html]);
    }
    public function renderHtml($districts, $root = '[ Chọn quận huyện ]')
    {
        $html = '<option value="0">' . $root . '</option>';
        foreach ($districts as $key => $district) {
            $html .= '<option value="' . $district['code'] . '">' . $district['name'] . '</option>';
        }
        return $html;
    }
    // public function renderHtml($district)
    // {
    //     $htmlWard = "";
    //     if ($district) {
    //         $wards = $district->wards;
    //         $htmlWard .= "<option selected>[Vui lòng chọn xã/phường]</option>";
    //         foreach ($wards as $ward) {
    //             $htmlWard .= "<option value=" . $ward->code . ">" . $ward->name . "</option>";
    //         }
    //     }
    // }
    public function getComment(Request $request, $id)
    {
        dd($request->all());
        if ($request->input("show") === "show") {
            dd($request->input("show"));
        } else {
            $data = $request->all();
            $comment = Comment::create($data);
            $htmlComment = $this->renderComment($data);
        }
        return response()->json(['html' => $htmlComment]);
    }

    public function renderComment($data)
    {
        $htmlComment = "";
        if ($data) {
            $htmlComment .= '<div class="media mb-4">
            <img src="{{asset("Fontend")}}/img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1"
                style="width: 45px;">
            <div class="media-body">
                <h6>' . $data['name'] . '</h6>
                <p>' . $data['content'] . '</p>
            </div>
        </div>';
        }
        return $htmlComment;
    }
}