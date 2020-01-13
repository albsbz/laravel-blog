<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function allow(){
        $this->status=1;
        $this->save();
    }
    public function disAllow(){
        $this->status=0;
        $this->save();
    }
    public function toggleStatus(){
        if ($this->status==0){
            return $this->allow();
        }
        return $this->disAllow();
    }
    public function remove(){
        $this->delete();
    }
   
    public function showDate(){
        return Carbon::createFromFormat('Y-m-d h:m:s', $this->created_at)->format('F, d, Y \\a\\t h:m');
    }
}

