@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-8">
            <h1>@lang('audit-viewer::audit.audits')</h1>
            
        </div>
        <div class="col-4">
        <form action="{{route('audit-viewer.audit.index')}}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="@lang('audit-viewer::audit.search')" value="{{request()->search}}">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">@lang('audit-viewer::audit.search')</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            
            @include('audit-viewer::messages')
        
            @if($audits->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">        
                        <table class="table table-striped table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">@lang('audit-viewer::audit.event')</th>
                                    <th scope="col">@lang('audit-viewer::audit.model')</th>
                                    <th scope="col">@lang('audit-viewer::audit.model_id')</th>
                                    <th scope="col">@lang('audit-viewer::audit.affected_fields')</th>
                                    <th scope="col">@lang('audit-viewer::audit.author')</th>
                                    <th scope="col">@lang('audit-viewer::audit.created_at')</th>
                                    <th scope="col">@lang('audit-viewer::audit.actions')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($audits as $audit)
                                <tr>
                                    <td>{{$audit->id}}</td>
                                    <td><x-audit-viewer-badge :event="$audit->event" /></td>
                                    <td>
                                        <a href="{{route('audit-viewer.audit.model', [$audit->auditable_type])}}" class="d-inline text-decoration-none">
                                            {{$audit->auditable_type}}
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('audit-viewer.audit.model', [$audit->auditable_type, $audit->auditable_id])}}" class="d-inline text-decoration-none">
                                            {{$audit->auditable_id}}
                                        </a>
                                    </td>
                                    <td>{{count($audit->new_values)}}</td>
                                    <td><x-audit-viewer-author :user="$audit->user" :size="24" /></td>
                                    <td>{{$audit->created_at->format('Y-m-d H:i:s')}}</td>

                                    <td>
                                        <a href="{{route('audit-viewer.audit.show', $audit->id)}}" class="d-inline text-decoration-none" title="@lang('audit-viewer::audit.view')">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" style="height: 20px; fill:#dc3545;"><!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM432 256c0 79.5-64.5 144-144 144s-144-64.5-144-144s64.5-144 144-144s144 64.5 144 144zM288 192c0 35.3-28.7 64-64 64c-11.5 0-22.3-3-31.6-8.4c-.2 2.8-.4 5.5-.4 8.4c0 53 43 96 96 96s96-43 96-96s-43-96-96-96c-2.8 0-5.6 .1-8.4 .4c5.3 9.3 8.4 20.1 8.4 31.6z"/></svg>
                                        </a>
                                        @if($audit->event == 'updated')
                                        <form class="d-inline" action="{{route('audit-viewer.audit.rollback', ['id' => $audit->id])}}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-link p-0" title="@lang('audit-viewer::audit.rollback_to_point')">
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
            @else
                <div class="alert alert-info">
                    @lang('audit-viewer::audit.no_audits_desc')
                </div>
            @endif
        </div>
        {{ $audits->links()}}
    </div>
</div>
@endsection