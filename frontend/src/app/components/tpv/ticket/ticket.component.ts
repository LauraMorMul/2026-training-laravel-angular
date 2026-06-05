import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';
import { IonButton, IonCard, ModalController } from "@ionic/angular/standalone";

@Component({
  selector: 'app-ticket',
  templateUrl: './ticket.component.html',
  styleUrls: ['./ticket.component.scss'],
  imports: [IonButton, IonCard],
})
export class TicketComponent {
  private router = inject(Router);
  private modalCrtl = inject(ModalController);

  ticket: string = '';

  printAndLeave() {
    this.router.navigate(['/tpv/tables']);
    this.modalCrtl.dismiss();
  }
}
