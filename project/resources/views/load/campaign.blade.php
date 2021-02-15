@if(Auth::guard('admin')->check())
@foreach($data as $d)
    <option value="{{ $d->id }}">{{ $d->name }}</option>
@endforeach
@endif