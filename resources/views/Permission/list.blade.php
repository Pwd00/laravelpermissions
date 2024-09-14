<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permissions') }}
        </h2>
    </x-slot>
    <div class="min-w-screen overflow-hidden bg-slate-300 my-2 text-white p-5 rounded-lg shadow-xl">
        <a href="{{route('permission.create')}}" class="p-2 bg-red-300 rounded-lg shadow-md float-right hover:bg-black text-amber-300">Create New Permission</a>
    </div>
    
<x-message></x-message>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                   <table class="w-full  divide-rose-300">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                               Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach ($permissions  as $index => $permission )
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{$index + 1}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{$permission->name}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            <a href="{{route('permission.edit',[$permission->id])}}" class="p-2 bg-green-600 text-white rounded-lg"> Edit</a>
                            <form action="{{ route('permission.destory', $permission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this permission?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-600 text-white rounded-lg">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
                   </table>
                   <div class="mt-4">
                    {{ $permissions->links() }}
                </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
