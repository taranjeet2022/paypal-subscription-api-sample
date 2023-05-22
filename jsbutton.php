<html>
  <head>
    <meta http-equiv="Content-Security-Policy" content="sandbox allow-scripts allow-same-origin allow-popups;" />
  </head>
  <body>
    <div id="paypal-button-container-<plan-id>"></div>
<script src="https://www.paypal.com/sdk/js?client-id=<client-api-key>&vault=true&intent=subscription&currency=<currency-code>" data-sdk-integration-source="button-factory"></script>
<script>
  paypal.Buttons({
      style: {
          shape: 'rect',
          color: 'gold',
          layout: 'vertical',
          label: 'subscribe'
      },
      createSubscription: function(data, actions) {
        return actions.subscription.create({
          /* Creates the subscription */
          plan_id: '<plan-id>'
        });
      },
      onApprove: function(data, actions) {
        alert(data.subscriptionID); // You can add optional success message for the subscriber here
      }
  }).render('#paypal-button-container-<plan-id>'); // Renders the PayPal button
</script>

</body>

</html>
