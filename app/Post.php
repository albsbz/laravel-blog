<?php

namespace App;

use App\Tag;
use App\Comment;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;

class Post extends Model
{
    use Sluggable;

    const IS_DRAFT=0;
    const IS_PUBLIC=1;
    protected $fillable=['title','content', 'date', 'description'];
   
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public  function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public  function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        ); //many to many relationthiships through post_tags table

    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public static function add($fields)
    {
        $post=new static;
        $post->fill($fields);
        $post->user_id=Auth::user()->id;
        $post->save();
        return $post;
    }
    public function edit($fields){
        $this->fill($fields);
        $this->save();
    }
    public function remove(){
        $this->removeImage();
        $this->delete();
    }
    public function uploadImage($image){
        if ($image==null) {return;}
        $this->removeImage();
        $filename=Str::random(10).'.'.($image->extension());
        $image->storeAs('uploads', $filename);
        $this->image=$filename;
        $this->save;
    }
    public function getImage(){
        if ($this->image) {
           return '/uploads/'.$this->image;
        }
        return '/img/no-image.jpg';
    }
    public function removeImage(){
        if ($this->image!= null) {
            Storage::delete('uploads/'.$this->image);
        }
    }
    public function setCategory($id){
        if ($id==null) {return;}
        $this->category_id=$id;
        $this->save();
    }
    public function getCategoryTitle()
    {
        if (isset($this->category)) 
            {return  $this->category->title;}
        else
            {return  'No category';}
    }
    public function getCategoryId()
    {
        if (isset($this->category)) 
            {return  $this->category->id;}
        else
            {return  null;}
    }
    public function getTagsTitle()
    {

        if (!$this->tags->isEmpty()) 
            {return   implode(',', $this->tags->pluck('title')->toArray());}
        else
            {return  'No tags';}
    }
    public function setTags($ids){
        if ($ids==null) {return;}
        $this->tags()->sync($ids);
    }
    public function setDraft(){
        $this->status=Post::IS_DRAFT;
        $this->save();
    }
    public function setPublic(){
        $this->status=Post::IS_PUBLIC;
        $this->save();
    }
    public function toggleStatus($value){
        if ($value==null){
            return $this->setDraft();
        }
        return $this->setPublic();
    }
    public function setFeatured(){
        $this->is_featured=1;
        $this->save();
    }
    public function setStandart(){
        $this->is_featured=0;
        $this->save();
    }
    public function toggleFeatured($value){
        if ($value==null){
            return $this->setStandart();
        }
        return $this->setFeatured();
    }
    public function setDateAttribute($value){
        // dd($value);
       $date= Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
       $this->attributes['date']=$date;
    }
    public function getDateAttribute($value){
        // dd($value);
       $date= Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
       return $date;
    }
    public function showDate(){
        return Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
    }
    public function hasPrevious(){
        return Self::where('id', '<', $this->id)->max('id');    
    }
    public function getPrevious(){
        $postId=$this->hasPrevious();
        if ($postId) {
        return Self::where('id', $postId)->first();
        }
    }
    public function hasNext(){
        return Self::where('id', '>', $this->id)->min('id');    
    }
    public function getNext(){
        $postId=$this->hasNext();
        if ($postId) {
        return Self::find($postId);
        }
    }
    public function related(){
       return Self::all()->except('id', $this->id);
    }
    public function hasCategory(){
        return $this->category!=null?true:false;
     }
    public function getComments(){
        return $this->comments->where('status', 1);
    }
}


