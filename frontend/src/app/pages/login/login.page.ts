import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonContent } from '@ionic/angular/standalone';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';
import { UserLoginFormComponent } from 'src/app/components/login/user-login-form/user-login-form.component';
import { AuthService } from 'src/app/services/auth/auth-service';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
  standalone: true,
  imports: [IonContent, CommonModule, FormsModule, UserLoginFormComponent],
})
export class LoginPage implements OnInit {
  private local = inject(LocalStorageService);
  private authService = inject(AuthService);

  restaurantName = 'Laura';

  ionViewWillEnter() {
    if (this.local.getUserToken() === null) {
      console.log('No token');
    } else {
      this.authService.logout().subscribe({
        next: (response: any) => {
          console.log('Logout correcto');
        },
        error: (err) => {
          console.log('Error');
        },
      });
      this.local.removeUserToken();
    }
  }

  ngOnInit(): void {
    this.restaurantName = this.local.getRestName() ?? 'Restaurante';
  }
}
