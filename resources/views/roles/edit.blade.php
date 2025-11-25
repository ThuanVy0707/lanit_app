<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.msg_edit_role') }} - {{ $role->name }}
            </h2>
            <a href="{{ route('roles.show', $role) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                {{ __('messages.msg_back') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('roles.update', $role) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_name') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $role->name) }}" required
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    {{ __('messages.msg_description') }}
                                </label>
                                <input type="text" id="description" name="description" value="{{ old('description', $role->description) }}"
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror">
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div class="mb-4" x-data="permissionsManager()">
                            <div class="flex justify-between items-center mb-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('messages.msg_permissions') }}
                                </label>
                                <button type="button" @click="checkAll()" class="inline-flex items-center px-3 py-1 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                    {{ __('messages.msg_check_all') }}
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-96 overflow-y-auto border border-gray-300 dark:border-gray-700 rounded-md p-4">
                                @foreach($permissions->groupBy(function($permission) {
                                    return explode('.', $permission->name)[0];
                                }) as $group => $groupPermissions)
                                    <div>
                                        <div class="flex justify-between items-center mb-2">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100 capitalize">{{ $group }}</h4>
                                            <button type="button" @click="checkGroup('{{ $group }}')" class="inline-flex items-center px-2 py-1 bg-gray-500 border border-transparent rounded text-xs text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                                {{ __('messages.msg_check_all') }}
                                            </button>
                                        </div>
                                        @foreach($groupPermissions as $permission)
                                            <label class="inline-flex items-center w-full mb-1">
                                                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                                       {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}
                                                       x-model="selectedPermissions"
                                                       class="rounded border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 permission-checkbox"
                                                       data-group="{{ $group }}">
                                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            @error('permissions')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror

                            <script>
                                function permissionsManager() {
                                    return {
                                        selectedPermissions: @json(old('permissions', $role->permissions->pluck('id')->toArray())),

                                        checkAll() {
                                            const allCheckboxes = document.querySelectorAll('.permission-checkbox');
                                            const isAllChecked = Array.from(allCheckboxes).every(cb => cb.checked);

                                            allCheckboxes.forEach(checkbox => {
                                                checkbox.checked = !isAllChecked;
                                                const value = parseInt(checkbox.value);
                                                if (checkbox.checked && !this.selectedPermissions.includes(value)) {
                                                    this.selectedPermissions.push(value);
                                                } else if (!checkbox.checked) {
                                                    this.selectedPermissions = this.selectedPermissions.filter(id => id !== value);
                                                }
                                            });
                                        },

                                        checkGroup(groupName) {
                                            const groupCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group="${groupName}"]`);
                                            const isGroupChecked = Array.from(groupCheckboxes).every(cb => cb.checked);

                                            groupCheckboxes.forEach(checkbox => {
                                                checkbox.checked = !isGroupChecked;
                                                const value = parseInt(checkbox.value);
                                                if (checkbox.checked && !this.selectedPermissions.includes(value)) {
                                                    this.selectedPermissions.push(value);
                                                } else if (!checkbox.checked) {
                                                    this.selectedPermissions = this.selectedPermissions.filter(id => id !== value);
                                                }
                                            });
                                        }
                                    }
                                }
                            </script>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('roles.show', $role) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('messages.msg_cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('messages.msg_update_role') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
