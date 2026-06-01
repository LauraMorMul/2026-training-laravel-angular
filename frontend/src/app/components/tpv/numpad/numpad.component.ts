import { Component, inject } from '@angular/core';
import {
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonButton,
  ModalController,
} from '@ionic/angular/standalone';

@Component({
  selector: 'app-numpad',
  templateUrl: './numpad.component.html',
  styleUrls: ['./numpad.component.scss'],
  imports: [IonHeader, IonToolbar, IonTitle, IonContent, IonButton],
})
export class NumpadComponent {
  private modalCtrl = inject(ModalController);
  diners: string = '';
  tableId: string = '';

  handleInput(number: string) {
    if (number === '<-' || number === '✓') {
      if (number === '<-') {
        this.diners = this.diners.slice(0, -1);
      } else {
        this.modalCtrl.dismiss({
          success: true,
          diners: parseInt(this.diners) || 0,
          tableId: this.tableId,
        });
      }
    } else {
      this.diners += number;
    }
  }
}
