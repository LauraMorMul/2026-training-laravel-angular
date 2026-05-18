import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'filterBySearchBar',
})
export class FilterBySearchBarPipe implements PipeTransform {
  transform(data: any[], attribute: string, searchBar?: string): any[] {
    if (searchBar === null || searchBar === undefined || searchBar === '') {
      return data;
    } else {
      return data.filter((d) =>
        d[attribute].toString().toLowerCase().includes(searchBar.toLowerCase()),
      );
    }
  }
}
