@props(['id', 'name', 'label', 'value' => null ])
<label for="{{ $id }}">{{ $label }}</label>
<div>
    <textarea   id="{{ $id  }}"  name="{{ $name }}" {{ $attributes->class(['form-control' , 'is-invalid' => $errors->has($name)]) }}>
        {{old($name , $value)}}
    </textarea>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

