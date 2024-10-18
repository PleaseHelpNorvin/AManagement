import { TestBed } from '@angular/core/testing';

import  {UserActivtyService} from './user-acitivty.service';

describe('UserAcitivtyService', () => {
  let service: UserActivtyService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(UserActivtyService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
