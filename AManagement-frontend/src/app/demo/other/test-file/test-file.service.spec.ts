import { TestBed } from '@angular/core/testing';

import { TestFileService } from './test-file.service';

describe('TestFileService', () => {
  let service: TestFileService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TestFileService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
