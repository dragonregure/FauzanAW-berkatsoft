@php
$data = $config['data'];
@endphp

<table class="table table-striped">
    <tbody>
    @foreach($data as $key => $val)
        <tr>
            <th>{{ucfirst($val)}}</th>
            <td>:</td>
            <td id="show{{ucfirst($key)}}"></td>
        </tr>
    @endforeach
    </tbody>
</table>
