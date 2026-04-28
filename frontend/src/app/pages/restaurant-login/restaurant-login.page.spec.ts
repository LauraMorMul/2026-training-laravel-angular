import { ComponentFixture, TestBed } from '@angular/core/testing';
import { RestaurantLoginPage } from './restaurant-login.page';

describe('RestaurantLoginPage', () => {
  let component: RestaurantLoginPage;
  let fixture: ComponentFixture<RestaurantLoginPage>;

  beforeEach(() => {
    fixture = TestBed.createComponent(RestaurantLoginPage);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
