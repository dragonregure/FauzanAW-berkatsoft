<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Mixed_;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $post = Post::latest()->get();
            return DataTables::of($post)
                ->addIndexColumn()
                ->addColumn('username', function ($row){
                    $user = User::find($row->id);
                    return $user->username;
                })
                ->addColumn('action', function ($row){
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->post_id.'" data-original-title="View" class="edit btn btn-primary btn-sm viewPost"><i class="fa fa-eye"></i></a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->post_id.'" data-original-title="Edit" class="edit btn btn-warning btn-sm editPost"><i class="fa fa-edit"></i></a>';

                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->post_id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost"><i class="fa fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $user = User::all();
        $data = [
            'pageTitle' => 'Posts',
            'userData' => $user,
        ];
        return view('admin/post', $data);
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
            'id' => ['required'],
            'postVisibility' => ['required'],
            'postContent' => ['required'],
        ]);

        if ($validator->fails()) return response()->json(['success' => false, 'errors' => $validator->errors()]);

        DB::beginTransaction();
        try {
            $postId = Str::uuid();

            $post = new Post();
            $post->post_id = $postId;
            $post->id = $request->id;
            $post->post_type = $request->postType == null ? 'BERITA' : $request->postType;
            $post->post_level = $request->postLevel == null ? 1 : $request->postLevel;
            $post->post_visibility = $request->postVisibility;
            $post->post_title = $request->postTitle;
            $post->post_content = $request->postContent;
            $post->post_reference = $request->postReference;
            $post->reference = $request->reference;
            $post->post_score = $request->postScore == null ? 0 : $request->postScore;

            if ($post->save()) {
                DB::commit();
                return response()->json(['success' => true, 'errors' => false]);
            } else {
                throw new \Exception('Failed saving post data!');
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
     * @param  \App\Models\Admin\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $post = Post::where('post_id', $id)->first();
        if (!$post) return  response()->json(['success' => false, 'message' => 'Post with id: '.$id.' not found!']);
        if($post->delete()) return response()->json(['success' => true, 'message' => 'Successfully deleting post.']);
        else return response()->json(['success' => false, 'message' => 'Failed deleting post.']);
    }
}
