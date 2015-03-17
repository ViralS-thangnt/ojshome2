
@if(count($errors->get($field)))
<div class="error">
    @foreach($errors->get($field) as $error)
        <div>{!! $error !!}</div>
    @endforeach
</div>
@endif