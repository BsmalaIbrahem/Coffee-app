<style>
  .direction{
    @if(session('language') == 'en')
      direction:ltr;
    @else
      direction:rtl;
    @endif
  }
</style>
<nav class="navbar navbar-expand-lg" id="navbar">
  
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
    <span><i class="fa-solid fa-bars"></i></span>
  </button>
  <div class="collapse navbar-collapse" id="mynavbar">
    <ul class="navbar-nav me-auto direction">
      @foreach($categories as $category)
        <li class="nav-item">
            <a href="{{route('get-product', ['category' => $category['name']])}}" class="nav-link">{{$category['name']}}</a>
        </li>
      @endforeach
      
      <li class="nav-item">
        <a href="{{route('home')}}/#contact" class="nav-link">{{__('keywords.ContactUS')}}</a>
      </li>
    </ul>

    <a href="{{route('home')}}" class="navbar-brand me-auto" id="logo">
        <img src="{{asset('images/logo.png')}}">
    </a>

    <form action="{{route('get-product')}}" method="get" class="d-flex" style="margin-right:5px; margin-top:5px;">

      <div class="input-group input-group-md mb-3">

        <input type="text" class="form-control" aria-label="Search" placeholder="Search" name="search_key" required aria-describedby="basic-addon1">
        <div class="input-group-prepend">
          <button class="btn btn-outline-secondary" type="button"  id="basic-addon1">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <div class="user-logo">
      <a href="{{route('cart')}}">
        <span class="mdi mdi-cart-outline"></span>
      </a>
      @if(!auth()->check())
        <a href="{{route('login')}}">
          <span class="mdi mdi-account-outline"></span>
        </a>
      @else
      <div class="dropdown">
        <button class="btn" style="padding:0;" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="mdi mdi-account-outline" style="font-size:30px"></span>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
          <a class="dropdown-item" href="{{route('orders')}}" type="button">{{__('keywords.Orders')}}</a>
          <a class="dropdown-item" href="{{route('wishlists')}}" type="button">{{__('keywords.Wishlists')}}</a>
          <a class="dropdown-item" href="{{route('profile.edit')}}" type="button">{{__('keywords.Profile')}}</a>
          <hr>
          <form action="{{route('logout')}}" method="POST">
            @csrf
            <button class="dropdown-item" type="submit">{{__('keywords.Logout')}}</button>
          </form>
        </div>
      </div>

      @endif
      @if(session('language') == 'en' || !session('language'))
        <a href="{{route('changeLanguage')}}">
          <span class="mdi mdi-abjad-arabic"></span>
        </a>
      @else
        <a href="{{route('changeLanguage')}}">
          <span class="mdi mdi-alpha-e-box" ></span>
        </a>
      @endif
      
    </div>

  </div>

  <a href="{{route('home')}}" class="navbar-brandd-mobile me-auto" id="logo">
        <img src="{{asset('images/logo.png')}}">
  </a>
</nav>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>