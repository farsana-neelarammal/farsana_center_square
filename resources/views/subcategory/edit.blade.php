@extends('layouts.app')

@section('content')
<div class="container pt-4">
    @include('layouts.alert')
    <div class="card">
        <div class="card-header">
            Category
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{route('subcategory.update',$category->id)}}">
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
                    <label class="col-sm-2 control-label">Category</label>
                         
                    <div class="col-sm-10">
                        <select name="parent_id" id="parent_id" class="form-control" style="width: 100%" required>
                            @foreach($cat_data as $category_data)
                                <option @if($category->parent_id == $category_data->id) selected @endif value="{{$category_data->id}}">{{$category_data->name}} </option>
                            @endforeach
                        </select>
                        @if($errors->first('parent_id'))
                            <p class="help-block text-danger" style="color: red">{{ $errors->first('parent_id') }}</p>
                        @endif

                    </div>
                </div>
        
                <div class="form-group row">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-info">Submit</button>
                        <a href="{{route('subcategory.index')}}" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection