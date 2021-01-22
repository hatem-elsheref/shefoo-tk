@extends('backend.layouts.master')
@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard.index')}}">{{__('backend.home')}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('Category.index')}}">{{__('backend.categories')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{__('backend.edit_category')}}</li>
        </ol>
    </nav>
    <div class="card card-default mt-2">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>{{__('backend.edit_category')}}</h2>
            <a href="{{route('Category.index')}}" title="{{__('backend.show_all_categories')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-backup-restore"></i></a>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('Category.update',$category->id)}}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="name">{{__('backend.form_name')}}</label>
                            <input type="text" class="form-control" name="name" placeholder="{{__('backend.enter')}} {{__('backend.category')}} {{__('backend.form_name')}}" value="{{$category->name}}">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-footer pt-5 border-top">
                    <button type="submit" class="btn btn-primary btn-default">{{__('backend.save')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
