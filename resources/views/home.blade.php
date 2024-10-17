@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')

<section class="home" id="home">
  <div class="home-content">
    <h3>Claim Best Offer <br> On Fast <span>Cuppa Coffee</span></h3>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sed, quibusdam minus. Ea accusamus rem numquam.</p>
    <a href="#our-menu" id="home-btn">More Details</a>
  </div>
  <div class="img">
    <img src="images/header.jpg" alt="">
  </div>
</section>
  @for($i=0; $i< count($categories); $i++)
    @if(count($categories[$i]->products) > 0)
      <section class="menu" id="menu">
        <h3 class="text-center">{{$categories[$i]['name']}}</h3>
        @if($i==0)
          <h2>Delicious Coffee Is Here <i class="fa-solid fa-arrow-down"></i></h2>
        @endif
        <div class="row" style="margin-top: 30px;">
          @foreach($categories[$i]->products as $product)
            <div class="col-md-4 py-3 py-md-0">
              <div class="card">
                <img src='{{asset("storage/".$product["image"])}}' alt="">
                <div class="card-body">
                  <h3>{{$product['name']}}</h3>
                  <h6><hr></h6>
                  <p>{{$product['price']}} EG
                    <i class="h3"><span class="mdi mdi-heart-outline"></span></i>
                  </p>
                  <div style="text-align:center;">
                    <button class="btn btn-light" data-bs-toggle="offcanvas" data-bs-target="#enrollment">Quick View</button>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </section>
      <div class="container">
          <div class="line" style="width: 100%; height: 2px; background-color: #E59A59;"></div>
      </div>
    @endif
@endfor

@include('contactUs')
@include('partials.footer')

