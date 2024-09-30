import { Injectable, OnDestroy } from '@angular/core';
import { fromEvent, Subscription, timer,Subject } from 'rxjs';
import { switchMap } from 'rxjs/operators';
import { AuthService } from './auth.service';

@Injectable({
  providedIn: 'root'
})

export class IdleService  implements OnDestroy {
  private idleTimeout: any;
  private idleTimeLimit = 1 * 60 * 1000;
  private subscriptions: Subscription = new Subscription();
  private idleSubject = new Subject<void>();
  idle$ = this.idleSubject.asObservable();
    
  constructor(private authService: AuthService) {
    this.startIdleTimer();
   }

  startIdleTimer() {
    this.resetIdleTimer();
    const events = fromEvent(document, 'mousemove');
    const keyboardEvents = fromEvent (document, 'keydown');

    this.subscriptions.add(events.subscribe(() => this.resetIdleTimer()));
    this.subscriptions.add(keyboardEvents.subscribe (() => this.resetIdleTimer()));
  }
  resetIdleTimer() {
    this.clearIdleTimer();

    this.idleTimeout = setTimeout(() => {
      this.handleTimeout();
    }, this.idleTimeLimit);
  }

  clearIdleTimer() {
    if(this.idleTimeout) {
      clearTimeout(this.idleTimeout);
    }
  }

  handleTimeout() {
    console.warn('user is idle, triggering logout or warning...');
    alert('You have been away from the keyboard.');
    this.authService.logout().subscribe(()=> {
      this.idleSubject.next();
    });
  }

  ngOnDestroy(): void {
    this.clearIdleTimer();
    this.subscriptions.unsubscribe();
  }
}
