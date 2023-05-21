const webpush = require('web-push').default;

// Configure the web-push library with your VAPID keys
webpush.setVapidDetails(
  'mailto:your@email.com',
  '<YOUR_PUBLIC_VAPID_KEY>',
  '<YOUR_PRIVATE_VAPID_KEY>'
);

// Define the push notification payload
const pushPayload = JSON.stringify({
  title: 'New Notification',
  message: 'This is a sample push notification',
  url: 'https://example.com'
});

// Define the subscription object received from the client
const subscription = {
  endpoint: '<SUBSCRIPTION_ENDPOINT>',
  keys: {
    auth: '<SUBSCRIPTION_AUTH_KEY>',
    p256dh: '<SUBSCRIPTION_P256DH_KEY>'
  }
};

// Send the push notification
webpush.sendNotification(subscription, pushPayload)
  .then(() => {
    console.log('Push notification sent successfully!');
  })
  .catch((error) => {
    console.error('Error sending push notification:', error);
  });
