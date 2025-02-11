@extends('layout.login')
@section('content')

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Pilih Login Sebagai</h2>
        
        <div class="flex flex-col gap-4">
            <a href="{{ route('login', ['role' => 'pengaju']) }}" 
                class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 rounded-lg text-center transition duration-300 ease-in-out shadow-md">
                Login sebagai Pengaju
            </a>
            
            <a href="{{ route('login', ['role' => 'reviewer']) }}" 
                class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 rounded-lg text-center transition duration-300 ease-in-out shadow-md">
                Login sebagai Reviewer
            </a>
        </div>
    </div>
</div>

@endsection
