<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Articles/ Edit
        </h2>
    </x-slot>

    <div class="min-w-screen overflow-hidden bg-slate-300 my-2 text-white p-5 rounded-lg shadow-xl">
        <a href="{{route('articles.index')}}" class="p-2 bg-black text-white rounded-lg shadow-md float-left">Back</a>
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
                    <form action="{{route('articles.update',[$article->id])}}" method="post">
                        @method('PUT')
                        @csrf

                        <div>
                            <label for="title" class="font-bold text-lg mb-3 text-green-400">Enter Title of the Article:</label>
                            <div class="my-2">
                                <input type="text" placeholder="Enter Title" name="title" id="title" class="bg-grey-300 shadow-md w-1/2 rounded-lg text-black" value="{{old('title',$article->title)}}">
                                @error('title')
                                <div class="bg-red-400 text-white p-2  w-1/2  text-uppercase rounded-lg shadow-sm">{{$message}}</div>
                                @enderror
                            </div>
                            <label for="desc" class="font-bold text-lg mb-3 text-green-400">Enter Description:</label>
                            <div class="my-2">
                                <textarea name="text" id="text" class="bg-grey-300 shadow-md w-1/2 rounded-lg text-black placeholder:text-rose-300" placeholder="Enter Description">{{old('text',$article->text)}}</textarea>
                                @error('text')
                                <div class="bg-red-400 p-2 text-white rounded-lg shadow w-1/2">{{$message}}</div>
                                @enderror
                            </div>
                            <label for="author" class="font-bold text-lg mb-3 text-green-400">Enter Author Name:</label>
                            <div class="my-2">
                                <input type="text" name="author" id="author" class="bg-grey-300 shadow-md rounded-lg text-black w-1/2" placeholder="Enter Author name " value="{{old('author',$article->author)}}">
                            </div>
                            @error('author')
                            <div class="text-sm bg-red-400 text-white font-bold w-1/2 p-2 rounded-lg shadow-md">{{$message}}</div>
                            @enderror
                            <div class="my-2">
                                <button class="bg-slate-700 px-3 py-2 text-sm text-white hover:bg-green-400 rounded-lg ">update</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>