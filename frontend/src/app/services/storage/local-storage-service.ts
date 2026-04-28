import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class LocalStorageService {
  constructor() {}

  setUserToken(value: string): void {
    localStorage.setItem('user_token', value);
  }

  getUserToken(): string | null {
    return localStorage.getItem('user_token');
  }

  removeUserToken(): void {
    localStorage.removeItem('user_token');
  }

  setRestaurantToken(value: string): void {
    localStorage.setItem('restaurant_token', value);
  }

  getRestaurantToken(): string | null{
    return localStorage.getItem('restaurant_token');
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
