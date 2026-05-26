import { Pipe, PipeTransform } from '@angular/core';
import { ITables } from 'src/app/models/table';

@Pipe({
  name: 'findTableName'
})
export class FindTableNamePipe implements PipeTransform {

  transform(tableId: string, tables: ITables): string {
      return tables.find(t => t.id === tableId)?.name || '';
    }

}
