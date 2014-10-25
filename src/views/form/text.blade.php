<div class="form-group">
	<label for="{{ $name }}">{{ Str::title($name) }}</label>
	<input type="text" class="form-control" id="{{ $name }}" name="{{ $name }}" placeholder="Enter {{ $name }}" value="{{ $value }}">
</div>