<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <title>Pay Page</title>
</head>
<script src="https://js.stripe.com/v3/"></script>

<body>
  <div class="container">
    <h2 class="my-4 text-center">Intro To React Course [$50]</h2>
    <form action="./charge.php" method="post" id="payment-form">
      <div class="form-row">
       <input type="text" name="first_name" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="First Name">
       <input type="text" name="last_name" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Last Name">
       <input type="email" name="email" class="form-control mb-3 StripeElement StripeElement--empty" placeholder="Email Address">
        <div id="card-element" class="form-control">
          <!-- a Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors -->
        <div id="card-errors" role="alert"></div>
      </div>

      <button>Submit Payment</button>
    </form>
  </div>
  <script>

      var stripe = Stripe('pk_test_3x5U7hMv1VVJK77QrULQ1yQX00w0lRDjTA');
      var elements = stripe.elements();

      var style = {
          base: {
              // Add your base input styles here. For example:
              fontSize: '16px',
              color: "#32325d",
          }
      };

      // Create an instance of the card Element.
      var card = elements.create('card', {style: style});

      // Add an instance of the card Element into the `card-element` <div>.
      card.mount('#card-element');

      var form = document.getElementById('payment-form');
      form.addEventListener('submit', function(event) {
          event.preventDefault();

          stripe.createToken(card).then(function(result) {
              if (result.error) {
                  // Inform the customer that there was an error.
                  var errorElement = document.getElementById('card-errors');
                  errorElement.textContent = result.error.message;
              } else {
                  // Send the token to your server.
                  stripeTokenHandler(result.token);
              }
          });
      });



      function stripeTokenHandler(token) {
          // Insert the token ID into the form so it gets submitted to the server
          var form = document.getElementById('payment-form');
          var hiddenInput = document.createElement('input');
          hiddenInput.setAttribute('type', 'hidden');
          hiddenInput.setAttribute('name', 'stripeToken');
          hiddenInput.setAttribute('value', token.id);
          form.appendChild(hiddenInput);

          // Submit the form
          form.submit();
      }

  </script>
</body>
</html>