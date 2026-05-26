import { TestBed } from '@angular/core/testing';

import { ProductNameFinder } from './product-name-finder';

describe('ProductNameFinder', () => {
  let service: ProductNameFinder;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ProductNameFinder);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
