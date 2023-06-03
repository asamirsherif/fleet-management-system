@component($typeForm, get_defined_vars())
    <div data-controller="map"
         data-map-id="{{$id}}"
         data-map-zoom="{{$zoom}}"
    >
        <div id="{{$id}}" class="osmap-map border mb-2 w-100" style="min-height: {{ $attributes['height'] }}"></div>
        <div class="row mt-3">
            <div class="col-md-10">
                <label>{{ __('Address') }}</label>
                <input class="form-control" type="text"
                       value="{{$valuename ?? 'Cairo, Egypt'}}"
                       name="{{$name}}[address]"
                       data-map-target="search"
                       data-action="keyup->map#search"/>
            </div>
            <div class="col-md-2 mt-4">
                <button type="button" class="btn btn-default" data-map-target="search" data-action="map#search">{{__('Search')}}</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md">
                <label for="{{$name}}[latitude]">{{ __('Latitude') }}</label>
                <input class="form-control"
                       id="marker__latitude"
                       data-map-target="lat"
                       @if($required ?? false) required @endif
                       name="{{$name}}[latitude]"
                       value="{{ $value['latitude'] ?? '30.0443879' }}"/>
            </div>
            <div class="col-md">
                <label for="{{$name}}[longitude]">{{ __('Longitude') }}</label>
                <input class="form-control"
                       id="marker__longitude"
                       data-map-target="lng"
                       @if($required ?? false) required @endif
                       name="{{$name}}[longitude]"
                       value="{{ $value['longitude'] ?? '31.2357257' }}"/>
            </div>
        </div>

        <div class="marker-results"></div>

    </div>


@endcomponent
