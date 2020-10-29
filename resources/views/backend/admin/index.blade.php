@extends('backend.layouts.master')

@section('content')
<nav aria-label="breadcrumb" class="paths-nav">
    <ol class="breadcrumb breadcrumb-inverse">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard.index')}}">Home</a>
        </li>

        <li class="breadcrumb-item active" aria-current="page">All Admins</li>
    </ol>
</nav>
    <div class="card card-default">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>Admins</h2>
            <a href="{{route('Admin.create')}}" title="add new Admin" class="btn btn-sm btn-primary"><i class="mdi mdi-plus-circle-outline"></i></a>
        </div>
        <div class="card-body">
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Avatar</th>
                    <th scope="col">Status</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Group</th>
                    <th scope="col">Permissions</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
               @foreach($admins as $admin)
                   <tr>
                       <td scope="row">{{$admin->id}}</td>
                       <td>
                            <img src="{{ uploads($admin->avatar) }}" class="rounded-circle" style="width: 40px;height:40px">
                       </td>
                       <td>
                           @if($admin->status === 'blocked')
                           <i class="mdi mdi-block-helper mdi-24px text-danger" title="blocked"></i>
                           @else
                           <i class="mdi mdi-check mdi-24px text-success" title="not blocked (active) "></i>
                           @endif
                       </td>
                       <td>{{$admin->name}}</td>
                       <td>{{$admin->email}}</td>
                       <td>{{$admin->adminGroup->display_name}}</td>
                       <td>
                           <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#admin-{{$admin->id}}-group"><i class="mdi mdi-eye-outline"></i></button>
                       </td>
                       <td>
                           <button class="btn btn-sm btn-danger" onclick="RemoveItem('form-item-group-{{$admin->id}}')"><i class="mdi mdi-delete-outline"></i></button>
                           <a href="{{route('Admin.edit',$admin->id)}}" class="btn btn-sm btn-success"><i class="mdi mdi-square-edit-outline"></i></a>
                       </td>
                   </tr>
                   <form action="{{route('Admin.destroy',$admin->id)}}" id="form-item-group-{{$admin->id}}" method="post"> @csrf @method('DELETE')</form>
                   <!-- Tooltip Modal -->
                   <div class="modal fade" id="admin-{{$admin->id}}-group" tabindex="-1" role="dialog" aria-labelledby="{{$admin->id}}-group" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-centered" role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="{{$admin->adminGroup->name}}-group-title">Permissions Of {{$admin->adminGroup->display_name}} Group</h5>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>
                               <div class="modal-body">

                                   @foreach($admin->adminGroup->permissions as $permission)
                                       <span class="badge badge-info badge-pill text-center mb-2">{{$permission->display_name}}</span>
                                   @endforeach

                               </div>
                               <div class="modal-footer">
                                   <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                               </div>
                           </div>
                       </div>
                   </div>

               @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection
