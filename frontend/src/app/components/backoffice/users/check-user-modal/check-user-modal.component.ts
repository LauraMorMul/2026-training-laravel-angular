import { Component, inject, Input } from '@angular/core';
import {
  ModalController,
  IonContent,
  IonTitle,
  IonHeader,
  IonToolbar,
  IonImg,
} from '@ionic/angular/standalone';
import { ImageFormatterPipePipe } from 'src/app/pipes/image-formatter-pipe-pipe';
import { RoleFormatterPipe } from 'src/app/pipes/role-formatter-pipe';

@Component({
  selector: 'app-check-user-modal',
  templateUrl: './check-user-modal.component.html',
  styleUrls: ['./check-user-modal.component.scss'],
  imports: [IonContent, IonTitle, IonHeader, IonToolbar, IonImg, ImageFormatterPipePipe, RoleFormatterPipe],
})
export class CheckUserModalComponent {
  private modalCtrl = inject(ModalController);
  @Input()
  user!: any;

  confirm() {
    return this.modalCtrl.dismiss();
  }
}
