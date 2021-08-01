@extends('layouts.app')

@section('content')

<div class="container pt-4">
    @include('layouts.alert')
    <div class="card">
        <div class="card-header">
            Category
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12" style="text-align-last: end;">
                    <a href="{{ route('category.create') }}" class="btn btn-info">Add New Category </a>
                </div>
            </div>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category Name</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($categories)
                        @foreach ($categories as $category)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$category->name}}</td>
                                <td>{{$category->slug}}</td>
                                <td>
                                    <a href="{{ route('category.edit', $category->id) }}" class="btn btn-primary">Edit </a>
                                    
                                    <form method="POST" action="{{route('category.destroy',$category->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <p>No records found!</p>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection