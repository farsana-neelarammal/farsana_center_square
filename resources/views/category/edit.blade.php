@extends('layouts.app')

@section('content')
<div class="container pt-4">
    @include('layouts.alert')
    <div class="card">
        <div class="card-header">
            Category
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{route('category.update',$category->id)}}">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="form-group row">
                    <label class="col-sm-2 control-label">Category Name</label>
                    
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" placeholder="Category Name" required value="{{ $category->name }}">
                        @if($errors->first('name'))
                            <p class="help-block text-danger" style="color: red">{{ $errors->first('name') }}</p>
                        @endif
        
                    </div>
                </div>
        
                <div class="form-group row">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Submit</button>
                        <a href="{{route('category.index')}}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection