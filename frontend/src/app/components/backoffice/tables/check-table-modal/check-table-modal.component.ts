import { Component, Input, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { IonContent, IonHeader, IonToolbar, IonTitle, IonButton } from '@ionic/angular/standalone';

@Component({
  selector: 'app-check-table-modal',
  templateUrl: './check-table-modal.component.html',
  styleUrls: ['./check-table-modal.component.scss'],
  standalone: true,
  imports: [IonContent, IonHeader, IonToolbar, IonTitle, IonButton],
})
export class CheckTableModalComponent implements OnInit {
  @Input() table!: any;

  constructor(private modalController: ModalController) {}

  ngOnInit(): void {}

  closeModal() {
    this.modalController.dismiss();
  }
}
