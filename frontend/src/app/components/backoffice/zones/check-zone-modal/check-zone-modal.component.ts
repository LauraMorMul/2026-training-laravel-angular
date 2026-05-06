import { Component, Input, inject } from '@angular/core';
import { IonContent, IonHeader, IonToolbar, IonTitle, IonButton, ModalController } from '@ionic/angular/standalone';

@Component({
  selector: 'app-check-zone-modal',
  templateUrl: './check-zone-modal.component.html',
  styleUrls: ['./check-zone-modal.component.scss'],
  standalone: true,
  imports: [IonContent, IonHeader, IonToolbar, IonTitle, IonButton],
})
export class CheckZoneModalComponent {
  @Input() zone!: any;

  private modalController = inject(ModalController);

  closeModal() {
    this.modalController.dismiss();
  }
}
