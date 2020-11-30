<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
//     * @return \Illuminate\Http\Response
     * @return View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = User::latest()->get();
            return DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="edit btn btn-primary btn-sm viewUser"><i class="fa fa-eye"></i></a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm editUser"><i class="fa fa-edit"></i></a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data = [
            'pageTitle' => 'Customers',
        ];
        return view('admin/user', $data);
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
            'username' => ['required', 'unique:users', 'max:50'],
            'email' => ['required', 'unique:users'],
            'phone' => ['required', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()]);

        DB::beginTransaction();
        try {
            $userId = Str::uuid();
            $userLevel = $request->level != null ? $request->level : 0;
            $userRole = $request->role != null ? $request->role : 'MEMBER';

            $user = new User();
            $user->id = $userId;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->role = $userRole;
            $user->level = $userLevel;
            $user->status = 1;

            if ($user->save()) {
                DB::commit();
                return response()->json('User created successfully!');
//                return redirect('/admin/users')->with('success', 'Account created!');
            } else {
                return \Illuminate\Http\Response::create('Failed~!', 500);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            $erMessage = $exception->getMessage();
            $erCode = $exception->getCode();
            return \Illuminate\Http\Response::create($erMessage.' : '.$erCode, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', Rule::unique('users')->ignore($user->id)],
            'password' => ['sometimes', 'confirmed']
        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()]);

        DB::beginTransaction();
        try {
            $userLevel = $request->level != null ? $request->level : 0;
            $userRole = $request->role != null ? $request->role : 'MEMBER';

            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone = $request->phone;
            if ($request->password != null) $user->password = Hash::make($request->password);
            $user->role = $userRole;
            $user->level = $userLevel;
            $user->status = 1;

            if ($user->save()) {
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        User::destroy($id);
        return response()->json(['success' => true]);
    }
}
