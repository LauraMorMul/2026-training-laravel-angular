import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root',
})
export class MoneyManagerService {
  calculatePriceInInteger(startingPrice: string) {
    const priceWithDot = Number(startingPrice.replace(',', '.'));
    return priceWithDot * 100;
  }

  calculatePriceWithDecimals(price: number) {
    return price / 100;
  }
}
