<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            background-color: #343a40;
            color: #ffffff;
            padding: 10px 0;
        }
        .content {
            margin-top: 20px;
        }
        .order-summary, .address-details {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container email-container">
        <div class="header" style="background-color:#E59A59">
            <h1 style="color:white; margin:5px;">Thank You for Your Order!</h1>
        </div>
        <div class="content">
            <p>Hi {{$order['user']['name']}},</p>
            <p>Thank you for placing an order with us. Here are the details of your order:</p>
            <div class="address-details">
                <h3>Shipping Address</h3>
                <p>{{$order['address']['details']}}</p>
            </div>
            <div class="order-summary">
                <h3>Order Summary</h3>
                <p><strong>Order ID:</strong> #{{$order['reference_id']}}</p>
                <p><strong>Total Price:</strong> {{$order['total']}}</p>
                <p><strong>Shipping Fee:</strong> {{$order['shipping_fee']}}</p>
                <p><strong>Quantity:</strong> {{$order['quantity']}}</p>
                <p><strong>Sub Total:</strong> {{$order['sub_total']}}</p>
            </div>
            
            <p>If you have any questions or need further assistance, please feel free to contact us.</p>
        </div>
        <div class="footer" style="background-color:#E59A59;">
            <p style="color:white; margin:5px;">Contact Us: support@example.com | +1234567890</p>
            <p style="color:white; margin:5px;">&copy; 2023 Your Company Name. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
