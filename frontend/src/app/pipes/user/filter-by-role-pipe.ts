import { Pipe, PipeTransform } from '@angular/core';
import { IUsers } from 'src/app/models/user';

@Pipe({
  name: 'filterByRole',
})
export class FilterByRolePipe implements PipeTransform {
  transform(users: IUsers, roles: string[]): IUsers {
    if (!roles || roles.length === 0) {
      return users;
    }
    return users.filter((user) => roles.includes(user.role));
  }
}
