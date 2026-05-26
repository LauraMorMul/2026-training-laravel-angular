import { TestBed } from '@angular/core/testing';

import { TableNameService } from './table-name-service';

describe('TableNameService', () => {
  let service: TableNameService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(TableNameService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
