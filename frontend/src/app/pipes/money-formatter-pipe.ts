import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'moneyFormatter'
})
export class MoneyFormatterPipe implements PipeTransform {

  transform(price: number) {
    return price / 100;
  }

}
