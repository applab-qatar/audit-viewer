@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h1>@lang('audit-viewer::audit.audits')</h1>
            @include('audit-viewer::messages')
        </div>
            @foreach($audits as $audit)
        <div class="col-3">
            <div class="card mb-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light">
                        <x-audit-viewer-author :user="$audit->user" :size="40" />
                        @if($audit->event == 'updated')
                        <form action="{{route('audit-viewer.audit.rollback', ['id' => $audit->id])}}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link p-0" title="@lang('audit-viewer::audit.rollback_to_point')">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height: 20px; fill:#dc3545;"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M48.5 224H40c-13.3 0-24-10.7-24-24V72c0-9.7 5.8-18.5 14.8-22.2s19.3-1.7 26.2 5.2L98.6 96.6c87.6-86.5 228.7-86.2 315.8 1c87.5 87.5 87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3c-62.2-62.2-162.7-62.5-225.3-1L185 183c6.9 6.9 8.9 17.2 5.2 26.2s-12.5 14.8-22.2 14.8H48.5z"/></svg>
                            </button>
                        </form>
                        @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong class="me-2">@lang('audit-viewer::audit.event'):</strong> <x-audit-viewer-badge :event="$audit->event" />
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong class="me-2">@lang('audit-viewer::audit.created_at'):</strong> <span class="text-end">{{ Carbon\Carbon::parse($audit->getMetadata()['audit_created_at'])->format('Y-m-d H:i:s') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong class="me-2">@lang('audit-viewer::audit.ip_address'):</strong> <span class="text-end">{{$audit->getMetadata()['audit_ip_address']}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <strong class="me-2">@lang('audit-viewer::audit.url'):</strong> <a class="text-end text-truncate" title="{{$audit->getMetadata()['audit_url']}}" href="{{$audit->getMetadata()['audit_url']}}" target="_blank">{{$audit->getMetadata()['audit_url']}}</a>
                    </li>
                    
                </ul>

            </div>
        </div>
        <div class="col-9">
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th scope="col" style="width: 20%;">@lang('audit-viewer::audit.field')</th>
                                <th scope="col" style="width: 35%;">@lang('audit-viewer::audit.old_value')</th>
                                <th scope="col" style="width: 35%;">@lang('audit-viewer::audit.new_value')</th>
                                <th scope="col" style="width: 10%;">@lang('audit-viewer::audit.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($audit->getModified() as $key => $value)
                            <tr>
                                <th>{{$key}}</th>
                                <td>{{$value['old'] ?? ''}}</td>
                                <td>{{$value['new'] ?? ''}}</td>
                                <td>
                                    @if($audit->event == 'updated')
                                    <form action="{{route('audit-viewer.audit.rollback', ['id' => $audit->id, 'field' => $key])}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0" title="@lang('audit-viewer::audit.rollback_this_field')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="height: 20px; fill:#dc3545;"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M48.5 224H40c-13.3 0-24-10.7-24-24V72c0-9.7 5.8-18.5 14.8-22.2s19.3-1.7 26.2 5.2L98.6 96.6c87.6-86.5 228.7-86.2 315.8 1c87.5 87.5 87.5 229.3 0 316.8s-229.3 87.5-316.8 0c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0c62.5 62.5 163.8 62.5 226.3 0s62.5-163.8 0-226.3c-62.2-62.2-162.7-62.5-225.3-1L185 183c6.9 6.9 8.9 17.2 5.2 26.2s-12.5 14.8-22.2 14.8H48.5z"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
            @endforeach
        </div>
    </div>
</div>
@endsection