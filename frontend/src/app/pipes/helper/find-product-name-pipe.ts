import { Pipe, PipeTransform } from '@angular/core';
import { IProducts } from 'src/app/models/product';

@Pipe({
  name: 'findProductName'
})
export class FindProductNamePipe implements PipeTransform {

  transform(productId: string, products: IProducts): string {
    return products.find(p => p.id === productId)?.name || '';
  }

}
