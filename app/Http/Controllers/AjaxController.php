<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\District;
use App\Models\Province;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getAddress(Request $request)
    {
        return $request->all();
        // $id = $request->id;
        // $html = "";
        // $htmlWard = "";

        // $province = Province::where('code', '=', $id)->first();

        // if ($province) {
            // $districts = $province->districts;
            // $html .= "<option selected>[Vui lòng chọn quận/huyện]</option>";

            // foreach ($districts as $district) {
                // $html .= "<option value=" . $district->code . ">" . $district->name . "</option>";
            // }
            // dd($request->idWard);
            // if ($request->input('check') === "district") {

                // $district = District::where('code', '=', $request->input('idWard'))->first();
                // $this->renderHtml($district);
            // }
        // }

        // return response()->json([
            // "html" => $html,
            // "success" => 200,
            // 'ward' => $htmlWard
        // ]);
    }

    public function renderHtml($district)
    {
        $htmlWard = "";
        if ($district) {
            $wards = $district->wards;
            $htmlWard .= "<option selected>[Vui lòng chọn xã/phường]</option>";
            foreach ($wards as $ward) {
                $htmlWard .= "<option value=" . $ward->code . ">" . $ward->name . "</option>";
            }
        }
    }
    public function getComment(CommentRequest $request)
    {

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