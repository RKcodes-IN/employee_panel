  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.16.0/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyAJTNvsxVxnL8GljPgKUOX6I_Y1JKawS3Q",
    authDomain: "easygo-transport.firebaseapp.com",
    databaseURL: "https://easygo-transport-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "easygo-transport",
    storageBucket: "easygo-transport.appspot.com",
    messagingSenderId: "1075775162016",
    appId: "1:1075775162016:web:4215f1e0416bddd9832bc5",
    measurementId: "G-LSQ78G5R0L"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
