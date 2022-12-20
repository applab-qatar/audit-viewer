<a class="d-flex align-items-center text-decoration-none" href="javascript:void(0);" title="@lang('audit-viewer::audit.performed_by', ['user' => $user->name ?? 'System'])">
    <div class="avatar avatar-l">
        <img src="{{$avatar}}" class="avatar-name rounded-circle" style="height: {{$size}}px;"/>
    </div>
    <h6 class="mb-0 ms-3 text-900">{{$user->name ?? 'System'}}</h6>
</a>