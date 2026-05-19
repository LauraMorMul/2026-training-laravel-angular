import { Pipe, PipeTransform } from '@angular/core';
import { ITables } from 'src/app/models/table';

@Pipe({
  name: 'filterByZone',
})
export class FilterByZonePipe implements PipeTransform {
  transform(tables: ITables, zone?: string): ITables {
    if (zone === undefined || zone === null || zone === '') {
      return tables;
    } else {
      return tables.filter((tables) => tables.zone.id === zone);
    }
  }
}
