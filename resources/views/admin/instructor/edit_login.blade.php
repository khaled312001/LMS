<div class="row mb-3">
    <label for="email" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Email') }}<span
            class="text-danger ms-1">*</span></label>
    <div class="col-sm-8">
        <input type="email" name="email" class="form-control ol-form-control" id="email" @isset($instructor->email) value="{{ $instructor->email }}" @endisset required>
    </div>
</div>

<div class="row mb-3">
    <label for="password" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Password') }}</label>
    <div class="col-sm-8">
        <input type="password" name="password" class="form-control ol-form-control" id="password" placeholder="{{ get_phrase('Leave blank to keep current password') }}">
        <small class="form-text text-muted">{{ get_phrase('Leave blank if you do not want to change the password') }}</small>
    </div>
</div>
