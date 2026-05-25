import { TestBed } from '@angular/core/testing';

import { OrderLineManagerService } from './order-line-manager-service';

describe('OrderLineManagerService', () => {
  let service: OrderLineManagerService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(OrderLineManagerService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
