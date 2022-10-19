<div class="mb-3">
    <label class="form-label" for="{{$name}}">{{$label}}</label>
    <input type="{{$type??'text'}}" value="{{ old($name,$defaultValue) }}" class="form-control @error($name) is-invalid @enderror
        @error($name.'*') is-invalid @enderror" name="{{$multiple? $name.'[]':$name}}" id="{{$name}}" @if ($multiple)
        multiple @endif @if($form) form="{{$form}} @endif">
    @error($name)
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if ($multiple)
    @error("$name.*")
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    @endif
</div>
