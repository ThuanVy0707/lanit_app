<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.msg_edit_user') }} - {{ $user->name }}
            </h2>
            <a href="{{ route('users.show', $user) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('messages.msg_back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_email') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_new_password') }}
                                </label>
                                <input type="password" id="password" name="password"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-500 @enderror">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('messages.msg_leave_blank_to_keep_current') }}</p>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_confirm_new_password') }}
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Roles -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('messages.msg_roles') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                @foreach($roles as $role)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="roles[]" value="{{ $role->name }}"
                                               {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                               class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $role->name }}</span>
                                        @if($role->description)
                                            <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">({{ $role->description }})</span>
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                            @error('roles')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('users.show', $user) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('messages.msg_cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('messages.msg_update_user') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
