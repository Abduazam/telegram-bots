<div class="form-floating mb-4">
    <input type="{{ $type }}"
           @if($wire)
           wire:model="{{ $model }}"
           @endif
           class="form-control @error($model) is-invalid @enderror"
           id="{{ $model }}"
           name="{{ $model }}"
           @if(isset($value))
           value="{{ $value }}"
           @endif
           placeholder="{{ $placeholder }}"
           @if($required)
           required
           @endif
           @if($autocomplete)
           autocomplete="{{ $model }}"
           autofocus
           @endif>
    <label class="form-label" for="{{ $model }}">{{ $text }}</label>
    @if($error)
        @error($model)
        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
        @enderror
    @endif
</div>
