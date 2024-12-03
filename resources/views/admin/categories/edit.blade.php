<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Category') }}
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
                <form method="POST" action="{{ route('admin.categories.update', $category) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" value="{{ $category->name }}" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="icon" :value="__('Icon')" />
                        <img src="{{ Storage::url($category->icon) }}" alt="" class="w-[50px] h-[50px]">
                        <x-text-input id="icon" class="block mt-1 w-full" type="file" name="icon"
                            autofocus />
                        <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ms-4">
                            {{ __('Update Category') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
