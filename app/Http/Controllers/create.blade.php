@extends('admin.layouts.master')
@section('title','Form Page|Brands')
@section('page')
 Create Brand
@stop

@section('content')


<form  action="{{ route('brands.store') }}" method="POST" enctype="multipart/form-data">

{{ csrf_field() }}
  <div class="form-group">
    <label for="exampleInputPassword1">Name-Brand</label>
    {{ Form::text('name',null,['class'=>'form-control','placeholder'=>'Brand Name']) }}
    <span class="text-danger">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">File</label>
    {{ Form::file('file',['class'=>'form-control']) }}
    <span class="text-danger">{{ $errors->has('file') ? $errors->first('file') : '' }}</span>
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>

</form>

@stop
