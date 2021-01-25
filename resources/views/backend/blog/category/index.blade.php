@extends('backend.layouts.master')

@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard.index')}}">Home</a>
            </li>

            <li class="breadcrumb-item active" aria-current="page">{{__('backend.all_categories')}}</li>
        </ol>
    </nav>
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>{{__('backend.categories')}}  ({{$categories->total()}})</h2>
            @have('create_category')
            <a href="{{route('Category.create')}}" title="{{__('backend.add_new_category')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-plus-circle-outline"></i></a>
            @endhave
        </div>
        <div class="card-body">
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th scope="col">
{{--                        <i class="mdi mdi-key"></i> --}}
                        ID</th>
                    <th scope="col">
{{--                        <i class="mdi mdi-rename-box"></i> --}}
                        Name</th>
                    <th scope="col"><i class="mdi mdi-link text-primary"></i> Slug</th>
                    <th scope="col"><i class="mdi mdi-checkbox-marked-circle text-success"></i> Published Posts</th>
                    <th scope="col"><i class="mdi mdi-close-circle text-danger"></i> Drafted Posts</th>
                    <th scope="col"><i class="mdi mdi-clock text-info"></i> created_at</th>
                    <th scope="col"><i class="mdi mdi-wrench text-secondary"></i> Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $item)
                    <tr>
                        <td scope="row">{{$item->id}}</td>
                        <td>{{$item->name}}</td>
                        <td><a href="{{route('blog.searchByCategory',$item->slug)}}" target="_blank">/{{$item->slug}}</a></td>
                        <td>{{$item->published_posts}}</td>
                        <td>{{$item->drafted_posts}}</td>
                        <td>{{$item->created_at->format('Y-m-d @ h:i a')}}</td>
                        <td>
                            <a class="btn btn-sm btn-warning" href="{{route('Category.show',$item->id)}}"><i class="mdi mdi-eye-outline"></i></a>
                            @have('delete_category')
                            <button class="btn btn-sm btn-danger" onclick="RemoveItem('form-item-group-{{$item->id}}')"><i class="mdi mdi-delete-outline"></i></button>
                            @else
                                <button class="btn btn-sm btn-danger" disabled><i class="mdi mdi-delete-outline"></i></button>
                            @endhave
                            @have('update_category')
                                <a href="{{route('Category.edit',$item->id)}}" class="btn btn-sm btn-success"><i class="mdi mdi-square-edit-outline"></i></a>
                            @else
                                    <button class="btn btn-sm btn-success" disabled><i class="mdi mdi-square-outline"></i></button>
                            @endhave

                        </td>
                    </tr>
                    @have('delete_category')
                    <form action="{{route('Category.destroy',$item->id)}}" id="form-item-group-{{$item->id}}" method="post"> @csrf @method('DELETE')</form>
                    @endhave
                @endforeach
                </tbody>
            </table>
            <span class="float-right">
                {!! $categories->render() !!}
            </span>
        </div>
    </div>
@endsection
