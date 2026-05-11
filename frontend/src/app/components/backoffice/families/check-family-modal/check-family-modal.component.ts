import { Component, inject, Input } from '@angular/core';
import {
  IonContent,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonButtons,
  IonButton,
  ModalController,
} from '@ionic/angular/standalone';
import { IFamily } from 'src/app/models/family';

@Component({
  selector: 'app-check-family-modal',
  templateUrl: './check-family-modal.component.html',
  styleUrls: ['./check-family-modal.component.scss'],
  imports: [IonContent, IonHeader, IonToolbar, IonTitle, IonButtons, IonButton],
})
export class CheckFamilyModalComponent {
  private modalCtrl = inject(ModalController);

  @Input()
  family!: IFamily;

  closeModal() {
    this.modalCtrl.dismiss();
  }
}

