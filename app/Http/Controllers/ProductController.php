<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Imports\ProductImport;
use App\Exports\ProductExport;
use App\Models\Product;

class ProductController extends Controller
{
    public function fileImport(Request $request)
    {

        if ($request->hasFile('file')) {
            if ($request->file->getClientOriginalExtension() == 'csv') {

                Excel::import(new ProductImport, request()->file('file'));
                return redirect()->back()->with('success', 'Data Imported Successfully');
            } else {
                return redirect()->back()->with('error', 'Error in file extension');
            }
        } else {
            return redirect()->back()->with('error', 'File not found');
        }
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileExport()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }
}
