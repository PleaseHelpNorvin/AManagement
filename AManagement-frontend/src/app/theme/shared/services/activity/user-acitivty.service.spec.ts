import { TestBed } from '@angular/core/testing';

import  {ActivityService} from './user-acitivty.service';

describe('UserAcitivtyService', () => {
  let service: ActivityService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ActivityService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
