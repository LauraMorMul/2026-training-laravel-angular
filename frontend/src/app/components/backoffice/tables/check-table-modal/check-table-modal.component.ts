import { Component, inject, Input } from '@angular/core';
import { IonContent, IonHeader, IonToolbar, IonTitle, IonButton, IonModal, ModalController, IonButtons } from '@ionic/angular/standalone';

@Component({
  selector: 'app-check-table-modal',
  templateUrl: './check-table-modal.component.html',
  styleUrls: ['./check-table-modal.component.scss'],
  standalone: true,
  imports: [IonContent, IonHeader, IonToolbar, IonTitle, IonButton, IonButtons],
})
export class CheckTableModalComponent {
  @Input() table!: any;
  private modalCtrl = inject(ModalController);

  closeModal(){
    this.modalCtrl.dismiss();
  }
}
