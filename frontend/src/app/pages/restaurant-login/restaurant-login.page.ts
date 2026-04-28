import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import {
  IonContent,
  IonHeader,
  IonTitle,
  IonToolbar,
  IonFooter,
} from '@ionic/angular/standalone';
import { RestaurantLoginFormComponent } from 'src/app/components/login/restaurant-login-form/restaurant-login-form.component';

@Component({
  selector: 'app-restaurant-login',
  templateUrl: './restaurant-login.page.html',
  styleUrls: ['./restaurant-login.page.scss'],
  standalone: true,
  imports: [
    IonContent,
    IonHeader,
    IonTitle,
    IonToolbar,
    CommonModule,
    FormsModule,
    IonFooter,
    RestaurantLoginFormComponent,
  ],
})
export class RestaurantLoginPage {
  constructor() {}
}
