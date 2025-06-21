<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Posts;

class PostController extends Controller
{
    public function index() {
        // postsテーブルからすべてのデータを取得し、変数$postsに代入する
        $posts = DB::table('posts')->get();

        // 変数$postsをproducts/index.blade.phpファイルに渡す
        return view('posts.index', compact('posts'));
    } 
    public function show($id) {
        // URL'/posts/{id}'の'{id}'部分と主キー（idカラム）の値が一致するデータをpostsテーブルから取得し、変数$postに代入する
        $post = Posts::find($id);

        // 変数$postをposts/show.blade.phpファイルに渡す
        return view('posts.show', compact('post'));
    }

    public function create() {
        return view('posts.create');
    } 

     // 投稿保存処理（バリデーション付き）
    public function store(Request $request)
    {
        // バリデーションを実行
        $validated = $request->validate([
            'title' => 'required|max:20',
            'content' => 'required|max:200',
        ]);

        // データベースに保存
        Posts::create($validated);

        // 投稿一覧へリダイレクト
        return redirect('/posts');
    }
}
