import { Component, ViewChild } from '@angular/core';
import { UserListComponent } from '../user-list/user-list.component';
import { AddUserComponent } from '../add-user/add-user.component';

@Component({
  selector: 'app-users-container',
  templateUrl: './users-container.component.html',
  styleUrls: ['./users-container.component.scss'],
  imports: [UserListComponent, AddUserComponent],
})
export class UsersContainerComponent {
  @ViewChild('userListRef') userListRef!: UserListComponent;
}
