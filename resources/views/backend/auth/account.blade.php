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
                            <img src="{{ uploads(auth('backend')->user()->avatar) }}" style="width:100px;height:100px" alt="{{ auth('backend')->user()->name }} avatar">
                        </div>
                        <div class="card-body">
                            <h4 class="py-2 text-dark">{{ ucwords(auth('backend')->user()->name) }}</h4>
                            <p>{{ auth('backend')->user()->email }}</p>
                        
                        </div>
                    </div>
            
                    <hr class="w-100">
                    <div class="contact-info pt-4">
                        <h5 class="text-dark mb-1">Contact Information</h5>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Email address</p>
                        <p>{{ auth('backend')->user()->email }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Group</p>
                        <p>{{ ucwords(auth('backend')->user()->adminGroup->name) }}</p>
                        <p class="text-dark font-weight-medium pt-4 mb-2">Created At</p>
                        <p>{{ auth('backend')->user()->created_at->format('Y-m-d @ h:i:s a') }}</p>
                       
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xl-9">
                <div class="profile-content-right py-5">
                    <ul class="nav nav-tabs px-3 px-xl-5 nav-style-border" id="myTab" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="settings-tab" data-toggle="tab" href="#settings" role="tab"
                                aria-controls="settings" aria-selected="true">Settings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#secutity" role="tab"
                                aria-controls="secutity" aria-selected="true">Security</a>
                        </li>
                    </ul>
                    <div class="tab-content px-3 px-xl-5" id="myTabContent">

                        
                        <div class="tab-pane fade active show" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <div class="mt-5">
                                <form method="POST" action="{{ route('dashboard.account.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row mb-6">
                                        <label for="coverImage" class="col-sm-4 col-lg-2 col-form-label">Your Avatat</label>
                                        <div class="col-sm-8 col-lg-10">
                                            <div class="custom-file mb-1">
                                                <input type="file" class="custom-file-input" name="avatar" id="coverImage" required="">
                                                <label class="custom-file-label" for="coverImage">Choose file...</label>
                                                <div class="invalid-feedback">Example invalid custom file feedback</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Your Name</label>
                                                <input type="text" class="form-control" name="name" id="name" value="{{ auth('backend')->user()->name }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="email">Your Email</label>
                                        <input type="email" class="form-control" name="email" id="email"
                                            value="{{ auth('backend')->user()->email }}">
                                    </div>


                                    <div class="d-flex justify-content-end mt-5">
                                        <button type="submit" class="btn btn-primary mb-2">Save</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="secutity" role="tabpanel" aria-labelledby="secutity-tab">
                            <div class="mt-5">
                                <form method="POST" action="{{ route('dashboard.account.reset') }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mb-4">
                                        <label for="old_password">Old password</label>
                                        <input type="password" name="old_password" class="form-control" id="old_password">
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="password">New password</label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>

                                    <div class="form-group mb-4">
                                        <label for="passworrd_confirmation">Confirm password</label>
                                        <input type="password" class="form-control" name="passworrd_confirmation" id="passworrd_confirmation">
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
