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
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <form action="{{ route('sales.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                @csrf

                {{-- Quantity --}}
                <div>
                    <x-label for="quantity" :value="__('Quantity')" />
                    <x-input
                        id="quantity"
                        name="quantity"
                        type="number"
                        min="1"
                        value="{{ old('quantity') }}"
                        required
                        class="mt-1 block w-full"
                    />
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Unit Cost --}}
                <div>
                    <x-label for="unit_cost" :value="__('Unit Cost (£)')" />
                    <x-input
                        id="unit_cost"
                        name="unit_cost"
                        type="number"
                        step="0.01"
                        value="{{ old('unit_cost') }}"
                        required
                        class="mt-1 block w-full"
                    />
                    @error('unit_cost')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Selling Price (read-only) --}}
                <div>
                    <x-label for="selling_price" :value="__('Selling Price')" />

                    <x-input
                        id="selling_price"
                        name="selling_price"
                        type="text"
                        value="{{ old('selling_price',
                            session('calculatedPrice')
                                ? '£' . number_format(session('calculatedPrice'), 2)
                                : ''
                        ) }}"
                        readonly
                        class="mt-1 block w-full bg-gray-50 text-center"
                    />
                </div>


                {{-- Submit --}}
                <div class="justify-self-end">
                    <x-button type="submit">
                        {{ __('Record Sale') }}
                    </x-button>
                </div>
            </form>
        </div>

        {{-- Previous Sales --}}
        <div class="bg-white shadow-sm sm:rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">{{ __('Previous Sales') }}</h3>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach (['Quantity', 'Unit Cost', 'Selling Price', 'Created At'] as $col)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __($col) }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($sales as $sale)
                            <tr>
                                <td class="px-6 py-4">{{ $sale->quantity }}</td>
                                <td class="px-6 py-4">@money($sale->unit_cost)</td>
                                <td class="px-6 py-4">@money($sale->selling_price)</td>
                                <td class="px-6 py-4">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    {{ __('No sales recorded yet.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
