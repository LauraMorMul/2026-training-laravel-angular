import { Component, OnInit } from '@angular/core';
import { UserListComponent } from "../user-list/user-list.component";

@Component({
  selector: 'app-users-container',
  templateUrl: './users-container.component.html',
  styleUrls: ['./users-container.component.scss'],
  imports: [UserListComponent],
})
export class UsersContainerComponent  implements OnInit {

  constructor() { }

  ngOnInit() {}

}
