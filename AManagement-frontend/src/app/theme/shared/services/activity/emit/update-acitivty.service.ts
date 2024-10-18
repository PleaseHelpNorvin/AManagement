import { Injectable, EventEmitter  } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class UpdateAcitivtyService {

  activityUpdated = new EventEmitter<void>();

  notifyActivityUpdate() {
    this.activityUpdated.emit();
  }
}
