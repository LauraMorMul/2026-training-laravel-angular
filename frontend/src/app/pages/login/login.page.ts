import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import {
  IonContent,
  IonHeader,
  IonTitle,
  IonToolbar,
  IonFooter,
} from '@ionic/angular/standalone';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';
import { UserLoginFormComponent } from 'src/app/components/login/user-login-form/user-login-form.component';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
  standalone: true,
  imports: [
    IonContent,
    IonHeader,
    IonTitle,
    IonToolbar,
    CommonModule,
    FormsModule,
    IonFooter,
    UserLoginFormComponent,
  ],
})
export class LoginPage implements OnInit {
  private local = inject(LocalStorageService);

  restaurantName = 'Laura';

  ngOnInit() {
    this.restaurantName =
      this.local.getItem('restaurant_name') ?? 'Restaurante';
  }
}
