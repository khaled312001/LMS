<h4 class="title mt-4 mb-3">{{ get_phrase('Contact Information') }}</h4>
@php
    $contact_info = get_frontend_settings('contact_info');
    if ($contact_info) {
        $decoded = json_decode($contact_info, true);
        if (is_array($decoded)) {
            $contact_info = $decoded;
        } else {
            $contact_info = ['email' => '', 'phone' => '', 'address' => '', 'office_hours' => ''];
        }
    } else {
        $contact_info = ['email' => '', 'phone' => '', 'address' => '', 'office_hours' => ''];
    }
    // Ensure all keys exist
    $contact_info = array_merge(['email' => '', 'phone' => '', 'address' => '', 'office_hours' => '', 'location' => ''], $contact_info);
@endphp

<form action="{{ route('admin.website.settings.update') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="type" value="contact_info">
    <div class="row">
        <div class="col-md-7">
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Contact Email') }}</label>
                <textarea name="email" rows="2" class="form-control ol-form-control">{{ $contact_info['email'] }}</textarea>
            </div>
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Phone Number') }}</label>
                <textarea name="phone" rows="2" class="form-control ol-form-control">{{ $contact_info['phone'] }}</textarea>
            </div>
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Address') }}</label>
                <textarea name="address" rows="2" class="form-control ol-form-control">{{ $contact_info['address'] }}</textarea>
            </div>
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Office Hours') }}</label>
                <textarea name="office_hours" rows="2" class="form-control ol-form-control">{{ $contact_info['office_hours'] }}</textarea>
            </div>
            <div class="fpb-7 mb-3">
                <label class="form-label ol-form-label">{{ get_phrase('Location') }} <small class="text-12px text-muted">({{ get_phrase('Latitude') }}, {{ get_phrase('Longitude') }})</small></label>
                <input name="location" class="form-control ol-form-control" placeholder="40.689880, -74.045203" value="{{ $contact_info['location'] ?? '' }}">
            </div>
            <div class="fpb-7 mb-3">
                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Submit') }}</button>
            </div>
        </div>
    </div>
</form>
