@extends('layouts.app')

@section('content')
    <div class="flex flex-col w-4/6 py-12 max-w-7xl mx-auto max-h-full sm:max-h-full sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg overflow-auto max-h-full sm:max-h-full">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form action="{{route('chatgpt.ask')}}" method="post">
                    @csrf
                    <label for="input" class="font-semibold">Ask me something: </label>
                    <input type="text" name="prompt"
                           class="mt-1 px-3 py-2 bg-white border shadow-sm border-slate-300 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-sky-500 block w-full rounded-md sm:text-sm focus:ring-1">

                    <button type="submit"
                            class="justify-items-center text-center h-10 px-6 my-2 mx-auto font-semibold rounded-md bg-blue-700 text-white hover:bg-blue-600">
                        Send
                    </button>
                </form>

            </div>

            <div class="p-6 text-gray-900 dark:text-gray-100">
                @yield('response')
            </div>

        </div>
    </div>

@endsection
