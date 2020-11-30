<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\People;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     *
     */
    public function index(Request $request)
    {
        if ($request->ajax()){
            $people = People::latest()->get();
            return DataTables::of($people)
                ->addIndexColumn()
                ->addColumn('username', function ($row){
                    $user = User::find($row->id);
                    return $user->username;
                })
                ->addColumn('action', function ($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->people_id.'" data-original-title="View" class="edit btn btn-primary btn-sm viewPeople"><i class="fa fa-eye"></i></a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->people_id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm editPeople"><i class="fa fa-edit"></i></a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->people_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePeople"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $userData = User::all();
        $data = [
            'pageTitle' => 'People',
            'userData' => $userData
        ];
        return view('admin/people', $data);
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
            'id' => ['required', 'unique:peoples', 'max:50'],
            'namaDepan' => ['required'],
            'jenisKelamin' => ['required'],
            'tanggalLahir' => ['required'],
            'people_noktp' => ['required', 'unique:peoples'],
            'people_nohp' => ['required', 'unique:peoples'],
            'alamat' => ['required'],
        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()]);

        DB::beginTransaction();
        try {
            $peopleId = Str::uuid();

            $people = new People();
            $people->people_id = $peopleId;
            $people->id = $request->id;
            $people->people_namadepan = $request->namaDepan;
            $people->people_namabelakang = $request->namaBelakang;
            $people->people_jeniskelamin = $request->jenisKelamin;
            $people->people_tanggallahir = $request->tanggalLahir;
            $people->people_noktp = $request->people_noktp;
            $people->people_nohp = $request->people_nohp;
            $people->people_alamat = $request->alamat;

            if ($people->save()) {
                DB::commit();
                return response()->json(['success' => true, 'errors' => false]);
            } else {
                throw new \Exception('Failed saving people data!');
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
     * @param  \App\Models\Admin\People  $people
     */
    public function show(string $id, Request $request)
    {
        $people = People::getAllData($id);
        if ($request->ajax()) return response()->json($people);
        return 'REQUEST TYPE ERROR!';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $id
     */
    public function edit(string $id, Request $request)
    {
        $people = People::getAllData($id);
        if ($request->ajax()) return response()->json($people);
        return 'REQUEST TYPE ERROR!';
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\People  $people
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $people = People::where('people_id', $id)->first();
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'max:50', Rule::unique('peoples')->ignore($people)],
            'namaDepan' => ['required'],
            'jenisKelamin' => ['required'],
            'tanggalLahir' => ['required'],
            'people_noktp' => ['required', Rule::unique('peoples')->ignore($people)],
            'people_nohp' => ['required', Rule::unique('peoples')->ignore($people)],
            'alamat' => ['required'],

        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()]);
        DB::beginTransaction();
        try {
            $people->id = $request->id;
            $people->people_namadepan = $request->namaDepan;
            $people->people_namabelakang = $request->namaBelakang;
            $people->people_jeniskelamin = $request->jenisKelamin;
            $people->people_tanggallahir = $request->tanggalLahir;
            $people->people_noktp = $request->people_noktp;
            $people->people_nohp = $request->people_nohp;
            $people->people_alamat = $request->alamat;

            if ($people->save()) {
                DB::commit();
                return response()->json(['success' => true, 'message' => 'User updated successfully!', 'code' => 200]);
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
     * @param  \App\Models\Admin\People  $people
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $people = People::where('people_id', $id)->first();
        if (!$people) return  response()->json(['success' => false, 'message' => 'People with id: '.$id.' not found!']);
        if($people->delete()) return response()->json(['success' => true, 'message' => 'Successfully deleting people.']);
        else return response()->json(['success' => false, 'message' => 'Failed deleting people.']);
    }
}
