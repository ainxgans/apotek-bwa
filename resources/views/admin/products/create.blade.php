<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg">
                @if ($errors->any())
                    <div class="py-3 w-full rounded-3xl bg-red-500" role="alert">
                        @foreach ($errors->all() as $error)
                            <strong class="font-bold">Error!</strong>
                            <span class="block sm:inline">{{ $error }}</span>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Name')"/>
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                      :value="old('name')" required autofocus autocomplete="name"/>
                        <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="price" :value="__('Price')"/>
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price"
                                      :value="old('price')" required autofocus autocomplete="price"/>
                        <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')"/>
                        <select name="category_id" id="category_id"
                                class="py-4 rounded-2xl pl-3 w-full border border-slate-300">
                            <option value="">Choose product category</option>
                            @forelse($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @empty
                                <option value="">No categories available</option>
                            @endforelse
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2"/>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('About')"/>
                        <textarea name="about" id="about" cols="30" rows="5"
                                  class="border border-slate-300 rounded-xl w-full"></textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2"/>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="photo" :value="__('Photo')"/>
                        <x-text-input id="photo" class="block mt-1 w-full" type="file" name="photo" required
                                      autofocus/>
                        <x-input-error :messages="$errors->get('photo')" class="mt-2"/>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Add New Product') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
