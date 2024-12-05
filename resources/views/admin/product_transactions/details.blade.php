<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row w-full justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ Auth::user()->hasRole('owner') ? __('Apotek Orders') : __('My Transaction') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white flex flex-col gap-y-5 overflow-hidden p-10 shadow-sm sm:rounded-lg">
                <div class="item-card flex flex-row justify-between items-center">
                    <div class="flex flex-row items-center gap-x-3">
                        <div>
                            <p class="text-base text-slate-500">
                                Total transaksi
                            </p>
                            <h3 class="text-2xl font-bold text-indigo-950">
                                Rp {{$productTransaction->total_amount}}
                            </h3>

                        </div>
                    </div>
                    <div>
                        <p class="text-base text-slate-500">
                            Date
                        </p>
                        <p class="text-xl font-bold text-indigo-950">{{$productTransaction->created_at}}</p>
                    </div>
                    @if($productTransaction->is_paid)
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
                </div>
                <hr class="my-3">
                <h3 class="text-xl font-bold text-indigo-950">
                    List of items
                </h3>

                <div class="grid-cols-4 grid gap-x-10">
                    <div class="flex flex-col gap-y-5 col-span-2">
                        {{--                        List item--}}
                        @forelse($productTransaction->transactionDetails as $detail)
                            <div class="item-card flex flex-row justify-between items-center">
                                <div class="flex flex-row items-center gap-x-3">
                                    <img src="{{ Storage::url($detail->product->photo) }}" alt=""
                                         class="w-[50px] h-[50px]">
                                    <div>
                                        <h3 class="text-2xl font-bold text-indigo-950">
                                            {{$detail->product->name}}
                                        </h3>
                                        <p class="text-base text-slate-500">
                                            Rp {{$detail->product->price}}

                                        </p>
                                    </div>
                                </div>
                                <p class="text-base text-slate-500">
                                    {{$detail->product->category->name}}
                                </p>
                            </div>
                        @empty
                            <p class="text-center">
                                Data produk gagal dimuat, hubungi admin
                            </p>
                        @endforelse

                        {{--                        DETAIL OF PAYMENT--}}

                        <h3 class="text-xl font-bold text-indigo-950">
                            Detail of payment
                        </h3>
                        <div class="item-card flex flex-row justify-between items-center">
                            <p class="text-base text-slate-500">
                                Address
                            </p>
                            <h3 class="text-xl font-bold text-indigo-950">
                                {{$productTransaction->address}}
                            </h3>
                        </div>
                        <div class="item-card flex flex-row justify-between items-center">
                            <p class="text-base text-slate-500">
                                City
                            </p>
                            <h3 class="text-xl font-bold text-indigo-950">
                                {{$productTransaction->city}}
                            </h3>
                        </div>
                        <div class="item-card flex flex-row justify-between items-center">
                            <p class="text-base text-slate-500">
                                Postal Code
                            </p>
                            <h3 class="text-xl font-bold text-indigo-950">
                                {{$productTransaction->post_code}}
                            </h3>
                        </div>
                        <div class="item-card flex flex-row justify-between items-center">
                            <p class="text-base text-slate-500">
                                Phone number
                            </p>
                            <h3 class="text-xl font-bold text-indigo-950">
                                {{$productTransaction->phone_number}}
                            </h3>
                        </div>
                        <div class="item-card flex flex-col items-start">
                            <p class="text-base text-slate-500">
                                Notes
                            </p>
                            <h3 class="text-lg font-bold text-indigo-950">
                                {{$productTransaction->notes}}
                            </h3>
                        </div>
                    </div>
                    <div class="flex flex-col gap-y-5 col-span-2 items-end">
                        <h3 class="text-xl font-bold text-indigo-950">
                            Proof of payment:
                        </h3>
                        <img src="{{ Storage::url($productTransaction->proof) }}" alt=""
                             class="w-[300px] h-[400px] bg-red-300">
                    </div>
                </div>
                <hr class="my-3">
                @role('owner')
                <form method="post" action="{{ route('product_transactions.update',$productTransaction) }}">
                    @csrf
                    @method('put')
                    @if($productTransaction->is_paid)
                        <button class="py-3 px-5 rounded-full text-white bg-orange-600">Undo Approve</button>
                    @else
                        <button class="py-3 px-5 rounded-full text-white bg-blue-600"> Approve Order</button>
                    @endif
                </form>
                @endrole
                @role('buyer')
                <a class="w-fit cursor-pointer py-3 px-5 rounded-full text-white bg-teal-600">Contact Admin</a>
                @endrole
            </div>
        </div>
    </div>
</x-app-layout>
