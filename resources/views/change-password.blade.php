@extends('layouts.default')

@section('name' ,'Edit Profile')

@section('content')

    <div class="row">
        <div class="col-md-9">
            <form action="{{route('password.change')}}" method="post" >
                @csrf

                <div class="form-group mb-3">
                    <x-form-input type="password" name="current_password" label="Current password" />
                </div>

                <div class="form-group mb-3">
                    <x-form-input type="password" name="password" label="New password" />
                </div>

                <div class="form-group mb-3">
                    <x-form-input type="password" name="password_confirmation" label="Confirm password" />
                </div>


                <div class="form-group">
                    <div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection

