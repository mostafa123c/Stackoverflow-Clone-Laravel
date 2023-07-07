@extends('layouts.default')

@section('name' ,'Edit Profile')

@section('content')

<div class="row">
        <div class="col-md-3">
    <img src="{{ asset('storage/' .  $user->profile_photo_path) }}" class="img-fluid" alt="{{ $user->name }}">
        </div>
  <div class="col-md-9">
    <form action="{{route('profile')}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">First Name</label>
            <div>
                <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="name"  name="first_name" value="{{old('first_name' , $user->profile->first_name)}}">
                @error('first_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="name">Last Name</label>
            <div>
                <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"  name="last_name" value="{{old('last_name' , $user->profile->last_name)}}">
                @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="email">Email Address</label>
            <div>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"  name="email" value="{{old('email' , $user->email)}}" disabled>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="birthday">Birthday</label>
            <div>
                <input type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday"  name="birthday" value="{{old('birthday' , $user->profile->birthday)}}">
                @error('birthday')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
        </div>

             <div class="form-group mb-3">
               <label for="name">Gender</label>
               <div>
                   <div class="form-check">
                       <input class="form-check-input" type="radio" name="gender" value="male" id="gender-male" @if($user->profile->gender == 'male') checked @endif>
                       <label class="form-check-label" for="gender-male">
                           Male
                       </label>
                   </div>
                   <div class="form-check">
                       <input class="form-check-input" type="radio" name="gender" value="female" id="gender-female" @if($user->profile->gender == 'female') checked @endif>
                       <label class="form-check-label" for="gender-female">
                           Female
                       </label>
                   </div>
                   @error('gender')
                   <p class="invalid-feedback">{{ $message }}</p>
                   @enderror
               </div>
           </div>

            <div class="form-group mb-3">
                <label for="city">City</label>
                <div>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"  name="city" value="{{old('city' , $user->profile->city)}}">
                    @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-3">
                <label for="country">Country</label>
                <div>
                    <select class="form-control @error('country') is-invalid @enderror" id="country"  name="country" >
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country }}" @if($user->profile->country == $country) selected @endif>{{ $country }}</option>
                        @endforeach
                    </select>
                    @error('country')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>





        <div class="form-group mb-3">
            <label for="profile_photo">Profile Photo</label>
            <div>
                <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo"  name="profile_photo">
                @error('profile_photo')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </div>
        </div>

    </form>

 </div>
</div>

@endsection

