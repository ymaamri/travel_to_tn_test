@extends('layouts.itineraries')

@push('scripts')
    <script>
        window.authUser = @json(auth()->user());
        window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>
@endpush