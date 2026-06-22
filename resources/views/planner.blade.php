@extends('layouts.react')

@section('content')
    <div id="app"></div>
@endsection

@push('scripts')
    <script>
        window.authUser = @json(auth()->check() ? auth()->user() : null);
    </script>
@endpush