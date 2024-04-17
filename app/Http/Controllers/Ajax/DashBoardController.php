<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function changeStatus(Request $request)
    {
        $post = $request->input();
        $serviceInterfaceNamespace = '\App\Services\\' . ucfirst($post['data-model'] . 'Service');

        if ($serviceInterfaceNamespace && class_exists($serviceInterfaceNamespace)) {
            $serviceInstance = app($serviceInterfaceNamespace);
            $flag = $serviceInstance->updateStatus($post);
            return response()->json([
                'flag' => $flag
            ]);
        } else {
            return response()->json([
                'flag' => false,
                'error' => 'Service instance not found'
            ]);
        }
    }



    public function changeStatusPublicAll(Request $request)
    {
        $post = $request->input();
        $serviceInterfaceNamespace = 'App\Services\\' . ucfirst($post['data-model'] . 'Service');
        if (class_exists($serviceInterfaceNamespace)) {
            $serviceInstance = app($serviceInterfaceNamespace);
        }
        $flag = $serviceInstance->updateStatusAll($post);
        dd($flag);
        return response()->json([
            'flag' => $flag
        ]);
    }
}
