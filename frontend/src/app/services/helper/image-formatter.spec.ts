import { TestBed } from '@angular/core/testing';

import { ImageFormatter } from './image-formatter';

describe('ImageFormatter', () => {
  let service: ImageFormatter;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ImageFormatter);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
