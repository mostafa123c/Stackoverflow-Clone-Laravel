@if($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach($errors->all() as $message)
            <li>{{ $message }}</li>
        @endforeach
        </ul>
</div>
@endif
<form action="{{ $action }}" method="post">
    @csrf
    @if($update)
        @method('put')
    @endif

    <!-- input.form-control-->
    <div class="form-group mb-3">
        <label for="email">Email :</label>
        <input type="email" name="email" id="email" class="form-control @error('email')is-invalid @enderror" placeholder="Enter Email" value="{{ old('email', $admin->email) }}">
        @error('email')
            <p class="invalid-feedback">{{ $message }}</p>
        @enderror
    </div>

    <div class="form-group mb-3">
        <label for="type">Type :</label>
        <div class="mt-3">
            <select name="type" class="form-control @error('type')is-invalid @enderror">
                <option value="admin" @if(old('type', $admin->type) == 'admin') selected @endif>Admin</option>
                <option value="user" @if(old('type', $admin->type) == 'user') selected @endif>User</option>
                <option value="super-admin" @if(old('type', $admin->type) == 'super-admin') selected @endif>Super Admin</option>
            </select>
            @error('type')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
    </div>


    <div class="form-group mb-3">
        <label for="role">Roles :</label>
        <div class="mt-3">
            <select name="role_id" class="form-control @error('role_id')is-invalid @enderror">
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" @if(old('role_id', $admin->role_id) == $role->id) selected @endif>{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role_id')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
    </div>


        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

</form>
