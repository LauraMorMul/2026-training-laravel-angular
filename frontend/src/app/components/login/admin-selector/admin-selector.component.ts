import { Component, inject, OnInit } from '@angular/core';
import { IUsers } from 'src/app/models/user';
import { IonCard, IonThumbnail, IonCardHeader, IonCardTitle, IonCardContent, ModalController } from "@ionic/angular/standalone";
import { ImageFormatter } from 'src/app/services/helper/image-formatter';
import { RoleFormatterPipe } from 'src/app/pipes/role-formatter-pipe';
import { FilterByRolePipe } from 'src/app/pipes/user/filter-by-role-pipe';
import { PinPadUserComponent } from '../pin-pad-user/pin-pad-user.component';
import { GetUsers } from 'src/app/services/auth/get-users';

@Component({
  selector: 'app-admin-selector',
  templateUrl: './admin-selector.component.html',
  styleUrls: ['./admin-selector.component.scss'],
  imports: [IonCard, IonThumbnail, IonCardHeader, IonCardTitle, IonCardContent, RoleFormatterPipe, FilterByRolePipe],
})
export class AdminSelectorComponent  implements OnInit {
  private userService = inject(GetUsers);
  public imageService = inject(ImageFormatter);
  private modalCtrl = inject(ModalController);

  users: IUsers = [];

  constructor() { }

  ngOnInit() {
    this.getUsers();
  }

  getUsers() {
    this.userService.getAll().subscribe({
      next: (response: IUsers) => {
        this.users = [...response];
      },
      error() {
        console.log("No hay usuarios, te jodes")
      }
    })
  }

  async openPinModal(email: string) {
    const modal = await this.modalCtrl.create({
      component: PinPadUserComponent,
      componentProps: {
        email: email
      }
    });

    await modal.present();
  };
}
