@foreach ($form as $field)
    @if ( $field['type'] === 'fieldset')
        <div class="p-2 mt-2" style="background-color: gray">
            <h5> {{$field['label']}} </h5>
        </div>
    @else
        @if ( $field['type'] === 'select')
            <div class="mb-3">
                <label for="{{ $field['name'] }}" class="form-label"> {{__(ucfirst($field['label']))}}</label>
                <select id="{{ $field['name'] }}" class="form-select" name="{{ $field['name'] }}" required >
                    <option value="">{{ $field['placeholder'] }}</option>
                    @foreach ($field['choices'] as $option)
                    <option value="{{ $option['value'] }}" @if ($option['value'] == $field['value']) selected @endif>
                        {{ $option['label'] }}
                    </option>
                    @endforeach                                            
                </select>
                <small class="text-danger">
                    @foreach ($errors->get($field['name']) as $error)
                        {{$error}}
                    @endforeach
                </small>
            </div>
        @elseif ( $field['type'] === 'file')
            <div class="my-3">
                <input type="{{ $field['type'] }}" id="{{ $field['name'] }}"name="{{ $field['name'] }}" class="form-control" accept="{{ $field['accept'] }}"/>
                <small class="text-danger">
                    @foreach ($errors->get($field['name']) as $error)
                        {{$error}}
                    @endforeach
                </small>
            </div>
        @elseif ( $field['type'] === 'hidden')
            <div class="mb-3">
                <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" value="{{ $field['value'] }}" name="{{ $field['name'] }}" class="form-control" />
            </div>
        @else
            <div class="mb-3">
                <label for="{{ $field['name'] }}" class="form-label"> {{__(ucfirst($field['label']))}}</label>
                <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" value="{{ $field['value'] }}" name="{{ $field['name'] }}" class="form-control" />
                <small class="text-danger">
                    @foreach ($errors->get($field['name']) as $error)
                        {{$error}}
                    @endforeach
                </small>
            </div>
        @endif
    @endif
@endforeach