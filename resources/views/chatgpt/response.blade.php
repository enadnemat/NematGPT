@extends('dashboard')

@section('response')
    <label for="input" class="mx-auto-2 py-2 ">NematGPT Response</label>
    <div class="my-2 py-2 h-9 sm:container sm:h-full whitespace-pre-wrap">
        {{$data}}
    </div>
@endsection
