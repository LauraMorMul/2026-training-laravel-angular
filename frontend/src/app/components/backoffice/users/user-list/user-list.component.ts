import { Component, inject, OnInit } from '@angular/core';
import { IonCard, IonCardHeader, IonCardTitle, IonCardContent, IonButton, AlertController, ToastController, ModalController, IonSearchbar, IonSelect, IonSelectOption, IonGrid, IonCol, IonRow, IonIcon, IonThumbnail } from '@ionic/angular/standalone';
import { UserService } from 'src/app/services/HTTPRequests/user-service';
import { CheckUserModalComponent } from '../check-user-modal/check-user-modal.component';
import { RoleFormatterPipe } from 'src/app/pipes/role-formatter-pipe';
import { ModifyUserModalComponent } from '../modify-user-modal/modify-user-modal.component';
import { IUsers } from 'src/app/models/user';
import { addIcons } from 'ionicons';
import { createOutline, eyeOutline, trashOutline } from 'ionicons/icons';
import { ImageFormatter } from 'src/app/services/helper/image-formatter';
import { FilterBySearchBarPipe } from 'src/app/pipes/shared/filter-by-search-bar-pipe';
import { FormsModule } from '@angular/forms';
import { FilterByRolePipe } from 'src/app/pipes/user/filter-by-role-pipe';

@Component({
  selector: 'app-user-list',
  templateUrl: './user-list.component.html',
  styleUrls: ['./user-list.component.scss'],
  imports: [
    IonCard,
    IonCardHeader,
    IonCardTitle,
    IonCardContent,
    IonButton,
    RoleFormatterPipe,
    IonSearchbar,
    IonSelect,
    IonSelectOption,
    IonGrid,
    IonRow,
    IonCol,
    IonIcon,
    FilterBySearchBarPipe,
    FormsModule,
    FilterByRolePipe,
    IonThumbnail
],
})
export class UserListComponent implements OnInit {
  private userService = inject(UserService);
  private alertController = inject(AlertController);
  private toastController = inject(ToastController);
  private modalCtrl = inject(ModalController);
  public imageService = inject(ImageFormatter);

  users: IUsers = [];
  userID: string | null = '';
  nameFilter: string | undefined = undefined;
  selectedRole: string | undefined = undefined;

  constructor() {
    addIcons({ trashOutline, createOutline, eyeOutline });
  }

  ngOnInit() {
    this.getUsers();
  }

  public actionButtons = [
    {
      text: 'Cancel',
      role: 'cancel',
      handler: () => {
        console.log('Alert confirmed');
      },
    },
    {
      text: 'OK',
      role: 'confirm',
      handler: () => {
        this.deleteUser(this.userID!);
      },
    },
  ];

  getUsers() {
    this.userService.getAll().subscribe({
      next: (response: IUsers) => {
        this.users = [...response];
      },
      error(err) {
        console.log('Ni de coña jeje');
      },
    });
  }

  async showDeleteAlert(id: string, name: string) {
    const alert = await this.alertController.create({
      header: 'Eliminar usuario',
      subHeader: 'Esta acción es irreversible.',
      message: '¿Eliminar al usuario ' + name + '?',
      buttons: this.actionButtons,
    });

    await alert.present();

    this.userID = id;
  }

  async abrirModalModificar(selectedUser: object) {
    const modal = await this.modalCtrl.create({
      component: ModifyUserModalComponent,
      componentProps: {
        user: selectedUser,
      },
      cssClass: "modal-modify__user",
    });

    await modal.present();

    const { data } = await modal.onDidDismiss();

    if (data?.updated) {
      this.getUsers();
    }
  }

  async deleteUser(id: string) {
    const toast = await this.toastController.create({
      duration: 1500,
      position: 'bottom',
    });
    this.userService.delete(id).subscribe({
      next: (response: any) => {
        toast.message = 'Usuario eliminado correctamente.';
        toast.color = 'success';
        toast.present();
      },
      error(err) {
        toast.message = 'Ha habido un error.';
        toast.color = 'danger';
        toast.present();
      },
    });
  }

  async abrirModalUsuario(selectedUser: any) {
    const modal = await this.modalCtrl.create({
      component: CheckUserModalComponent,
      componentProps: {
        user: selectedUser,
      },
      cssClass: "modal-check__user",
    });
    modal.present();
  }
}
