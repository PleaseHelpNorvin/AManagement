import { Injectable } from '@angular/core';
import Echo from 'laravel-echo';
import { Subject } from 'rxjs';
import Pusher from 'pusher-js'; // Ensure Pusher is imported

const PUSHER_APP_KEY = '4d9101cca8b4060cbd1d';
const PUSHER_APP_CLUSTER = 'ap1';
const BROADCAST_URL = 'http://127.0.0.1:8000'; // Make sure the correct backend URL is used

@Injectable({
  providedIn: 'root',
})
export class BroadcastService {
  private broadcastSubject = new Subject<string>();
  private echo: Echo<any> | null = null; // Initialize with null

  constructor() {
    // Dynamically import Pusher and initialize Echo
    import('pusher-js').then((PusherModule) => {
      const Pusher = PusherModule.default; // Access default export

      // Create and assign Echo instance after Pusher is loaded
      this.echo = new Echo({
        broadcaster: 'pusher',
        key: PUSHER_APP_KEY,
        cluster: PUSHER_APP_CLUSTER,
        encrypted: true,
        forceTLS: true,
        disableStats: true,
        // wsHost and wsPort are not needed when using Pusher
      });
    }).catch((error) => {
      console.error('Error loading Pusher:', error);
    });
  }

  // Listen for broadcasts
  listenForBroadcasts(userId: number) {
    // Ensure Echo is initialized before attempting to listen
    if (this.echo) {
      this.echo.private(`private-channel.user.${userId}`)
        .listen('MessageSent', (event: any) => {
          console.log('New message received: ', event);
          this.broadcastSubject.next(event.message);
        });
    } else {
      console.error('Echo is not initialized');
    }
  }

  // Get the observable for the received messages
  getBroadcast() {
    return this.broadcastSubject.asObservable();
  }

  // Start listening for a user
  startListening(userId: number) {
    this.listenForBroadcasts(userId);
  }

  // Stop listening for a user
  stopListening(userId: number) {
    if (this.echo) {
      this.echo.leave(`private-channel.user.${userId}`);
    }
  }
}
