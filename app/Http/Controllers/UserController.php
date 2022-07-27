<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Exports\UsersExport;

class UserController extends Controller
{
    public function fileImportExport()
    {
       return view('file-import');
    }
   
    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport() 
    {
        // $fileName = time().'_'.request()->file->getClientOriginalName();
        // request()->file('file')->storeAs('reports', $fileName, 'public');
        Excel::import(new UsersImport, request()->file('file'));
        return redirect()->back()->with('success','Data Imported Successfully');
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileExport() 
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    } 
}
