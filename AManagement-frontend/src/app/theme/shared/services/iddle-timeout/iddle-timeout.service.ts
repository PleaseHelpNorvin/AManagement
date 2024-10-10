import { Injectable } from '@angular/core';
import { Subject, Observable, fromEvent, merge, timer, Subscription } from 'rxjs';
import { mapTo, switchMap, takeUntil } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class IddleTimeoutService {
  private idleTimeLimit = 60 * 1000; // 30 seconds for testing purposes
  private timeout$ = new Subject<void>();
  private activitySubscription: Subscription | null = null;

  constructor() {}

  // Start watching user activity and notify when idle timeout is reached
  startWatching(): void {
    console.log('Idle timeout service started.');

    if(this.activitySubscription) {
      // console.log(this.activitySubscription);
      this.activitySubscription.unsubscribe();
    }

    const activityEvents$ = merge(
      fromEvent(document, 'mousemove'),
      fromEvent(document, 'keydown'),
      fromEvent(document, 'click')
    );

    // Log the activity events
    // activityEvents$.subscribe(event => {
    //   console.log('User activity detected:', event);
    // });

    activityEvents$
      .pipe(
        switchMap(() =>
          timer(this.idleTimeLimit).pipe(
            mapTo(undefined),
            takeUntil(activityEvents$)
          )
        )
      )
      .subscribe(() => this.timeout$.next());
  }

  // Observable to notify about timeout
  onTimeout(): Observable<void> {
    return this.timeout$.asObservable();
  }

  // Reset the idle timer manually (useful for actions like login)
  resetTimer(): void {
    this.startWatching();
  }

   // Stop watching user activity
  stopWatching(): void {
    if (this.activitySubscription) {
      this.activitySubscription.unsubscribe();
      this.activitySubscription = null; // Clear the subscription
    }
  }
}

