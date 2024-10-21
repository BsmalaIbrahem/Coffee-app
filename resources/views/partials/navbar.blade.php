
<nav class="navbar navbar-expand-lg" id="navbar">
  
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
    <span><i class="fa-solid fa-bars"></i></span>
  </button>
  <div class="collapse navbar-collapse" id="mynavbar">
    <ul class="navbar-nav me-auto">
      @foreach($categories as $category)
        <li class="nav-item">
            <a href="{{route('get-product', ['category' => $category['name']])}}" class="nav-link">{{$category['name']}}</a>
        </li>
      @endforeach
      
      <li class="nav-item">
        <a href="#" class="nav-link">Contact us</a>
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
      <a href="cart.html">
        <span class="mdi mdi-cart-outline"></span>
      </a>
      <a href="login.html">
        <span class="mdi mdi-account-outline"></span>
      </a>
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
        <img src="images/logo.png">
  </a>
</nav>
