import { ComponentFixture, TestBed } from '@angular/core/testing';
import { TpvPage } from './tpv.page';

describe('TpvPage', () => {
  let component: TpvPage;
  let fixture: ComponentFixture<TpvPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(TpvPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
