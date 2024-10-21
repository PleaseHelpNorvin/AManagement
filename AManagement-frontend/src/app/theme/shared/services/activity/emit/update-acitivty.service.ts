// update-activity.service.ts
import { Injectable } from '@angular/core';
import { Subject } from 'rxjs';
import { ActivityService } from '../user-acitivty.service';

@Injectable({
  providedIn: 'root',
})
export class UpdateAcitivtyService {
  private activityUpdatedSubject = new Subject<void>();
  activityUpdated$ = this.activityUpdatedSubject.asObservable();
}