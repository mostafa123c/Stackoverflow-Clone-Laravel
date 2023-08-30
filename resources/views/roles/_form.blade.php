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
    <!--div.form-group-->
    <div class="form-group mb-3">
        <label for="name">Role Name :</label>
        <div class="mt-3">
            <!-- input.form-control-->
            <input type="text" name='name' value="{{ old('name', $role->name) }}" class="form-control @error('name')is-invalid @enderror">
            @error('name')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
{{--            <!-- @if($errors->has('name'))--}}
{{--                <p class="text-danger">{{ $errors->first('name') }}</p>--}}
{{--            @endif -->--}}
        </div>
        <div class="mt-3">
            @foreach(config('abilities') as $code => $label)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $code }}" name="abilities[]" @if(in_array($code, ($role->abilities ?? [] ))) checked @endif>
                    <label class="form-check-label">
                        {{ $label }}
                    </label>
                </div>
            @endforeach
        </div>
        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
</form>
