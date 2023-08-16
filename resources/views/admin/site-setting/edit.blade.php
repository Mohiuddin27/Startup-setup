@extends('admin.layouts.app')

@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a>
                                </li>
                                <li class="breadcrumb-item active"><a href="{{route('admin.site-setting.index')}}">Site Setting</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic Vertical form layout section start -->
            <section id="basic-vertical-layouts">
                <div class="row match-height">
                    <div class="col-md-8 col-12 offset-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Setting</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    @include('admin.layouts.notify')
                                    @if ($data)
                                        <form class="form form-vertical" action="{{route('admin.site-setting.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                                        @method('patch')
                                    @else
                                        <form class="form form-vertical" action="{{route('admin.site-setting.store')}}" method="POST" enctype="multipart/form-data">
                                    @endif
                                        @csrf

                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical"> Title <span class="text-danger">*</span> </label>
                                                        <input type="text" id="first-name-vertical" value="{{$data->title??old('title')}}" class="form-control" name="title" placeholder="Title" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="contact-info-vertical">Logo</label>
                                                        @if ($data)
                                                            <img src="{{asset($data->logo)}}" alt="" width="80px">
                                                        @endif
                                                        <input type="file" id="contact-info-vertical" class="form-control" name="logo">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="contact-info-vertical">Favicon</label>
                                                        @if ($data)
                                                            <img src="{{asset($data->favicon)}}" alt="" width="80px">
                                                        @endif
                                                        <input type="file" id="contact-info-vertical" class="form-control" name="favicon">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="email-id-vertical">Address</label>
                                                        <textarea type="text" id="email-id-vertical" class="form-control" name="address" placeholder="Content">{!! $data->address?? '' !!}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical"> Phone <span class="text-danger">*</span> </label>
                                                        <input type="text" id="first-name-vertical" value="{{$data->phone??old('phone')}}" class="form-control" name="phone" placeholder="Phone" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical"> Email <span class="text-danger">*</span> </label>
                                                        <input type="text" id="first-name-vertical" value="{{$data->email??old('email')}}" class="form-control" name="email" placeholder="Email" required>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="first-name-vertical"> Website Link <span class="text-danger">*</span> </label>
                                                        <input type="text" id="first-name-vertical" value="{{$data->domain??old('domain')}}" class="form-control" name="domain" placeholder="exmple.com" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">
                                                        @if ($data)
                                                        Update
                                                        @else
                                                        Save
                                                        @endif
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- // Basic Vertical form layout section end -->
        </div>
    </div>
</div>
@endsection
