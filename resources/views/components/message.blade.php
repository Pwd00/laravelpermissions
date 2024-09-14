@if (session('success'))
    <div class="text-green-800 text-lg rounded-lg p-3 min-w-screen bg-green-300">{{session('success')}}</div>
@endif
@if (session('error'))
    <div class="text-green-800 text-lg rounded-lg bg-red-300 min-w-screen p-3">{{session('error')}}</div>
@endif