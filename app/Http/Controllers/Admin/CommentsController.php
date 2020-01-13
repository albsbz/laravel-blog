<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentsController extends Controller
{
  public function index()
  {
    $comments=Comment::all();  
    return view('admin.comments.index', compact('comments'));
  }
  public function toggle($id)
  {
    $comments=Comment::all(); 
    Comment::where('id', $id)->first()->toggleStatus();  
    return redirect()->route('comments.index');
  }
  public function destroy($id)
    {
        Comment::find($id)->delete();
        return redirect()->route('comments.index');
    }
}
