<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight p-5">
            User/ Create
        </h2>
        <div class="min-w-screen overflow-hidden bg-slate-300 my-2 text-white p-5 rounded-lg shadow-xl">
            <a href="{{route('users.index')}}" class="p-2 bg-black text-white rounded-lg shadow-md float-left">Back</a>
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
                        <form action="{{route('users.store',)}}" method="post">
                            @csrf
                            <div>

                                <label for="name" class="font-bold text-lg mb-3 text-green-400">Name:</label>
                                <div class="my-2">
                                    <input type="text" placeholder="Enter Name" name="name" id="name" class="bg-grey-300 shadow-md w-1/2 rounded-lg text-black" value="{{old('name',)}}">
                                </div>
                                @error('name')
                                <div class="text-sm text-red-600 font-bold">{{$message}}</div>
                                @enderror
                                <label for="email" class="font-bold text-lg mb-3 text-green-400">Email:</label>
                                <div class="my-2">
                                    <input type="email" placeholder="Enter Email" name="email" id="email" class="bg-grey-300 shadow-md w-1/2 rounded-lg text-black" value="{{old('email',)}}">
                                </div>
                                @error('email')
                                <div class="text-sm text-red-600 font-bold">{{$message}}</div>
                                @enderror
                                <label for="password" class="font-bold text-lg mb-3 text-green-400">Password:</label>
                                <div class="my-2">
                                    <input type="password" placeholder="Enter Password" name="password" id="password" class="bg-grey-300 shadow-md w-1/2 rounded-lg text-black" value="{{old('password',)}}">
                                </div>
                                @error('password')
                                <div class="text-sm text-red-600 font-bold">{{$message}}</div>
                                @enderror

                                <label for="cpassword" class="font-bold text-lg mb-3 text-green-400">Confirm Password:</label>
                                <div class="my-2">
                                    <input type="password" placeholder="Confirm Password" name="cpassword" id="cpassword" class="bg-grey-300 shadow-md w-1/2 rounded-lg text-black" value="{{old('password',)}}">
                                </div>
                                @error('cpassword')
                                <div class="text-sm text-red-600 font-bold">{{$message}}</div>
                                @enderror
                                <div class="grid grid-cols-1 md:grid-cols-6 gap-2">
                                    <!-- Checkbox 1 -->

                                    @foreach ($roles as $role)

                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" id="role-{{$role->id}}" class="form-checkbox h-5 w-5 text-blue-600 rounded-md" name="role[]" value="{{old('role',$role->name)}}">
                                        <label for="perm-{{$role->id}}" class="text-lg">{{$role->name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                                <div class="my-2">
                                    <button class="bg-slate-700 px-3 py-2 text-sm text-white hover:bg-green-400 rounded-lg ">create</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
