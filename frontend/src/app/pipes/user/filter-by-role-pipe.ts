import { Pipe, PipeTransform } from '@angular/core';
import { IUsers } from 'src/app/models/user';

@Pipe({
  name: 'filterByRole'
})
export class FilterByRolePipe implements PipeTransform {

  transform(users: IUsers, role?: string): IUsers {
      if (role === undefined || role === null || role === '') {
        return users;
      } else {
        return users.filter((user) => user.role === role);
      }
    }

}
