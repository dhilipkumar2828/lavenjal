// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
*/
firebase.initializeApp({
    apiKey: "AIzaSyBgHf2b1scHNT9SjpUcPrNfKdHc6VGrfvU",
    authDomain: "lavenjal-1a0f1.firebaseapp.com",
    projectId: "lavenjal-1a0f1",
    storageBucket: "lavenjal-1a0f1.appspot.com",
    messagingSenderId: "288696626576",
    appId: "1:288696626576:web:c354bcaf3b79c0c8ad5715",
    measurementId: "G-KE920V3D87"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
    console.log("Message received.", payload);
    const title = "Hello world is awesome";
    const options = {
        body: "Your notificaiton message .",
        icon: "/firebase-logo.png",
    };
    return self.registration.showNotification(
        title,
        options,
    );
});