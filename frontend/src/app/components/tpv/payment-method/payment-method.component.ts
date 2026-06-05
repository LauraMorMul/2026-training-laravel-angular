import { Component, inject } from '@angular/core';
import { IOrder } from 'src/app/models/order';
import { IonButton, ModalController } from '@ionic/angular/standalone';
import { SaleManagerService } from 'src/app/services/tpv/sale-manager-service';
import { TicketGeneratorService } from 'src/app/services/ticket/ticket-generator-service';
import { ISale } from 'src/app/models/sale';
import { TicketComponent } from '../ticket/ticket.component';

@Component({
  selector: 'app-payment-method',
  templateUrl: './payment-method.component.html',
  styleUrls: ['./payment-method.component.scss'],
  imports: [IonButton],
})
export class PaymentMethodComponent {
  private modalCtrl = inject(ModalController);
  ticket: string | undefined;

  async showTicket() {
    const modal = await this.modalCtrl.create({
      component: TicketComponent,
      componentProps: { ticket: this.ticket },
    });
    await modal.present();
  }
}
