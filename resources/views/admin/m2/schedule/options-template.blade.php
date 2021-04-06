<div class="btn-group">
    <button type="button" class="btn btn-sm btn-default border-0 bg-transparent" data-toggle="dropdown"><i class='fa fa-ellipsis-v'></i></button>
    <ul class="dropdown-menu dropdown-menu-right">
        <li>
            <a type='button' class="dropdown-item edit" data-url="{{ route('admin.m2.schedule.edit', [$schedule]) }}">Edit</a>
        </li>
        <li><a class="dropdown-item delete" data-url='{{ route('admin.m2.schedule.destroy', [$schedule]) }}'>Delete</a></li>
    </ul>
</div>
