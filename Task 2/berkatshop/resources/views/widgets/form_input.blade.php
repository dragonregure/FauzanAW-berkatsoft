@php
$type = $config['type'];
$label = $config['label'];
$id = $config['id'];
$name = $config['name'];
$readonly = '';
if ($config['readonly'] == true) $readonly = 'readonly';
@endphp

<div class="form-group">
    <label for="{{$id}}">{{$label}}</label>
    <input type="{{$type}}" class="form-control" id="{{$id}}" name="{{$name}}" {{$readonly}}>
    <span class="text-danger">
        <small id="{{$id}}-error"></small>
    </span>
</div>
