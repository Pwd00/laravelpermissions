<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles') }}
        </h2>
    </x-slot>
    @can('create role')
    <div class="min-w-screen overflow-hidden bg-slate-300 my-2 text-white p-5 rounded-lg shadow-xl">
        <a href="{{route('roles.create')}}" class="p-2 bg-red-300 rounded-lg shadow-md float-right hover:bg-black text-amber-300">Create New Role</a>
    </div>
    @endcan


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
                                    Permissions
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    created_at
                                </th>

                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                            @foreach ($roles as $index => $role )
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{$index + 1}}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{$role->name}}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 break-words whitespace-normal max-w-xs">
                                    {{$role->permissions->pluck("name")->implode(', ')}}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{\carbon\Carbon::parse($role->created_at)->format('d M Y')}}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 d-flex  ">
                                    @can('edit role')
                                    <a href="{{route('roles.edit',[$role->id])}}" class="p-2 bg-green-600 text-white rounded-lg"> Edit</a>
                                    @endcan
                                    @can('delete role')
                                    <form action="{{route('roles.destroy',[$role->id])}}" method="post" class="inline" onsubmit="confirm('Are You Sure You want To Delete This Role')">
                                        @method('DELETE')
                                        @csrf
                                        <button class="bg-red-400 text-white mt-3 p-2 hover:bg-red-600 rounded-lg shadow-lg">Delete</button>
                                    </form>
                                    @endcan

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>