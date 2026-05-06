import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'roleFormatter'
})
export class RoleFormatterPipe implements PipeTransform {

  transform(value: string): string {
    if(value === 'operator') {
      return 'Operador'
    } else if (value === 'admin') {
      return 'Administrador'
    } else {
      return 'Supervisor'
    }
  }

}
