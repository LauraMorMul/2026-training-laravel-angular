import { Component, inject, Input } from '@angular/core';
import {
  IonButton,
  IonButtons,
  IonContent,
  IonHeader,
  IonTitle,
  IonToolbar,
  ModalController,
} from '@ionic/angular/standalone';
import { ITax } from 'src/app/models/tax';

@Component({
  selector: 'app-check-tax-modal',
  templateUrl: './check-tax-modal.component.html',
  styleUrls: ['./check-tax-modal.component.scss'],
  imports: [IonContent, IonTitle, IonHeader, IonToolbar, IonButtons, IonButton],
})
export class CheckTaxModalComponent {
  private modalCtrl = inject(ModalController);

  @Input()
  tax!: ITax;

  confirm() {
    return this.modalCtrl.dismiss();
  }

  closeModal() {
    this.modalCtrl.dismiss();
  }

}
