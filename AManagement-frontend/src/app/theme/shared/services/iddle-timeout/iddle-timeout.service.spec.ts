import { TestBed } from '@angular/core/testing';

import { IdleTimeoutService} from '../iddle-timeout/iddle-timeout.service';

describe('IddleTimeoutService', () => {
  let service: IdleTimeoutService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(IdleTimeoutService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
