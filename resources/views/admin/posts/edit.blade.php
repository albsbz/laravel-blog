@extends('admin.layout');

  @section('content') 
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Изменить статью
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      @include('admin.errors');
    {!! Form::open([
        'route'=>['posts.update', $post->id],
        'files'=>'true',
        'method'=>'put'
    ]) !!}

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Обновляем статью</h3>
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Название</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" name="title" value="{{$post->title}}">
            </div>
            
            <div class="form-group">
              <img src="{{$post->getImage()}}" alt="" class="img-responsive" width="200">
              <label for="exampleInputFile">Лицевая картинка</label>
              <input type="file" id="exampleInputFile" name="image">

              <p class="help-block">Какое-нибудь уведомление о форматах..</p>
            </div>
            <div class="form-group">
              <label>Категория</label>
              {!!  Form::select(
                'category', 
                $categories->pluck('title', 'id'), 
                $post->getCategoryId(), 
                [
                    'class' => 'form-control select2',
                    'style'=>'width: 100%;' ,                   
                ]);
              !!}
            </div>
            <div class="form-group">
              <label>Теги</label>
              {!!  Form::select(
                'tags[]', 
                $tags->pluck('title', 'id'), 
                $post->tags->pluck('id')->all(), 
                [
                    'class' => 'form-control select2',
                    'style'=>'width: 100%;' ,    
                    'multiple'=>'multiple',
                    'data-placeholder'=>'Выберите теги'

                ]);
              !!}
            </div>
            <!-- Date -->
            <div class="form-group">
              <label>Дата:</label>

              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker" name="date" value="{{$post->date}}">
              </div>
              <!-- /.input group -->
            </div>

            <!-- checkbox -->
            <div class="form-group">
              <label>
                {{Form::checkbox('is_featured', '1', $post->is_featured, ['class'=>'minimal'])}}
              </label>
              <label>
                Рекомендовать
              </label>
            </div>
            <!-- checkbox -->
            <div class="form-group">
              <label>
                {{Form::checkbox('is_featured', '1', $post->status, ['class'=>'minimal'])}}
              </label>
              <label>
                Черновик
              </label>
            </div>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">описание</label>
              <textarea id="" cols="30" rows="10" class="form-control" name="description" value="{{old('description')}}">{{$post->description}}</textarea>
          </div>
          <div class="col-md-12">
            <div class="form-group">
              <label for="exampleInputEmail1">Полный текст</label>
            <textarea id="" cols="30" rows="10" class="form-control" name="content" value="{{old('content')}}">{{$post->content}}
              </textarea>
          </div>
        </div>
      </div>
        <!-- /.box-body -->
        <div class="box-footer">
            <a href="{{route('posts.index')}}" class="btn btn-default">Назад</a>
            <button class="btn btn-success pull-right">Добавить</button>
        </div>
        <!-- /.box-footer-->
      </div>
      {!! Form::close() !!}
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @endsection