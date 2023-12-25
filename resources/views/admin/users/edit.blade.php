@extends('layouts.admin')

@section('content')
  <form class="max-w-sm" action="{{ route('editUserFromAdmin') }}" method="POST">
    @csrf
    @method('PUT')
    <h1 class="mb-4 text-xl font-bold">Edit User</h1>

    <input type="text" name="id" value="{{ $user->id }}" hidden>

    <div class="mb-5">
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Username</label>
      <input type="text" name="username"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="Aditya Mahendra" required value="{{ $user->username }}">
    </div>

    <div class="mb-5">
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Email</label>
      <input type="text" name="email"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="xxxxxxxxxxxxxxxx" required value="{{ $user->email }}">
    </div>

    <div class="mb-5">
      <label class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">New Password</label>
      <input type="password" name="new_password"
        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
        placeholder="xxxxxxxxxxxxxxxx">
    </div>

    <button type="submit"
      class="w-full rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 sm:w-auto">Submit</button>
  </form>
@endsection
