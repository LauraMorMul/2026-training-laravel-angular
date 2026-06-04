import { Component, OnInit } from '@angular/core';
import { IonButton, IonCard } from "@ionic/angular/standalone";

@Component({
  selector: 'app-ticket',
  templateUrl: './ticket.component.html',
  styleUrls: ['./ticket.component.scss'],
  imports: [IonButton, IonCard],
})
export class TicketComponent  implements OnInit {

  ticket: string = '';

  constructor() { }

  ngOnInit() {}

}
