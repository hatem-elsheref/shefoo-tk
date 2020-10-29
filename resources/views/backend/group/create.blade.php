@extends('backend.layouts.master')

@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item">
                <a href="{{route('dashboard.index')}}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{route('group.index')}}">Groups</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Create New Group</li>
        </ol>
    </nav>
    <div class="card card-default mt-2">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>Add New Group</h2>
            <a href="{{route('group.index')}}" title="show all groups" class="btn btn-sm btn-primary"><i class="mdi mdi-backup-restore"></i></a>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('group.store')}}">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter The Unique Group Name" value="{{old('name')}}">
                          @error('name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="display_name">Display Name</label>
                            <input type="text" class="form-control" name="display_name" placeholder="Enter The Group Display Name" value="{{old('display_name')}}">
                            @error('display_name')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                     <div class="row">
                    <div class="col-sm-12">
                        @error('permissions')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        <table class="table table-hover ">
                            <thead>
                            <tr>
                                <th scope="col">Model</th>
                                <th scope="col">Create</th>
                                <th scope="col">Read</th>
                                <th scope="col">Delete</th>
                                <th scope="col">Update</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($models as $modelName => $characters)
                                <tr>
                                    <td scope="row">{{ucfirst(strtolower($modelName))}}</td>

                                    @foreach($map as $char => $permissionName)
                                       @if(in_array($char,$characters))
                                            <td>
                                                <ul class="list-unstyled list-inline">
                                                    <li class="d-inline-block">
                                                        @foreach($permissions as $permission)
                                                            @if($permission['name'] === strtolower($permissionName).'_'.strtolower($modelName))
                                                                <label class="control  control-checkbox checkbox-primary">{{ucfirst($permissionName).' '.$modelName}}
                                                                    <input type="checkbox" name="permissions[]" @if(in_array($permission['id'],(array) old('permissions'))) checked @endif value="{{$permission['id']}}">
                                                                    <div class="control-indicator"></div>
                                                                </label>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                    </li>
                                                </ul>
                                            </td>
                                        @else
                                            <td>
                                                <ul class="list-unstyled list-inline">
                                                    <li class="d-inline-block">
                                                        <label class="control  control-checkbox checkbox-custom">{{ucfirst($permissionName).' '.$modelName}}
                                                            <input type="checkbox" disabled>
                                                            <div class="control-indicator"></div>
                                                        </label>
                                                    </li>
                                                </ul>
                                            </td>
                                       @endif
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="form-footer pt-5 border-top">
                    <button type="submit" class="btn btn-primary btn-default">Save</button>
                </div>
            </form>
        </div>
    </div>

@endsection
