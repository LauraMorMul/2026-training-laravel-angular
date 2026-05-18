import { Pipe, PipeTransform } from '@angular/core';
import { IProducts } from 'src/app/models/product';

@Pipe({
  name: 'filterProductByFamily',
})
export class FilterProductByFamilyPipe implements PipeTransform {
  transform(products: IProducts, family?: string): IProducts {
    if (family === undefined || family === null || family === '') {
      return products;
    } else {
      return products.filter((producto) => producto.family.uuid === family);
    }
  }
}
