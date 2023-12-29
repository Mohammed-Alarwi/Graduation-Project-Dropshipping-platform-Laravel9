<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddSupplierRequest;
use App\Models\Supplier;
use App\Models\SupplierTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return  view('Admin.Suppliers.suppliers_management');
    }

    public function getDataTable()
    {
       /* $data = Supplier::select('*');
        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function ($row) {
                return $btn = '
            <a  type="button" id="ff" onclick="changeVar()" class="btn btn-info">عرض العمليات</a>
            <a href="' . Route('admin.suppliers.create',$row->id) . '" type="button" class="btn btn-info">Edit</a>
            ';
            })

            ->rawColumns(['action'])
            ->make(true);*/

            $model = Supplier::with('SuplierTransactions');
            return DataTables::of($model)
            //عرض الرصيد الخاص بالمورد 
            /*->addColumn('trens', function (Supplier $supplier) {
                $firstTransaction = $supplier->SuplierTransactions->last();
                return $firstTransaction ? $firstTransaction->balance : null;
            })*/
    
            ->addColumn('action', function ($row) {
                return $btn = '
                <a href="' . route('admin.suppliers.transaction', ['id' => $row->sup_id]) . '"  id="showOperationsBtn" data-supplier-id="' . $row->sup_id . '" type="button" class="btn btn-info">عرض العمليات</a>
                <a   data-supplier-id="' . $row->sup_id  . '" type="button" class="delete_btn btn btn-danger">حذف</a>
                <a href="" type="button" class="btn btn-info">Edit</a>
    
        ';
            })
    
            ->rawColumns(['action'])
            ->make(true);   
    }

   /* public function getSupplierTransactionsData($id)
{
    $transactions = SupplierTransaction::where('sup_id', $id)->get();
    return DataTables::of($transactions)->addIndexColumn()
    ->addColumn('action', function ($row) {
        return $btn = '
    <a  type="button" id="ff" data-supplier-id="' . $row->id . '"  onclick="changeVar()" class="btn btn-info">عرض العمليات</a>
    <a href="' . Route('admin.suppliers.create',$row->id) . '" type="button" class="btn btn-info">Edit</a>
    ';
    })
    ->rawColumns(['action'])
    ->make(true);
}*/




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('Admin.Suppliers.insert_supplier');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(AddSupplierRequest $request)
    {

       /* $data['name'] =  $request->name;
        $data['email'] =  $request->email;
        $data['address'] = $request->address;
        $data['phone_number'] =  $request->phone;
        $data['created_at'] = date("Y-m-d H:i:s");
        $data['updated_at'] = date("Y-m-d H:i:s");

        Supplier::create($data);*/

        
        Supplier::create([
            'name' => $request->name,
            'email' =>  $request->email,
            'address' =>  $request->address,
            'phone_number' =>  $request->phone,
            'balance'=> 0,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
       //return $request;
        
        $supplier = Supplier::where('sup_id', $request->id);

        $supplier->delete();
        
    }
}
