@extends('layout.login')
@section('content')

<main class="flex items-center justify-center h-screen bg-gray-100">
    <section class="relative flex flex-col lg:flex-row w-full max-w-4xl h-auto lg:h-[30rem] rounded-3xl overflow-hidden shadow-lg">
        <!-- First Column (App Name + Background Image + Overlay) -->
        <div class="relative lg:w-1/2 w-full h-64 lg:h-full bg-cover bg-center flex items-start justify-center" style="background-image: url('{{ asset('assets/img/polban.jpg') }}');">
            <div class="absolute inset-0 bg-black opacity-30"></div>
            <div class="relative z-10 p-8">
                <h1 class="text-3xl font-bold text-white">
                    Sistem Informasi Kemahasiswaan Polban
                </h1>
            </div>
        </div>        

        <!-- Second Column (Login, Forgot Password, and Reset Password Forms) -->
        <div class="w-full lg:w-1/2 flex flex-col p-10 bg-white relative">
            <!-- Login Form -->
            <div id="loginForm" class="absolute inset-0 transition-transform duration-700 ease-in-out flex flex-col justify-between p-10 bg-white">
                <div class="title mb-6">
                    <h1 class="text-2xl font-bold">Login</h1>
                </div>
                <form method="POST" action="{{ route('login.submit') }}">
                    @csrf
                    <div class="space-y-5">
                        <div>
                            <label for="email" class="block pb-3 text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" id="email" class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-700 focus:border-fuchsia-300 focus:outline-none transition-shadow" placeholder="example@polban.ac.id">
                            @error('email')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="password" class="block pb-3 text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" class="focus:shadow-soft-primary-outline text-sm block w-full rounded-lg border border-gray-300 px-3 py-2 text-gray-700 focus:border-fuchsia-300 focus:outline-none transition-shadow" placeholder="********">
                            @error('password')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="submit" class="inline-block w-full px-6 py-3 font-bold text-white uppercase transition-all bg-orange-500 hover:bg-orange-700 rounded-lg shadow-md hover:scale-105 hover:shadow-lg focus:ring-2 focus:ring-orange-400 focus:outline-none">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

@endsection