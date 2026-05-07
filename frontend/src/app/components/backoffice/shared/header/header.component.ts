import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';
import { IonHeader, IonTitle, IonToolbar, IonButtons, IonButton, IonIcon } from "@ionic/angular/standalone";
import { addIcons } from 'ionicons';
import { peopleOutline, mapOutline, squareOutline, pricetagsOutline, fastFoodOutline, gridOutline } from 'ionicons/icons';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss'],
  imports: [IonHeader, IonToolbar, IonTitle, IonButtons, IonButton, RouterLink, IonIcon],
})
export class HeaderComponent {

  constructor() {
    addIcons({ peopleOutline, mapOutline, squareOutline, pricetagsOutline, fastFoodOutline, gridOutline });
  }

}
