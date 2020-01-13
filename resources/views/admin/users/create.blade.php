@extends('admin.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Добавить пользователя
        <small>приятные слова..</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      @include('admin.errors');
      {!! Form::open(['route' => 'users.store', 'files' => true]) !!}
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Добавляем пользователя</h3>
        </div>
        <div class="box-body">
          <div class="col-md-6">
            <div class="form-group">
              <label for="exampleInputEmail1">Имя</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{old('name')}}" name="name">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">E-mail</label>
              <input type="text" class="form-control" id="exampleInputEmail1" placeholder="" value="{{old('email')}}" name="email">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Пароль</label>
              <input type="password" class="form-control" id="exampleInputEmail1" placeholder="" name="password">
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Аватар</label>
              <input type="file" id="exampleInputFile" name="avatar">

              <p class="help-block">Какое-нибудь уведомление о форматах..</p>
            </div>
        </div>
      </div>
      {!! Form::close() !!}
        <!-- /.box-body -->
        <div class="box-footer">
        <a href="{{route('tags.index')}}" class="btn btn-default">Назад</a>
          <button class="btn btn-success pull-right">Добавить</button>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection