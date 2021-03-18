@extends('admin.layouts.master')

@section('leftmenu')
	@include('admin.includes.leftmenu', ['package_name' => "rvsitebuilder/filemanager"])
@endsection


@push('package-styles')
    <!-- package-styles -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    {{ style(@mixcdn('css/uikitv2.css', 'vendor/rvsitebuilder/wysiwyg')) }}
    {{ style(mix('css/bootstrap.css', 'vendor/rvsitebuilder/core')) }}

    
@endpush

@push('package-scripts')
    <script>
        var select_disk = '{{ $disk }}';
        var select_path = '{{ $path }}';
    </script>
    {{ script(mix('app.js', 'vendor/rvsitebuilder/filemanager')) }}
    
    <!-- package-scripts -->
   
@endpush

@push('package-styles')
    <style>
        .fm-table thead th{
            z-index:9 !important;
        }
    </style>
@endpush