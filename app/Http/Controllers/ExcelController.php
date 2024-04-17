<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use Illuminate\Http\Request;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
        if (!$request->excel_file) {
            return back()->with('error', 'Vui lòng chọn một tệp Excel để import.');
        }

        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx,csv|max:2048',
        ],[
                'required'=> 'Vui lòng chọn một tệp excel để import',
                'mimes' => 'Vui lòng chọn đúng file excel',
                'max' => 'Vui lòng chọn đúng file có kích thước :max'
        ]);


        $import = Excel::import(new ProductImport, request()->excel_file);
        return back()->with('success', 'Formations importées avec succès');
    }
}
