
@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')
@include('partials.validationError')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('keywords.ProfileInformation') }}</div>

                <div class="card-body">
                    <div class="mb-3">
                        <strong>{{__('keywords.YourName')}}</strong>
                        <p>{{ Auth::user()->name }}</p>
                    </div>

                    <div class="mb-3">
                        <strong>{{__('keywords.Email')}}</strong>
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <a href="" class="btn btn-primary" data-bs-toggle="offcanvas"  data-bs-target="#edit" style="background-color:#E59A59; border:2px solid #E59A59;">{{__('keywords.EditProfile')}}</a>
                        <a href="" data-bs-toggle="offcanvas"  data-bs-target="#password" class="btn btn-secondary">{{ __('keywords.ChangePassword') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="edit" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:450px; height:500px;">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title">{{__('keywords.EditProfile')}}</h2>
            <button class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <section class="login" style="width:80%;">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                <div class="input">
                    <label class="required"> {{__('keywords.YourName')}}</label>
                    <input type="text" placeholder="" name="name" class="form-control form-control-lg" value="{{ Auth::user()->name }}">
                    <x-input-error :messages="$errors->get('bame')" class="mt-2" />
                </div>

                <div class="input">
                    <label class="required">{{__('keywords.Email')}}</label>
                    <input type="email" placeholder="" name="email" class="form-control form-control-lg" value="{{ Auth::user()->email }}" required autofocus autocomplete="username">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <input type="submit" value="{{__('keywords.Edit')}}" class="btn btn-primary">
                </div>
            </form>
        </section>

    </div>

    <div id="password" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:450px; height:500px;">
        <div class="offcanvas-header">
            <h2 class="offcanvas-title">{{ __('keywords.ChangePassword') }}</h2>
            <button class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <section class="login" style="width:80%;">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                <div class="input">
                    <label class="required">{{__('keywords.Password')}}</label>
                    <input type="password" placeholder="" name="current_password" class="form-control form-control-lg">
                    <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                </div>

                <div class="input">
                    <label class="required">{{__('keywords.NewPassword')}}</label>
                    <input type="password" placeholder="" name="password" class="form-control form-control-lg">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="input">
                    <label class="required">{{__('keywords.NewPasswordConfirmation')}}</label>
                    <input type="password" placeholder="" name="password_confirmation" class="form-control form-control-lg">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>


                <div>
                    <input type="submit" value="{{__('keywords.Edit')}}" class="btn btn-primary">
                </div>
            </form>
        </section>

    </div>
</div>


@include('partials.footer')
