@extends('backEnd.layouts.main')
@section('title', 'Profile - '.config('app.name'))
@section('content')
<div class="pagetitle">
    <h1>Data Profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item">User Management</li>
        <li class="breadcrumb-item active">Profile</li>
      </ol>
    </nav>
</div
<section class="section profile">
    <div class="row">
      <div class="col-xl-4">

        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <img src="{{$profile->image_url}}" alt="Profile" class="rounded-circle img-logo mb-2">
            <h2>{{$profile->name}}</h2>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>
            </ul>
            <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">Profile Details</h5>
                <div class="row mb-2">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8">{{$profile->name}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-3 col-md-4 label ">Email</div>
                  <div class="col-lg-9 col-md-8">{{$profile->email}}</div>
                </div>
                <div class="row mb-2">
                  <div class="col-lg-3 col-md-4 label">Company</div>
                  <div class="col-lg-9 col-md-8">Log In Megastore</div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Role</div>
                  <div class="col-lg-9 col-md-8">{{$profile->roles->pluck('name')[0] ?? '-'}}</div>
                </div>
              </div>
              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <!-- Profile Edit Form -->
                <form action="{{route('profile.store')}}" method="POST" enctype="multipart/form-data" id="form-profile">
                    @csrf
                    <div class="row mb-3">
                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                        <div class="col-md-8 col-lg-9">
                        <img src="{{$profile->image_url}}" alt="Profile" class="img-profile" id="image-profile">
                        <div class="pt-2">
                            <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="document.getElementById('image-profile').src = window.URL.createObjectURL(this.files[0])">
                        </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-lg-3 col-form-label">Name</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="name" type="text" class="form-control  @error('name') is-invalid @enderror" id="name" value="{{$profile->name}}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Old Password<span class="text-red">*</span></label>
                        <div class="col-md-8 col-lg-9">
                            <input name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror" id="old_password" placeholder="Enter Your Old Password">
                            @error('old_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Password<span class="text-red">*</span></label>
                        <div class="col-md-8 col-lg-9">
                            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Enter Your New Password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Confirm Password<span class="text-red">*</span></label>
                        <div class="col-md-8 col-lg-9">
                            <input name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" placeholder="Enter Your Confirmation Password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End Profile Edit Form -->
              </div>
            </div><!-- End Bordered Tabs -->
          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
@push('scripts')
  <script>
    $(document).ready(function () {
        if ($("#form-profile").length > 0) {
            $("#form-profile").validate({
                ignore: '*:not([name])',
                rules: {
                    name: {
                        required: true,
                    },
                    old_password: {
                        required: true,
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                },
                messages: {
                    name: {
                        required: "Name is required",
                    },
                    old_password: {
                        required: "Old Password is required",
                    },
                    password: {
                        required: "Password is required",
                    },
                    password_confirmation: {
                        required: "Confirm password is required",
                        equalTo: "Password does not match",
                    },
                },
                debug: false,
                errorPlacement: function(error, element) {
                    var name = element.attr('name');
                    var errorSelector = '.form-control-feedback[for="' + name + '"]';
                    var $element = $(errorSelector);
                    if ($element.length) {
                        $(errorSelector).html(error.html());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler : function(form) {
                    form.submit();
                }
            })
        }
    });
  </script>
@endpush
