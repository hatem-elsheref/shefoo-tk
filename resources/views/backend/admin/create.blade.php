@extends('backend.layouts.master')

@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard.index')}}">{{__('backend.home')}}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('Admin.index')}}">{{__('backend.admins')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{__('backend.create_admin')}}</li>
        </ol>
    </nav>
    <div class="card card-default mt-2">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>{{__('backend.create_new_admin')}}</h2>
            <a href="{{route('Admin.index')}}" title="{{__('backend.show_all_admins')}}" class="btn btn-sm btn-primary"><i class="mdi mdi-backup-restore"></i></a>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('Admin.store')}}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">{{__('backend.form_name')}}</label>
                            <input type="text" class="form-control" name="name" placeholder="{{__('backend.enter')}} {{__('backend.admin')}} {{__('backend.form_name')}}" value="{{old('name')}}">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">{{__('backend.form_email')}}</label>
                            <input type="text" class="form-control" name="email" placeholder="{{__('backend.enter')}} {{__('backend.admin')}} {{__('backend.form_email')}}" value="{{old('email')}}">
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">{{__('backend.form_password')}}</label>
                            <input type="password" class="form-control" name="password" placeholder="{{__('backend.enter')}} {{__('backend.admin')}} {{__('backend.form_password')}}" value="{{old('password')}}">
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="group">{{__('backend.form_group')}}</label>
                           <select name="group" class="form-control">
                               <option selected disabled> {{__('backend.select_option')}}</option>
                               @foreach($groups as $group)
                               <option value="{{ $group->id }}" @if(old('group') == $group->id) selected @endif>{{ $group->display_name }}</option>
                               @endforeach
                           </select>
                           @error('group')
                           <span class="text-danger">{{$message}}</span>
                           @enderror
                        </div>
                    </div>



                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="coverImage">{{__('backend.form_avatar')}}</label>
                            <div class="custom-file mb-1">
                                <input type="file" class="custom-file-input" name="image" id="coverImage" >
                                <label class="custom-file-label" for="coverImage">{{__('backend.choice_file')}}</label>
                            </div>
                            <img style="width: 60px;height:60px" id="img-preview" class="mt-2 img-responsive  img-fluid" src="{{ uploads(mainPath(_ADMIN.'/'.DEFAULT_AVATAR)) }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="group">{{__('backend.status')}}</label>
                            <label class="control control-checkbox checkbox-primary">{{__('backend.blocked')}}
                                <input type="checkbox" name="status" @if(old('status')) checked @endif>
                                <div class="control-indicator"></div>
                            </label>
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
