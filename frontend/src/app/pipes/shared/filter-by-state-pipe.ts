import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'filterByState',
})
export class FilterByStatePipe implements PipeTransform {
  transform(data: any[], state?: string): any[] {
    if (state === null || state === 'undefined' || state === undefined) {
      return data;
    } else {
      return data.filter((d) => d.active.toString() === state);
    }
  }
}
