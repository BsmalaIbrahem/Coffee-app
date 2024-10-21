@if(session('message'))
  <x-alert level="info" message="{{session('message')}}" />
@endif
@include('partials.offer')
@include('partials.headTags')
@include('partials.navbar')
@include('partials.footerScript')

<section class="products">
  <h2 class="text-center py-3 bg-light" style="color:#212529c9; margin-bottom:30px;">{{request()->get('category') ?? ''}}</h2>

  <div class="d-flex justify-content-center">
    <select class="form-select" style="width:150px;">
      <option hidden>Roasting</option>
      <option>Light</option>
      <option>Medium</option>
    </select>
    <select class="form-select" style="width:150px;">
      <option hidden>Quality</option>
      <option>Elite</option>
      <option>PREMIUM</option>
    </select>
    <select class="form-select" style="width:150px;">
      <option hidden>Flavour</option>
      <option>سادة</option>
      <option>محوج</option>
    </select>
    <select class="form-select" style="width:150px;">
      <option hidden>Weight</option>
      <option>200 gm</option>
      <option>250 gm</option>
      <option>500 gm</option>
      <option>1000 gm</option>
    </select>
  </div>

  <section class="menu" id="menu">
    <div class="row" style="margin-top: 30px;">
        @foreach($products as $product)
            <div class="col-md-4 py-3 py-md-0">
                <div class="card">
                <img src='{{asset("/storage/".$product["main_image"])}}' alt="" class="card-img-top">
                <div class="card-body">
                    <h3>{{$product['name']}}</h3>
                    <h6><hr></h6>
                    <p>
                        @if($product['price_after_discount'] > 0)
                            <del style="text-decoration: line-through;">{{$product['price']}} EG</del>
                            {{$product['price_after_discount']}} EG
                        @else
                            {{$product['price']}} EG
                        @endif
                        <i class="h3"><span class="mdi mdi-heart-outline"></span></i>
                    </p>
                    <div style="text-align:center;">
                    <button class="btn btn-light" data-bs-toggle="offcanvas"  data-bs-target="#pro{{$product['id']}}"  data-product-id="{{$product['id']}}">Quick View</button>
                    </div>
                </div>
                </div>

                <div id="pro{{$product['id']}}" class="offcanvas offcanvas-top mt-5 mx-auto" style="width:700px; height:600px;">
                    <div class="offcanvas-header">
                        <h2 class="offcanvas-title"></h2>
                        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
                    </div>
                    <div class="container">
                        <div class="row">
                        <div class="col-12 col-md-5 d-flex justify-content-center">
                            <img src='{{asset("/storage/".$product["main_image"])}}' class="img-fluid" alt="Product Image">
                        </div>
                        <div class="col-12 col-md-6" style="margin-right: 5px;">
                            <h2>
                            {{$product['name']}} 
                            </h2>
                            @if(count($product['variants']) > 0)
                            <h3><span style="color:#E59A59" class="price{{$product['id']}}"></span></h3>
                            @else
                            <h3><span style="color:#E59A59">
                                @if($product['price_after_discount'] > 0)
                                <del style="text-decoration: line-through;">{{$product['price']}} EG</del>
                                {{$product['price_after_discount']}} EG
                                @else
                                {{$product['price']}} EG
                                @endif
                            </span></h3>
                            @endif
                            <p style="text-align:justify;">{{$product['description']}}</p>
                            <hr>
                            @if(count($product['variants']) > 0)
                            <select class="variant-select" >
                                @foreach($product['variants'] as $variant)
                                    <option value="{{$variant['id']}}" {{ $loop->first ? 'selected' : '' }}>{{$variant['name']}}</option>
                                @endforeach
                            </select>
                            <div id="{{$product['id']}}" class="subOptions"></div>
                            @endif
                            <hr>
                            <div style="text-align:center; margin-top:50px;">
                            <button class="btn btn-primary" style="background-color:#E59A59; color:white; border:3px solid #E59A59;">Add to Cart</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

     
    </div>
  
  </section>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.incrementView').click(function() {
      var productId = $(this).data('product-id'); // Get product ID

      $.ajax({
        url: '/products/increment-view/'+productId, // Replace with your route
        type: 'get',
        success: function(response) {
          // Handle success (e.g., show a success message)
          //console.log(response);
          //alert('View count incremented successfully!');
        },
        error: function(xhr) {
          // Handle error
          console.error(xhr);
          alert(xhr);
        }
      });
    });
  });
</script>
@php $locale = app()->getLocale(); @endphp
<script>
    $(document).ready(function() {
        const locale = '{{ $locale }}';
        function fetchVariantDetails(variantId) {
            if (variantId) {
                $.ajax({
                    url: `/variant/${variantId}`,
                    method: 'GET',
                    success: function(response) {
                        const variant = response.data;
                        let variantDetails = '#' + variant.product_id;
                        let detailsHtml = ``;
                        let variantPrice = '';
                        if(variant && variant?.price_after_discount > 0){
                          //style="text-decoration: line-through;"
                          variantPrice += '<del style="text-decoration: line-through;">'
                          variantPrice += variant.price + ' EG ';
                          variantPrice += '</del>';
                          variantPrice += variant.price_after_discount + ' EG';
                        }else{
                          variantPrice += variant.price + ' EG' ?? variant.product.price + ' EG';
                        }

                        if (variant.sub_options && variant.sub_options.length) {
                            detailsHtml += '<ul>';
                            variant.sub_options.forEach(subOption => {
                                detailsHtml += `<li>${subOption.option.name[locale]} : ${subOption.name[locale]}</li>`;
                            });
                            detailsHtml += '</ul>';
                        }

                        $('.price'+variant.product_id).html(variantPrice);
                        $(variantDetails).html(detailsHtml);
                        //$('#product-price').html(variant.price);
                    },
                    error: function() {
                      
                        $(variantDetails).html('<p>Error fetching variant details.</p>');
                    }
                });
            } else {
                $(variantDetails).empty();
            }
        }

        // Fetch details for the default selected product on page load
        $('.variant-select').change(function() {
            const variantId = $(this).val();
            const productId = $(this).data('product-id');
            const detailsContainer = $(this).closest('.offcanvas').find('.variant-details');
            fetchVariantDetails(variantId, productId, detailsContainer);
        });

        // Trigger change event on page load for all variant selects
        $('.variant-select').each(function() {
            $(this).change();
        });
    });
</script>

@include('partials.footer')