@props(['id', 'name', 'label', 'value' => null , 'type' => 'text'])
<label for="{{ $id }}">{{ $label }}</label>
<div>
    <input type={{ $type}}"  id="{{ $id  }}"  name="{{ $name }}" value="{{old($name , $value)}}" {{ $attributes->class(['form-control' , 'is-invalid' => $errors->has($name)]) }}>
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

