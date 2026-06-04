import { Injectable } from '@angular/core';
import { IOrder } from 'src/app/models/order';
import { IOrderLines } from 'src/app/models/order_line';
import { IRestaurant } from 'src/app/models/restaurant';

@Injectable({
  providedIn: 'root',
})
export class LocalStorageService {
  constructor() {}

  setUserToken(value: string): void {
    localStorage.setItem('user_token', value);
  }

  setUserImg(value: string): void {
    localStorage.setItem('user_img', value);
  }

  getUserToken(): string | null {
    return localStorage.getItem('user_token');
  }

  getUserImg(): string | null {
    return localStorage.getItem('user_img');
  }

  isThereUserToken(): boolean {
    return localStorage.getItem('user_token') !== null;
  }

  removeUserToken(): void {
    localStorage.removeItem('user_token');
  }

  removeUserImg(): void {
    return localStorage.removeItem('user_img');
  }

  setRestaurantToken(value: string): void {
    localStorage.setItem('restaurant_token', value);
  }

  getRestaurantToken(): string | null {
    return localStorage.getItem('restaurant_token');
  }

  isThereRestToken(): boolean {
    return localStorage.getItem('restaurant_token') !== null;
  }

  removeRestaurantToken(): void {
    localStorage.removeItem('restaurant_token');
  }

  setRestaurant(restaurant: IRestaurant): void {
    localStorage.setItem('restaurant', JSON.stringify(restaurant));
  }

  getRestaurant(): IRestaurant | null {
    const restaurant = localStorage.getItem('restaurant');
    return restaurant ? JSON.parse(restaurant) : null;
  }

  setUserName(value: string): void {
    localStorage.setItem('user_name', value);
  }

  getUserName(): string | null {
    return localStorage.getItem('user_name');
  }

  setOrderByTable(tableId: string, order: IOrder): void {
    localStorage.setItem(`order-for-${tableId}`, JSON.stringify(order));
  }

  getOrderByTable(tableId: string): IOrder | null {
    const order = localStorage.getItem(`order-for-${tableId}`);
    return order ? JSON.parse(order) : null;
  }

  getOrderId(tableId: string): string | null {
    const order = this.getOrderByTable(tableId);
    return order?.id || null;
  }

  checkOrderByTable(tableId: string): boolean {
    const order = this.getOrderByTable(tableId);
    return order ? true : false;
  }

  removeOrderByTable(tableId: string): void {
    localStorage.removeItem(`order-for-${tableId}`);
  }

  setOrderLines(tableId: string, lines: IOrderLines): void {
    localStorage.setItem(`order-lines-${tableId}`, JSON.stringify(lines));
  }

  getOrderLines(tableId: string): IOrderLines | null {
    const lines = localStorage.getItem(`order-lines-${tableId}`);
    return lines ? JSON.parse(lines) : null;
  }

  removeOrderLines(tableId: string): void {
    localStorage.removeItem(`order-lines-${tableId}`);
  }

  getItem(key: string): string | null {
    return localStorage.getItem(key);
  }

  removeItem(key: string): void {
    localStorage.removeItem(key);
  }

  clear(): void {
    localStorage.clear();
  }
}
