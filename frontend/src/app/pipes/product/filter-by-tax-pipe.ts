import { Pipe, PipeTransform } from '@angular/core';
import { IProducts } from 'src/app/models/product';

@Pipe({
  name: 'filterByTax'
})
export class FilterByTaxPipe implements PipeTransform {

  transform(products: IProducts, tax?: string): IProducts {
    if (tax === undefined || tax === null || tax === '') {
      return products;
    } else {
      return products.filter((producto) => producto.tax.uuid === tax);
    }
  }

}
