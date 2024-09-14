<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Permission/ Create
        </h2>
    </x-slot>
    <div class="min-w-screen overflow-hidden bg-slate-300 my-2 text-white p-5 rounded-lg shadow-xl">
        <a href="{{route('permission.index')}}" class="p-2 bg-black text-white rounded-lg shadow-md float-left">Back</a>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="text-green-900 text-md">{{session('success')}}</div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error )
                        <div class="text-red-600 text-md">{{$error}}</div>
                        @endforeach
                    @endif
                    <form action="{{route('permission.store')}}" method="post">
                        @csrf
                        <div>
                            <label for="name" class="font-bold text-lg mb-3 text-green-400">Permission Name:</label>
                            <div class="my-2">
                                <input type="text"  value="{{old('name')}}" placeholder="Enter Permissions" name="name" id="name" class="bg-grey-300 shadow-md w-1/2 rounded-lg text-black">
                            </div>
                            @error('name')
                                <div class="text-sm text-red-600 font-bold">{{$message}}</div>
                            @enderror
                            <div class="my-2">
                                <button class="bg-slate-700 px-3 py-2 text-sm text-white hover:bg-green-400 rounded-lg ">Submit</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
