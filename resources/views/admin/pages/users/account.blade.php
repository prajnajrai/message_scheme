@extends('admin.layouts.master')

@section('content')
<div class="row">
  <div class="col-md-8">
      <div class="card">
          <div class="header">
              <h4 class="title">Edit Profile</h4>
          </div>
          <div class="content">
          	  @if(session()->has('status'))
					<div class="alert alert-success">{{ session()->get('status') }}</div>
          	  @endif
              <form method="post" action="{{ route('users.update', $user->id) }}">
              		@csrf
                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Name</label>
                              <input name="name" type="text" class="form-control" placeholder="Name" value="{{ $user->name }}">
                              @if($errors->has('name'))
										          <p class="help-block text-danger">{{ $errors->first('name') }}</p>
                              @endif
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Email address</label>
                              <input name="email" type="email" value="{{ $user->email }}" class="form-control" placeholder="Email">
                              @if($errors->has('email'))
										<p class="help-block text-danger">{{ $errors->first('email') }}</p>
                              @endif
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Facebook URL</label>
                              <input type="text" class="form-control" placeholder="Facebook URL" value="{{ $user->facebook }}" name="facebook">
                              @if($errors->has('facebook'))
										<p class="help-block text-danger">{{ $errors->first('facebook') }}</p>
                              @endif
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Twitter URL</label>
                              <input name="twitter" type="text" class="form-control" placeholder="Twitter URL" value="{{ $user->twitter }}">
                              @if($errors->has('twitter'))
										<p class="help-block text-danger">{{ $errors->first('twitter') }}</p>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Google Plus URL</label>
                              <input type="text" class="form-control" placeholder="Google Plus URL" value="{{ $user->googleplus }}" name="googleplus">
                              @if($errors->has('googleplus'))
										<p class="help-block text-danger">{{ $errors->first('googleplus') }}</p>
                              @endif
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label>New Password</label>
                              <input type="password" class="form-control" placeholder="Leave blank if you don't want to change" autocomplete="new-password" name="password">
                              @if($errors->has('password'))
                    <p class="help-block text-danger">{{ $errors->first('password') }}</p>
                              @endif
                          </div>
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label>About Me</label>
                              <textarea name="bio" rows="5" class="form-control" placeholder="Account bio">{{ $user->bio }}</textarea>
                              @if($errors->has('bio'))
										<p class="help-block text-danger">{{ $errors->first('bio') }}</p>
                              @endif
                          </div>
                      </div>
                  </div>

                  <button type="submit" class="btn btn-info btn-fill pull-right">Update Profile</button>
                  <div class="clearfix"></div>
              </form>
          </div>
      </div>
  </div>
  <div class="col-md-4">
      <div class="card card-user">
          <div class="image">
              <img src="https://ununsplash.imgix.net/photo-1431578500526-4d9613015464?fit=crop&fm=jpg&h=300&q=75&w=400" alt="..."/>
          </div>
          <div class="content">
              <div class="author">
                  <img class="avatar border-gray" src="{{ $user->gravatar }}" alt="{{ $user->name }}"/>

                    <h4 class="title">{{ $user->name }}<br />
                       <small>{{ $user->email }}</small>
                    </h4>
              </div>
               <p class="description text-center">
               	{{ Auth()->user()->bio }}
              </p>
          </div>
          <hr>
          <div class="text-center">
              <a href="{{ Auth()->user()->facebook }}" class="btn btn-simple"><i class="fa fa-facebook-square"></i></a>
              <a href="{{ Auth()->user()->twitter }}" class="btn btn-simple"><i class="fa fa-twitter"></i></a>
              <a href="{{ Auth()->user()->googleplus }}" class="btn btn-simple"><i class="fa fa-google-plus-square"></i></a>
          </div>
      </div>
  </div>

</div>
@endsection