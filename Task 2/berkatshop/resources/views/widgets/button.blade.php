@php
$type=$config['type'];
$buttontype='button';
$size='btn-sm';
$theme='';
$class='';
$datatoggle='';
$datatarget='';
$datadismiss='';
$icon='';
$iconclass='';
$text='';
$id='';
$name='';
$value='';
switch ($type){
    case 'add':
        $theme='btn-success';
        $icon='fa-plus';
        $text='Add';
        break;

    case 'save':
        $buttontype='submit';
        $theme='btn-primary';
        $text='Save';
        break;

    case 'reset':
        $buttontype='reset';
        $theme='btn-warning';
        $text='Reset';
        break;

    case 'close':
        $icon='fa-times';
        $iconclass='fa-sm';
        break;

    default:
        $theme='btn-primary';
        $text='New Button';
}

if ($config['buttontype'] != null) $buttontype = $config['buttontype'];
if ($config['size'] != null) $size = $config['size'];
if ($config['theme'] != null) $theme = $config['theme'];
if ($config['class'] != null) $class = $config['class'];
if ($config['data-toggle'] != null) $datatoggle = $config['data-toggle'];
if ($config['data-target'] != null) $datatarget = $config['data-target'];
if ($config['data-dismiss'] != null) $datadismiss = $config['data-dismiss'];
if ($config['icon'] != null) $icon = $config['icon'];
if ($config['iconclass'] != null) $iconclass = $config['iconclass'];
if ($config['text'] != null) $text = $config['text'];
if ($config['id'] != null) $id = $config['id'];
if ($config['name'] != null) $name = $config['name'];
if ($config['value'] != null) $value = $config['value'];
@endphp
<button id="{{$id}}" name="{{$name}}" type="{{$buttontype}}" class="btn {{$size}} {{$theme}} {{$class}}" data-toggle="{{$datatoggle}}" data-target="{{$datatarget}}" data-dismiss="{{$datadismiss}}" value="{{$value}}"><i class="fas {{$icon}} {{$iconclass}}"></i> {{$text}}</button>
