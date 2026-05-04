import { Component, inject, OnInit } from '@angular/core';
import {
  IonCard,
  IonCardHeader,
  IonCardTitle,
  IonCardContent,
  IonItem,
  IonList,
  IonAvatar,
  IonLabel,
} from '@ionic/angular/standalone';
import { UserService } from 'src/app/services/entity/user-service';

@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonList,
    IonItem,
    IonAvatar,
    IonLabel
  ],
})
export class UserListComponent implements OnInit {
  private userService = inject(UserService);
  users : any[] = [];

  ngOnInit() {
    this.getUsers();
  }

  getUsers() {
    this.userService
    .getAll()
    .subscribe({
      next: (response: any) => {
        this.users = response;
        console.log(this.users);
      },
      error(err) {
        console.log("Ni de coña jeje");
      }
    })
  }
}
