@extends('layouts.master')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex gap-6">

            <aside class="w-72 shrink-0">
                @include('listings.partials.filters')
            </aside>

            <section class="flex-1">
                @include('listings.partials.grid')
            </section>

        </div>
    </div>
@endsection
