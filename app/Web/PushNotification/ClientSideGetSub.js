// company: PulseStream
// Developed by: Ngwang Shalom
// Location: Cameroon/Bamenda
// Languages: php/hack/javascript/node(library)
// position: Senior dev
//
//
// Please add your own description if you are a contributor
//
//
//

// Request permission for push notifications
Notification.requestPermission().then(permission => {
    if (permission === 'granted') {
      // User granted permission, subscribe to push notifications
      return navigator.serviceWorker.register('/PulsestreamPush.js');
    }
  }).then(registration => {
    // Subscribe the user to push notifications
    return registration.pushManager.subscribe({
      userVisibleOnly: true,
      applicationServerKey: '<YOUR_PUBLIC_VAPID_KEY>'
    });
  }).then(subscription => {
    // Extract the endpoint, auth key, and p256dh key
    const { endpoint, keys } = subscription;
    const { auth, p256dh } = keys;
  
    // Send the endpoint, auth key, and p256dh key to the server for storage
    // You can use AJAX or fetch to make an HTTP request to your server
    // Pass these values as JSON data to the server endpoint
    const data = {
      endpoint,
      auth,
      p256dh
    };
  
    // Make an HTTP request to the server to store the subscription data
    // Replace '<SERVER_ENDPOINT>' with your server endpoint URL
    fetch('<SERVER_ENDPOINT>', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(data)
    }).then(response => {
      // Handle the server response
      console.log('Subscription data stored on the server');
    }).catch(error => {
      console.error('Error storing subscription data:', error);
    });
  }).catch(error => {
    console.error('Error subscribing to push notifications:', error);
  });
  