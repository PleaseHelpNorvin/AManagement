import { TestBed } from '@angular/core/testing';

import { UpdateAcitivtyService } from './update-acitivty.service';

describe('UpdateAcitivtyService', () => {
  let service: UpdateAcitivtyService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(UpdateAcitivtyService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
