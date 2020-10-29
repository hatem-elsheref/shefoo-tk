@extends('backend.layouts.master')

@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard.index')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('Admin.index')}}">Admins</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Create New Admin</li>
        </ol>
    </nav>
    <div class="card card-default mt-2">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>Add New Admin</h2>
            <a href="{{route('Admin.index')}}" title="show all Admins" class="btn btn-sm btn-primary"><i class="mdi mdi-backup-restore"></i></a>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('Admin.store')}}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter The Admin Name" value="{{old('name')}}">
                            @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Enter The Admin Email" value="{{old('email')}}">
                            @error('email')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter The Admin Password" value="{{old('password')}}">
                            @error('password')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="group">Group</label>
                           <select name="group" class="form-control">
                               <option selected disabled> __select__</option>
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
                            <label for="coverImage">Avatar</label>
                            <div class="custom-file mb-1">
                                <input type="file" class="custom-file-input" name="image" id="coverImage" >
                                <label class="custom-file-label" for="coverImage">Choose file...</label>
                            </div>
                            <img style="width: 60px;height:60px" id="img-preview" class="mt-2 img-responsive  img-fluid" src="{{ uploads(mainPath(_ADMIN.'/'.DEFAULT_AVATAR)) }}">

    
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="group">Status</label>
                            <label class="control control-checkbox checkbox-primary">Blocked
                                <input type="checkbox" name="status" @if(old('status')) checked @endif>
                                <div class="control-indicator"></div>
                            </label>
                        </div>
                    </div>


                </div>
                
                <div class="form-footer pt-5 border-top">
                    <button type="submit" class="btn btn-primary btn-default">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection
