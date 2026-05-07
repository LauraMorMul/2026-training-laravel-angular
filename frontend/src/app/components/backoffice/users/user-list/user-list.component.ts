import { Component, inject, OnInit, ViewChild } from '@angular/core';
import {
  IonCard,
  IonCardHeader,
  IonCardTitle,
  IonCardContent,
  IonItem,
  IonList,
  IonAvatar,
  IonLabel,
  IonButton,
  AlertController,
  ToastController,
  ModalController,
  IonSearchbar,
} from '@ionic/angular/standalone';
import { ImageFormatterPipePipe } from 'src/app/pipes/image-formatter-pipe-pipe';
import { UserService } from 'src/app/services/entity/user-service';
import { CheckUserModalComponent } from '../check-user-modal/check-user-modal.component';
import { RoleFormatterPipe } from 'src/app/pipes/role-formatter-pipe';
import { ModifyUserModalComponent } from '../modify-user-modal/modify-user-modal.component';

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
    IonLabel,
    IonButton,
    ImageFormatterPipePipe,
    RoleFormatterPipe,
    IonSearchbar
  ],
})
export class UserListComponent implements OnInit {
  private userService = inject(UserService);
  private alertController = inject(AlertController);
  private toastController = inject(ToastController);
  private modalCtrl = inject(ModalController);

  users: any[] = [];
  results = [...this.users];
  userID: string | null = '';

  ngOnInit() {
    this.userService.getAll().subscribe({
        next: (users) => {
            this.users = users;
            this.results = users;
        }
    });
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
      next: (response: any) => {
        this.users = [...response];
      },
      error(err) {
        console.log('Ni de coña jeje');
      },
    });
  };

  handleInput(event: Event) {
    const target = event.target as HTMLIonSearchbarElement;
    const query = target.value?.toLowerCase() || '';
    this.results = this.users.filter((d) => d.name.toLowerCase().includes(query));
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
        this.users = this.users.filter((user) => user.id !== id);
        this.getUsers();
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
    });
    modal.present();
  }
}
