<table class="table table-sm table-borderless m-0">
    <tbody>
    <tr>
        <td rowspan="4" class="p-0" ><img src="{{ $class->image_url }}" onerror="this.onerror=null; this.src='{{ asset('themes/AdminLTE/dist/img/default-1000x1000.png') }}';" alt="" class="img-rounded" width="60" height="auto"></td>
    </tr>
    <tr>
        <td width="25%" class="pl-3" style="padding: .3rem;">Name: {{ $class->name }}</td>
        <td width="25%">No. of Seats: {{ $class->num_seats }}</td>
        <td width="25%">Duration: {{ $class->duration }}</td>
        <td width="25%">Duration Label: {{ $class->duration_label }}</td>
    </tr>
    <tr>
        <td class="pl-3" style="padding: .3rem;">Seat Price: {{ $class->seat_price }}</td>
        <td>Floor Price: {{ $class->floor_price }}</td>
        <td>
            App Visibility:
            @if ($class->app_visibility == 1)
                <span class="badge badge-primary">Show</span>
            @else
                <span class="badge badge-danger">Hide</span>
            @endif
        </td>
        <td>
            Status:
            @if ($class->status == 1)
                <span class="badge badge-primary">Active</span>
            @else
                <span class="badge badge-danger">Inactive</span>
            @endif
        </td>
    </tr>
    </tbody>
</table>
