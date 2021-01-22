@extends('backend.layouts.master')

@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard.index')}}">Home</a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">{{__('backend.all_tags')}}</li>
        </ol>
    </nav>
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>{{__('backend.tags')}}</h2>
            @have('create_tag')
            <a href="{{route('Tag.create')}}" title="{{__('backend.add_new_tag')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-plus-circle-outline"></i></a>
            @endhave
        </div>
        <div class="card-body">
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Show Posts</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags as $item)
                    <tr>
                        <td scope="row">{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->slug}}</td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="{{route('Tag.show',$item->id)}}"><i class="mdi mdi-eye-outline"></i></a>
                        </td>
                        <td>
                            @have('delete_tag')
                            <button class="btn btn-sm btn-danger" onclick="RemoveItem('form-item-group-{{$item->id}}')"><i class="mdi mdi-delete-outline"></i></button>
                            @else
                                <button class="btn btn-sm btn-danger" disabled><i class="mdi mdi-delete-outline"></i></button>
                            @endhave
                            @have('update_tag')
                                <a href="{{route('Tag.edit',$item->id)}}" class="btn btn-sm btn-success"><i class="mdi mdi-square-edit-outline"></i></a>
                            @else
                                    <button class="btn btn-sm btn-success" disabled><i class="mdi mdi-square-outline"></i></button>
                            @endhave

                        </td>
                    </tr>
                    @have('delete_tag')
                    <form action="{{route('Tag.destroy',$item->id)}}" id="form-item-group-{{$item->id}}" method="post"> @csrf @method('DELETE')</form>
                    @endhave
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
