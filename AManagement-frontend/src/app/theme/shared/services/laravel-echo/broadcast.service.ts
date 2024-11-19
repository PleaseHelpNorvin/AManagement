// import { Injectable } from '@angular/core';
// import Echo from 'laravel-echo';
// import Pusher from 'pusher-js';

// // Define the structure of the data received from the events
// interface PrivateEventData {
//   message: string;
//   sender_id: number;
// }

// @Injectable({
//   providedIn: 'root'
// })
// export class BroadcastService {
//   private echo: Echo<PrivateEventData>; // Provide the type argument for Echo

//   constructor() {
//     this.echo = new Echo({
//       broadcaster: 'pusher',
//       key: 'your-pusher-key',
//       cluster: 'mt1',
//       forceTLS: true,
//       authEndpoint: 'http://your-laravel-api/broadcasting/auth',
//       auth: {
//         headers: {
//           Authorization: `Bearer ${localStorage.getItem('authToken')}`
//         }
//       }
//     });
//   }

//   listenToPrivateChannel(userId: number): void {
//     this.echo.private(`private-channel.user.${userId}`)
//       .listen('PrivateEvent', (data) => { // Type is inferred from Echo<PrivateEventData>
//         console.log('PrivateEvent received', data);
//       });
//   }
// }
