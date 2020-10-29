@extends('backend.layouts.master')

@section('content')
    <nav aria-label="breadcrumb" class="paths-nav">
        <ol class="breadcrumb breadcrumb-inverse">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Home</a>
            </li>
            
            <li class="breadcrumb-item active" aria-current="page">My Account</li>
        </ol>
    </nav>




    <div class="bg-white border rounded">
        <div class="row no-gutters">
            <div class="col-lg-4 col-xl-3">
                <div class="profile-content-left pt-5 pb-3 px-3 px-xl-5">
                    <div class="card text-center widget-profile px-0 border-0">
                        <div class="card-img mx-auto rounded-circle">
                            <img src="{{ uploads(auth(ADMIN_GUARD)->user()->avatar) }}" style="width:100px;height:100px" alt="{{ auth(ADMIN_GUARD)->user()->name }} avatar">
                        </div>
                        <div class="card-body">
                            <h4 class="py-2 text-dark">{{ ucwords(auth(ADMIN_GUARD)->user()->name) }}</h4>
                            <p>{{ auth(ADMIN_GUARD)->user()->email }}</p>
                        
                        </div>
                    </div>
            
                    <hr class="w-100">
                    <div class="contact-info pt-4">
                        <h5 class="text-dark mb-1">Contact Information</h5>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
                        <p>{{ auth(ADMIN_GUARD)->user()->email }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Group</p>
                        <p>{{ ucwords(auth(ADMIN_GUARD)->user()->adminGroup->name) }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Created At</p>
                        <p>{{ auth(ADMIN_GUARD)->user()->created_at->format('Y-m-d @ h:i:s a') }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Permissions</p>
                       @foreach(session('permissions') as $permission)
                           <span class="badge badge-info mt-2">{{ $permission }}</span>
                       @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="profile-content-right py-5">
                    <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link @if(empty(old('tab')) || old('tab') ==='information') active @endif " id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                                aria-controls="settings" aria-selected="true">Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(old('tab') ==='security') active @endif " id="settings-tab" data-toggle="tab" href="#secutity" role="tab"
                                aria-controls="secutity" aria-selected="true">Security</a>
                        </li>
                    </ul>
                    <div class="tab-content px-3 px-xl-5" id="myTabContent">

                        
                        <div class="tab-pane fade @if(empty(old('tab')) || old('tab') ==='information') active  show @endif " id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="mt-5">
                                <form method="POST" action="{{ route('dashboard.account.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="tab" value="information">
                                    <div class="form-group row">
                                        <label for="coverImage" class="col-sm-4 col-lg-2 ">Your Avatar</label>
                                        <div class="col-sm-6 col-lg-9">
                                            <div class="custom-file mb-1">
                                                <input type="file" class="custom-file-input" name="image" id="coverImage" >
                                                <label class="custom-file-label" for="coverImage">Choose file...</label>
                                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-lg-1">
                                            <img style="width: 60px;height:60px" id="img-preview" class="img-responsive  img-fluid" src="{{ uploads(auth(ADMIN_GUARD)->user()->avatar) }}">
                                        </div>
                                       
   
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-12">
                                            <label for="name">Your Name</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid   @enderror" id="name" value="{{ auth(ADMIN_GUARD)->user()->name }}" >
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-lg-12">
                                            <label for="email">Your Email</label>
                                            <input type="text" name="email" class="form-control @error('email') is-invalid   @enderror" id="email" value="{{ auth(ADMIN_GUARD)->user()->email }}" >
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                            


                                    <div class="d-flex justify-content-end mt-5">
                                        <button type="submit" class="btn btn-primary mb-2">Save</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                       
                        <div class="tab-pane fade @if(old('tab') ==='security') active show @endif" id="secutity" role="tabpanel" aria-labelledby="secutity-tab">
                            <div class="mt-5">
                                <form   method="POST" action="{{ route('dashboard.account.reset') }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="tab" value="security">
                                   
                                    <div class="form-group mb-4">
                                        <label for="old_password">Old password</label>
                                        @error('invalid_old_password')
                                        <div class="text-danger">*  {{ $message }} </div>
                                        @enderror
                                        <input type="password" name="old_password" class="form-control @error('old_password') is-invalid   @enderror" id="old_password">
                                        @error('old_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="password">New password</label>
                                        <input type="password" class="form-control @error('new_password') is-invalid   @enderror"  name="new_password" value="{{ old('new_password') }}" id="password">
                                        @error('new_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="password_confirmation">Confirm password</label>
                                        <input type="password" class="form-control @error('new_password') is-invalid   @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" id="password_confirmation">
                                        @error('new_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end mt-5">
                                        <button type="submit" class="btn btn-primary mb-2">Save</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

