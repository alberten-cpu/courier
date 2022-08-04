<x-admin.ui.input label="Street Address"
                  type="text"
                  name="street_address_{{ $inputId }}"
                  id="street_address_{{ $inputId }}"
                  add-class=""
                  placeholder="Street Address"
                  required :value="$editData->$relations->street_address ?? ''"/>
<x-admin.ui.input label="Suburb"
                  type="text"
                  name="suburb_{{ $inputId }}"
                  id="suburb_{{ $inputId }}"
                  add-class=""
                  placeholder="Suburb"
                  required :value="$editData->$relations->suburb ?? ''"/>
<x-admin.ui.input label="City"
                  type="text"
                  name="city_{{ $inputId }}"
                  id="city_{{ $inputId }}"
                  add-class=""
                  placeholder="City"
                  required :value="$editData->$relations->city ?? ''"/>
<x-admin.ui.input label="State/Region"
                  type="text"
                  name="state_{{ $inputId }}"
                  id="state_{{ $inputId }}"
                  add-class=""
                  placeholder="State/Region"
                  required :value="$editData->$relations->state ?? ''"/>
<x-admin.ui.input label="Country"
                  type="text"
                  name="country_{{ $inputId }}"
                  id="country_{{ $inputId }}"
                  add-class=""
                  placeholder="Country"
                  required :value="$editData->$relations->country ?? ''"/>
<x-admin.ui.input label="Post Code"
                  type="text"
                  name="zip_{{ $inputId }}"
                  id="zip_{{ $inputId }}"
                  add-class=""
                  placeholder="Post Code"
                  required :value="$editData->$relations->zip ?? ''"/>
<input type="hidden" name="place_id_{{ $inputId }}" id="place_id_{{ $inputId }}" required
       value="{{ old('latitude_'.$inputId,$editData->$relations->place_id ?? '') }}">
<input type="hidden" name="latitude_{{ $inputId }}" id="latitude_{{ $inputId }}" required
       value="{{ old('latitude_'.$inputId,$editData->$relations->latitude ?? '') }}">
<input type="hidden" name="longitude_{{ $inputId }}" id="longitude_{{ $inputId }}" required
       value="{{ old('longitude_'.$inputId,$editData->$relations->longitude ?? '') }}">
<input type="hidden" name="location_url_{{ $inputId }}" id="location_url_{{ $inputId }}" required
       value="{{ old('location_url_'.$inputId,$editData->$relations->location_url ?? '') }}">
<input type="hidden" name="json_response_{{ $inputId }}" id="json_response_{{ $inputId }}" required
       value="{{ old('json_response_'.$inputId,$editData->$relations->full_json_response ?? '') }}">
@push('scripts')
    @once
        <!-- Google Maps JavaScript library -->
        <script
            src="https://maps.googleapis.com/maps/api/js?{!! config('services.google_api.params') !!}&key={!! config('services.google_api.key') !!}"></script>
    @endonce
    <script>
        $(document).ready(function () {
            var autocomplete_{{ $inputId }};
            autocomplete_{{ $inputId }} = new google.maps.places.Autocomplete((document.getElementById('street_address_{{ $inputId }}')), {
                types: ['address'],
                componentRestrictions: {
                    country: {!! config('services.google_api.countries') !!}
                }
            });
            google.maps.event.addListener(autocomplete_{{ $inputId }}, 'place_changed', function () {
                var near_place = autocomplete_{{ $inputId }}.getPlace();
                $('#street_address_{{ $inputId }}').val('').change();
                $('#suburb_{{ $inputId }}').val('').change();
                $('#city_{{ $inputId }}').val('').change();
                $('#state_{{ $inputId }}').val('').change();
                $('#country_{{ $inputId }}').val('').change();
                $('#zip_{{ $inputId }}').val('').change();
                $('#place_id_{{ $inputId }}').val('').change();
                $('#latitude_{{ $inputId }}').val('').change();
                $('#longitude_{{ $inputId }}').val('').change();
                $('#location_url_{{ $inputId }}').val('').change();
                $('#json_response_{{ $inputId }}').val('').change();
                $.each(near_place.address_components, function (index, address_component) {
                    console.log(address_component);
                    if (address_component.types[0] == "route") {
                        $('#street_address_{{ $inputId }}').val(address_component.long_name).change();
                    }
                    if (address_component.types[0] == "administrative_area_level_3" || address_component.types[0] == "neighborhood" || address_component.types[0] == "sublocality_level_1" || address_component.types[0] == "sublocality_level_2" || address_component.types[0] == "locality") {
                        $('#suburb_{{ $inputId }}').val(address_component.long_name).change();
                    }
                    if (address_component.types[0] == "administrative_area_level_2") {
                        $('#city_{{ $inputId }}').val(address_component.long_name).change();
                    }
                    if (address_component.types[0] == "administrative_area_level_1") {
                        $('#state_{{ $inputId }}').val(address_component.long_name).change();
                    }
                    if (address_component.types[0] == "country") {
                        $('#country_{{ $inputId }}').val(address_component.long_name).change();
                    }
                    if (address_component.types[0] == "postal_code") {
                        $('#zip_{{ $inputId }}').val(address_component.long_name).change();
                    }
                });
                $('#place_id_{{ $inputId }}').val(near_place.place_id).change();
                $('#latitude_{{ $inputId }}').val(near_place.geometry.location.lat()).change();
                $('#longitude_{{ $inputId }}').val(near_place.geometry.location.lng()).change();
                $('#location_url_{{ $inputId }}').val(near_place.url).change();
                $('#json_response_{{ $inputId }}').val(JSON.stringify(near_place)).change();
            })
        });
    </script>
@endpush
