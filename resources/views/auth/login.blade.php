@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')

<style>
    .direction{
        @if(session('language') == 'en')
        text-align:left;
        @else
        text-align:right;
        @endif
    }
</style>

<section class="login">
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h2>{{__('keywords.Login')}}</h2>
        <div class="input">
            <label class="required">{{__('keywords.Email')}}</label>
            <input type="email" placeholder="" name="email" class="form-control form-control-lg" :value="old('email')" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="input">
            <label class="required">{{__('keywords.Password')}}</label>
            <input type="password" placeholder="" name="password" class="form-control form-control-lg" required>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <input type="submit" value="Login" class="btn btn-primary">
        </div>
        <hr>
        <div class="login-links direction" >
            <a href="#" hidden="">Forgot password ?</a>
            <span>  </span>
            <a href="{{route('register')}}" >{{__('keywords.CreateAccount')}}</a>
            <span>!</span>
        </div>
    </form>
</section>


@include('partials.footer')