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
