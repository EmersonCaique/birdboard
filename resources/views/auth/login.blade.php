@extends('layouts.app')

@section('content')
<div class="container">
    <form method="POST" action="{{ route('login') }}"
    class="lg:w-1/2 lg:mx-auto bg-card py-12 px-16 rounded shadow"
>
  @csrf

  <h1 class="text-2xl font-normal mb-10 text-center">Login</h1>

  <div class="field mb-6">
      <label class="label text-sm mb-2 block" for="email">Email Address</label>

      <div class="control">
          <input id="email"
                 type="email"
                 class="input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('email') ? ' is-invalid' : '' }}"
                 name="email"
                 value="{{ old('email') }}"
                 required>
      </div>
  </div>

  <div class="field mb-6">
      <label class="label text-sm mb-2 block" for="password">Password</label>

      <div class="control">
          <input id="password"
                 type="password"
                 class="input bg-transparent border border-muted-light rounded p-2 text-xs w-full{{ $errors->has('password') ? ' is-invalid' : '' }}"
                 name="password"
                 required>
      </div>
  </div>

  <div class="field mb-6">
      <div class="col-md-8 offset-md-4">
          <button type="submit" class="button mr-2">
              Login
          </button>
      </div>
  </div>
</form>
</div>
@endsection
