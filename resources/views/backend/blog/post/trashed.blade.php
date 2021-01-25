@extends('backend.layouts.master')

@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('backend.all_trashed_posts')}}</li>
        </ol>
    </nav>
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>{{__('backend.trashed_posts')}} ({{$posts->total()}})</h2>
            <form class="form-inline" method="get" action="{{route('Post.trashed')}}">
                <input type="text" class="form-control mb-2 mr-sm-2" name="search" value="{{request()->input('search')}}" id="search" placeholder="Enter Any Keyword">
                <button type="submit" class="btn btn-warning mb-2">Search</button>
                @have('create_post')
                <a href="{{route('Post.create')}}" title="{{__('backend.add_new_post')}}" class="ml-2 btn btn-primary mb-2"><i class="mdi mdi-plus-circle-outline"></i></a>
                @endhave
            </form>

        </div>
        <div class="card-body">
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th scope="col">
                        {{--                        <i class="mdi mdi-key"></i> --}}
                        ID
                    </th>
                    <th scope="col">
                        {{--                        <i class="mdi mdi-camera-image"></i> --}}
                        Image</th>
                    <th scope="col">
                        {{--                        <i class="mdi mdi-account"></i> --}}
                        Author</th>
                    <th scope="col">
                        {{--                        <i class="mdi mdi-rename-box"></i> --}}
                        Title</th>
                    <th scope="col">
                        {{--                        <i class="mdi mdi-cube"></i> --}}
                        Category</th>
                    <th scope="col">
                        {{--                        <i class="mdi mdi-tag-multiple"></i> --}}
                        Tags</th>
                    <th scope="col"><i class="mdi mdi-link text-primary"></i> Slug</th>
                    <th scope="col"><i class="mdi mdi-marker-check text-success"></i> Status</th>
                    <th scope="col"><i class="mdi mdi-comment text-danger"></i> Comments</th>
                    <th scope="col"><i class="mdi mdi-comment-eye text-danger"></i> Views</th>
                    <th scope="col"><i class="mdi mdi-clock text-info"></i> created_at</th>
                    <th scope="col"><i class="mdi mdi-wrench text-secondary"></i> Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $item)
                    <tr>
                        <td scope="row">{{$item->id}}</td>
                        <td><img src="{{uploads($item->image)}}"  style="width: 60px;height: 60px" class="rounded-circle" alt="{{$item->slug}}"></td>
                        <td>{{ucwords($item->admin->name)}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->category->name}}</td>
                        <td>{{$item->tags_count}}</td>
                        <td><a href="{{route('blog.searchByPost',$item->slug)}}" target="_blank">/{{$item->slug}}</a></td>
                        <td>
                            @if($item->status == 'drafted')
                                {{--                                DRAFTED--}}
                                <i class="mdi mdi-close-circle text-danger"></i>
                            @else
                                {{--                                PUBLISHED --}}
                                <i class="mdi mdi-checkbox-marked-circle text-success"></i>
                            @endif
                        </td>
                        <td>{{$item->comments}}</td>
                        <td>{{$item->views}}</td>
                        <td>{{$item->created_at->format('Y-m-d @ h:i a')}}</td>
                        <td>
                            @have('delete_post')
                            <button class="btn btn-sm btn-danger" onclick="RemoveItem('form-item-group-{{$item->id}}','Do you want to remove this from system?')"><i class="mdi mdi-delete-outline"></i></button>
                            <button class="btn btn-sm btn-info" onclick="RemoveItem('form-item-group-{{$item->id}}-restore','Do you want to restore this?')"><i class="mdi mdi-refresh"></i></button>
                            @else
                                <button class="btn btn-sm btn-danger" disabled><i class="mdi mdi-delete-outline"></i></button>
                                <button class="btn btn-sm btn-info" disabled><i class="mdi mdi-refresh"></i></button>
                                @endhave
                                @have('update_post')
                                <a href="{{route('Post.edit',$item->id)}}" class="btn btn-sm btn-success"><i class="mdi mdi-square-edit-outline"></i></a>
                                <a href="{{route('Post.status',$item->id)}}" class="btn btn-sm btn-secondary"><i class="mdi mdi-marker-check"></i></a>
                                @else
                                    <button class="btn btn-sm btn-success" disabled><i class="mdi mdi-square-outline"></i></button>
                                    <button class="btn btn-sm btn-secondary" disabled><i class="mdi mdi-marker-check"></i></button>
                                    @endhave

                        </td>
                    </tr>
                    @have('delete_post')
                    <form action="{{route('Post.force-delete',$item->id)}}" id="form-item-group-{{$item->id}}" method="post"> @csrf @method('DELETE')</form>
                    <form action="{{route('Post.restore',$item->id)}}" id="form-item-group-{{$item->id}}-restore" method="post"> @csrf </form>
                    @endhave
                @endforeach
                </tbody>
            </table>
            <span class="float-right">
                {!! $posts->render() !!}
            </span>
        </div>
    </div>
@endsection

