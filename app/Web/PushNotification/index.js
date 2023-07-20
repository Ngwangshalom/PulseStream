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
//
//web push notifiaction keys generate
//run node index.js

// example of Public Key: BDOmifeWBZi4q04qEdJoy5CMeehOgHKwTiTtlsZdRuyuYHQZCe8m73JIsCLJu7fi8QsE5jSMPwRpkKtZ6oqEPOQ
//example of Private Key: -KozoX_rb-5XVR22GL23rTOsK2yknBf4tASgdZJNUvw

const webpush = require('web-push');

const vapidKeys = webpush.generateVAPIDKeys();
console.log('Public Key:', vapidKeys.publicKey);
console.log('Private Key:', vapidKeys.privateKey);
