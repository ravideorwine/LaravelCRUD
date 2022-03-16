<?php

namespace App\Http\Controllers;

use App\Models\Company;

use Illuminate\Http\Request;

use App\Exports\CompanyExport;

use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests\FormValidation;

use DataTables;

class CompanyCRUDController extends Controller
{
/**
* Display a listing of the resource.
*
* @return \Illuminate\Http\Response
*/
public function index(Request $request)
{
// $data['companies'] = Company::orderBy('id','desc')->paginate(5);
// return view('companies.index', $data);

if ($request->ajax()) {

$data = Company::latest()->get();


return Datatables::of($data)->make(true);
    // ->addIndexColumn()
    // ->addColumn('action', function($row){
    //     // dd($row->id);
    //     $actionBtn = "<a href='companies/$row->id/edit' class='edit btn btn-success btn-sm'>Edit</a> <a href='javascript:void(0)' class='delete btn btn-danger btn-sm'>Delete</a>";
    //     return $actionBtn;
    // })
    // ->rawColumns(['action'])
}

return view('companies.index');

}
/**
* Show the form for creating a new resource.
*
* @return \Illuminate\Http\Response
*/
public function create()
{
return view('companies.create');
}
/**
* Store a newly created resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @return \Illuminate\Http\Response
*/
public function store(FormValidation $request)
{
    $company = new Company;
    $company->name = $request->name;
    $company->email = $request->email;
    $company->address = $request->address;    
    if($file = $request->file('image')){
        $destinationPath = 'public/image/'; 
        $profileImage = date('YmdHis') . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath, $profileImage);
        $company->image = $profileImage;

    }

    $company->save();
    return redirect()->route('companies.index')
    ->with('success','Company has been created successfully.');
}
/**
* Display the specified resource.
*
* @param  \App\company  $company
* @return \Illuminate\Http\Response
*/
public function show(Company $company)
{
return view('companies.show',compact('company'));
} 
/**
* Show the form for editing the specified resource.
*
* @param  \App\Company  $company
* @return \Illuminate\Http\Response
*/
public function edit(Company $company)
{
return view('companies.edit',compact('company'));
}
/**
* Update the specified resource in storage.
*
* @param  \Illuminate\Http\Request  $request
* @param  \App\company  $company
* @return \Illuminate\Http\Response
*/
public function update(Request $request, $id)
{
$request->validate([
'name' => 'required',
'email' => 'required',
'address' => 'required',
]);
$company = Company::find($id);
$company->name = $request->name;
$company->email = $request->email;
$company->address = $request->address;
if($file = $request->file('image')){
    $destinationPath = 'public/image/'; 
    $profileImage = date('YmdHis') . "." . $file->getClientOriginalExtension();
    $file->move($destinationPath, $profileImage);
    $company->image = $profileImage;

}
$company->save();
return redirect()->route('companies.index')
->with('success','Company Has Been updated successfully');
}
/**
* Remove the specified resource from storage.
*
* @param  \App\Company  $company
* @return \Illuminate\Http\Response
*/

// public function destroy(Company $company)
// {
// $company->delete();
// return redirect()->route('companies.index')
// ->with('success','Company has been deleted successfully');
// }

public function destroy(Request $request)
{
    $company = Company::where('id',$request->id)->delete();      
    return Response()->json($company);
}

// public function indexFiltering(Request $request)
// {
//     $filter = $request->query('filter');

//     if (!empty($filter)) {
//         $company = Company::where('name', 'like', '%'.$filter.'%');
//     } 

//     return view('companies.index')->with('filter', $filter);
// }

public function get_company_data(Request $request)
{
    // dd($request->all());
    return Excel::download(new CompanyExport($request->text), 'company.xlsx');
}

}