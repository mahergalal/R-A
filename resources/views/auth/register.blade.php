@extends('Admin.layout.layout')
@section('adminContent')


<div class="main-content section bg-primary text-dark section-lg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">

            <form  method="POST" action="{{ route('register') }}">
                @csrf
                <div class="card bg-primary shadow-soft border-light text-center py-4">
                    <div class="card-body">

                        <div class="form-group mb-4">
                            <label for="name">Name</label>
                            <input   class="form-control" id="name"  type="text" name="name" :value="old('name')" required autofocus autocomplete="name" >
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="form-group mb-4">
                            <label for="email"> Email</label>
                            <input   class="form-control" id="email"  type="email" name="email" :value="old('email')" required autocomplete="username">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="form-group mb-4">
                            <label for="user_id">user_id</label>
                            <input type="text" name="user_id"  class="form-control" id="user_id" aria-describedby="passwordHelp" placeholder="user_id">
                        </div>

                        <div class="form-group mb-4">
                            <label for="role"> role</label>
                            <input type="text" name="role"  class="form-control" id="role" aria-describedby="passwordHelp" placeholder="role">
                        </div>

                        <div class="form-group mb-4">
                            <label for="password"> password</label>
                            <input class="form-control" id="password"
                            type="password"
                            name="password"
                            required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="form-group mb-4">
                            <label for="password_confirmation"  > Confirm password</label>
                            <input class="form-control" id="password_confirmation"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>



                        <div class="row justify-content-left mt-4">
                            <div class="col-lg-12">
                                <button class="btn btn-primary animate-down-2 mr-2 text-success" type="submit">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>


@endsection
