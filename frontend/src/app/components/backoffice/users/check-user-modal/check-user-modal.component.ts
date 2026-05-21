import { Component, inject, Input } from '@angular/core';
import { ModalController, IonContent, IonTitle, IonHeader, IonToolbar, IonImg, IonButtons, IonButton, IonThumbnail, IonLabel } from '@ionic/angular/standalone';
import { RoleFormatterPipe } from 'src/app/pipes/role-formatter-pipe';
import { ImageFormatter } from 'src/app/services/helper/image-formatter';

@Component({
  selector: 'app-check-user-modal',
  templateUrl: './check-user-modal.component.html',
  styleUrls: ['./check-user-modal.component.scss'],
  imports: [
    IonContent,
    IonTitle,
    IonHeader,
    IonToolbar,
    IonImg,
    RoleFormatterPipe,
    IonButtons,
    IonButton,
    IonThumbnail,
],
})
export class CheckUserModalComponent {
  private modalCtrl = inject(ModalController);
  public imageService = inject(ImageFormatter);
  @Input()
  user!: any;

  confirm() {
    return this.modalCtrl.dismiss();
  }

  closeModal() {
    this.modalCtrl.dismiss();
  }
}
