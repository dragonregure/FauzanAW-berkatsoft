<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\Sales;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $sales = Sales::latest()->get();
            return DataTables::of($sales)
                ->addIndexColumn()
                ->addColumn('username', function ($row){
                    $user = User::find($row->user_id);
                    return $user->username;
                })
                ->addColumn('productname', function ($row){
                    $product = Product::find($row->product_id);
                    return $product->name;
                })
                ->addColumn('action', function ($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteOrder"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $userData = User::all();
        $productData = Product::all();
        $data = [
            'pageTitle' => 'Sales',
            'userData' => $userData,
            'productData' => $productData,
        ];
        return view('admin/sales', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => ['required'],
            'productId' => ['required'],
        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()]);

        DB::beginTransaction();
        try {
            $invoiceNumber = 'INV'.date('Ymd').substr(Str::uuid(), 0, 5);
            foreach ($request->productId as $key) {
                $id = Str::uuid();
                $sales = new Sales();
                $sales->id = $id;
                $sales->invoice_number = $invoiceNumber;
                $sales->user_id = $request->userId;
                $sales->product_id = $key;

                if (!$sales->save()) throw new \Exception('Failed saving people data!');

            }
            DB::commit();
            return response()->json(['success' => true, 'errors' => false]);
        } catch (\Exception $exception) {
            DB::rollBack();
            $erMessage = $exception->getMessage();
            $erCode = $exception->getCode();
            return response()->json(['success' => false, 'errors' => $erMessage]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Sales  $sales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $sales = Sales::find($id);
        if (!$sales) return  response()->json(['success' => false, 'message' => 'Order with id: '.$id.' not found!']);
        if($sales->delete()) return response()->json(['success' => true, 'message' => 'Successfully deleting Order.']);
        else return response()->json(['success' => false, 'message' => 'Failed deleting Order.']);
    }
}
