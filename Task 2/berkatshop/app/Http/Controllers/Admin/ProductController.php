<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $product = Product::latest()->get();
            return DataTables::of($product)
                ->addIndexColumn()
                ->addColumn('action', function ($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="edit btn btn-primary btn-sm viewProduct"><i class="fa fa-eye"></i></a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm editProduct"><i class="fa fa-edit"></i></a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data = [
            'pageTitle' => 'Products',
        ];
        return view('admin/product', $data);
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
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'price' => ['required'],
        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()]);

        DB::beginTransaction();
        try {
            $productId = Str::uuid();

            $product = new Product();
            $product->id = $productId;
            $product->name = $request->name;
            $product->price = $request->price;

            if ($product->save()) {
                DB::commit();
                return response()->json(['success' => true, 'errors' => false]);
            } else {
                throw new \Exception('Failed saving product data!');
            }
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
     */
    public function show($id, Request $request)
    {
        $product = Product::find($id);
        if ($request->ajax()) return response()->json($product);
        return 'REQUEST TYPE ERROR!';
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit($id, Request $request)
    {
        $product = Product::find($id);
        if ($request->ajax()) return response()->json($product);
        return 'REQUEST TYPE ERROR!';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'price' => ['required'],

        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()]);
        DB::beginTransaction();
        try {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->price = $request->price;

            if ($product->save()) {
                DB::commit();
                return response()->json(['success' => true, 'message' => 'Product updated successfully!', 'code' => 200]);
            } else {
                throw new \Exception('Failed on saving data!');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            $erMessage = $exception->getMessage();
            $erCode = $exception->getCode();
            return response()->json(['success' => true, 'message' => $erMessage, 'code' => $erCode]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if (!$product) return  response()->json(['success' => false, 'message' => 'Product with id: '.$id.' not found!']);
        if($product->delete()) return response()->json(['success' => true, 'message' => 'Successfully deleting product.']);
        else return response()->json(['success' => false, 'message' => 'Failed deleting product.']);
    }
}
