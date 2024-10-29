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

        $('.favorite-icon').on('click', function() {
            const productId = $(this).data('id');

            $.ajax({
                url: '{{ route('add-wishlist') }}', // Adjust to your route
                method: 'POST',
                data: {
                    product_id: productId,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    // Handle success response (e.g., change icon)
                    console.log(response);
                },
                error: function(xhr) {
                    // Handle error response
                    console.error(xhr.responseText);
                }
            });
        });

        $('.destroy-favorite-icon').on('click', function() {
            const productId = $(this).data('id');

            $.ajax({
                url: '/wishlist/'+productId, // Adjust to your route
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    // Handle success response (e.g., change icon)
                    console.log(response);
                },
                error: function(xhr) {
                    // Handle error response
                    console.error(xhr.responseText);
                }
            });
        });
    });

    function toggleFavorite(element) {
      const isAuthenticated = @json(auth()->check());

        if (!isAuthenticated) {
            // Redirect to the login page
            window.location.href = '{{ route("login") }}'; // Adjust the route name as necessary
            return;
        }
        
        const icon = element.querySelector('span');
        if (icon.classList.contains('mdi-heart-outline')) {
            icon.classList.remove('mdi-heart-outline');
            icon.classList.add('mdi-heart');
        } else {
            icon.classList.remove('mdi-heart');
            icon.classList.add('mdi-heart-outline');
        }
    }

    function addToCart(productId) {
        const variantSelect = document.getElementById('variant-select-' + productId);
        const selectedVariantId = variantSelect.options[variantSelect.selectedIndex].value;
        
        $.ajax({
            url: '/cart/add-product', // Adjust to your route
            method: 'POST',
            data: {
                product_id: productId,
                variant_id: selectedVariantId,
                _token: '{{ csrf_token() }}' // Include CSRF token
            },
            success: function(response) {
                // Handle success response (e.g., change icon)
                alert('Product added to cart!');
            },
            error: function(xhr) {
                // Handle error response
                console.error(xhr.responseText);
            }
        });
    }
</script>