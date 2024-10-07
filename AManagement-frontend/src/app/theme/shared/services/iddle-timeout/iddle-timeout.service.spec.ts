import { TestBed } from '@angular/core/testing';

import { IddleTimeoutService } from './iddle-timeout.service';

describe('IddleTimeoutService', () => {
  let service: IddleTimeoutService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(IddleTimeoutService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
