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
            <li class="breadcrumb-item active" aria-current="page">Show All Groups</li>
        </ol>
    </nav>
    <div class="card card-default mt-2">
        <div class="card-header card-header-border-bottom justify-content-between">
            <h2>Groups</h2>
            <a href="{{route('group.create')}}" title="add new group" class="btn btn-sm btn-primary"><i class="mdi mdi-plus-circle-outline"></i></a>
        </div>
        <div class="card-body">
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Display Name</th>
                    <th scope="col">Permissions</th>
                    <th scope="col">Total Admins</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
               @foreach($groups as $group)
                   <tr>
                       <td scope="row">{{$group->id}}</td>
                       <td>{{$group->name}}</td>
                       <td>{{$group->display_name}}</td>
                       <td>
                           <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#{{$group->name}}-group"><i class="mdi mdi-eye-outline"></i></button>
                       </td>
                       <td>{{ count($group->admins) }}</td>
                       <td>
                           <button class="btn btn-sm btn-danger" onclick="RemoveItem('form-item-group-{{$group->id}}')"><i class="mdi mdi-delete-outline"></i></button>
                           <a href="{{route('group.edit',$group->name)}}" class="btn btn-sm btn-success"><i class="mdi mdi-square-edit-outline"></i></a>
                       </td>
                   </tr>
                   <form action="{{route('group.destroy',$group->name)}}" id="form-item-group-{{$group->id}}" method="post">@csrf @method('DELETE')</form>
                   <!-- Tooltip Modal -->
                   <div class="modal fade" id="{{$group->name}}-group" tabindex="-1" role="dialog" aria-labelledby="{{$group->name}}-group" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-centered" role="document">
                           <div class="modal-content">
                               <div class="modal-header">
                                   <h5 class="modal-title" id="{{$group->name}}-group-title">Permissions Of {{$group->display_name}} Group</h5>
                                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                   </button>
                               </div>
                               <div class="modal-body">

                                   @foreach($group->permissions as $permission)
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
