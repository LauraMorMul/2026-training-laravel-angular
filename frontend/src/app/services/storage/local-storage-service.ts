import { Injectable } from '@angular/core';
import { IOrder } from 'src/app/models/order';

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

  getRestaurantToken(): string | null{
    return localStorage.getItem('restaurant_token');
  }

  isThereRestToken(): boolean {
    return localStorage.getItem('restaurant_token') !== null;
  }

  removeRestaurantToken(): void {
    localStorage.removeItem('restaurant_token');
  }

  setRestName(value: string): void {
    localStorage.setItem('restaurant_name', value);
  }

  getRestName(): string | null {
    return localStorage.getItem('restaurant_name');
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
    console.log('valor en localStorage:', order);
    return order ? JSON.parse(order) : null;
  }

  getOrderId(tableId: string): string | null {
    const order = this.getOrderByTable(tableId);
    return order?.id || null;
  }

  removeOrderByTable(tableId: string): void {
    localStorage.removeItem(`order-for-${tableId}`);
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
