import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { IonHeader, IonTitle, IonToolbar, IonButtons, IonButton } from "@ionic/angular/standalone";

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss'],
  imports: [IonHeader, IonToolbar, IonTitle, IonButtons, IonButton, RouterLink],
})
export class HeaderComponent {

  constructor() { }

}
