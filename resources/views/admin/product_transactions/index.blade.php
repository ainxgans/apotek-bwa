<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row w-full justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->hasRole('owner') ? __('Apotek Orders') : __('My Transaction') }}
            </h2>
            <a href="{{ route('admin.products.create') }}"
               class="font-bold py-3 px-5 rounded-full text-white bg-indigo-700">
                Add Product
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white flex flex-col gap-y-5 overflow-hidden p-10 shadow-sm sm:rounded-lg">
                @forelse($product_transactions as $transaction)
                    <div class="item-card flex flex-row justify-between items-center">
                        <div class="flex flex-row items-center gap-x-3">
                            <div>
                                <p class="text-base text-slate-500">
                                    Total transaksi
                                </p>
                                <h3 class="text-2xl font-bold text-indigo-950">
                                    RP 27189261
                                </h3>
                            </div>
                        </div>
                        <div>
                            <p class="text-base">
                                Date
                            </p>
                            <h3 class="text-2xl font-bold text-indigo-950">
                                25 January 2024
                            </h3>
                        </div>
                        @if($transaction->is_paid)
                            <span class="py-1 px-3 rounded-full bg-green-500">
                                <p class="text-white font-bold text-sm">
                                    SUCCESS
                                </p>
                        </span>
                        @else
                            <span class="py-1 px-3 rounded-full bg-orange-500">
                                <p class="text-white font-bold text-sm">
                                    PENDING
                                </p>
                        </span>
                        @endif
                        <div class="flex flex-row items-center gap-x-3">
                            <a href="{{route('product_transactions.show', $transaction)}}"
                               class="font-bold py-3 px-5 rounded-full text-white bg-indigo-700">View
                                Details</a>
                        </div>
                    </div>
                @empty
                    <p class="text-center">
                        Belum tersedia transaksi terbaru
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
