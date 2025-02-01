@foreach ($item->values as $value)
    <option value="{{ $value->id }}">{{ $value->variable }}</option>
@endforeach
