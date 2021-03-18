@extends('rvsitebuilder/filemanager::admin.layouts.app')

@section('content')
    <div class="uk-alert  uk-alert-warning">
        <p>@lang('rvsitebuilder/filemanager::main.warning_security')</p> 
    </div>
    <div id="fm-frame" style="height: 500px;">
        <div id="fm"></div>
    </div>
@endsection
