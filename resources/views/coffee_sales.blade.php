<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New ☕️ Sale') }}
        </h2>
    </x-slot>

    <div class="py-12 space-y-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Flash calculated price --}}
        @if (session('calculatedPrice'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                Calculated selling price:
                <strong>@money(session('calculatedPrice'))</strong>
            </div>
        @endif

        {{-- New Sale Form --}}
        @include('assets.new_sale_form')

        {{-- Previous Sales --}}
        @include('assets.previous_sales')
    </div>
</x-app-layout>
