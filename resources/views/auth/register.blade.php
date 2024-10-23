@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')

<section class="login">
    <form action="{{route('register')}}" method="post" class="">
        @csrf
        <h2>Create Account</h2>
        <div class="input">
            <label class="required"> Your Name</label>
            <input type="text" placeholder="" name="name" class="form-control form-control-lg">
            <x-input-error :messages="$errors->get('bame')" class="mt-2" />
        </div>
        <div class="input">
            <label class="required">Email</label>
            <input type="email" placeholder="" name="email" class="form-control form-control-lg">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="input">
            <label class="required">Password</label>
            <input type="password" placeholder="" name="password" class="form-control form-control-lg">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="input">
            <label class="required">Password Confirmation</label>
            <input type="password" placeholder="" name="password_confirmation" class="form-control form-control-lg">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <input type="submit" value="Create Account" class="btn btn-primary">
        </div>
    </form>
</section>

@include('partials.footer')