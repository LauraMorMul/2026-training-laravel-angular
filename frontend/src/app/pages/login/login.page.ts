import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { IonButton, IonCard, IonCardContent, IonCardTitle, IonContent, IonInput, IonInputPasswordToggle, LoadingController, ToastController } from '@ionic/angular/standalone';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';
import { AuthService } from 'src/app/services/auth/auth-service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
  standalone: true,
  imports: [IonContent, CommonModule, FormsModule, IonInput,
    IonInputPasswordToggle,
    IonButton,
    ReactiveFormsModule,
    IonCard,
    IonCardContent,
    IonCardTitle,],
})
export class LoginPage implements OnInit {
  private authService = inject(AuthService);
  private localService = inject(LocalStorageService);
  private router = inject(Router);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);

  restaurantName = 'Laura';

  formulario = new FormGroup({
    email: new FormControl('', Validators.required),
    password: new FormControl('', Validators.required),
  });

  ionViewWillEnter() {
    if (this.localService.getUserToken() === null) {
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
      this.localService.removeUserToken();
    }
  }

  ngOnInit(): void {
    this.restaurantName = this.localService.getRestName() ?? 'Restaurante';
  }

  async login() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    } else {
      const loading = await this.loadingController.create({
        message: 'Accessing the restaurant.',
      });
      const toast = await this.toastController.create({
        message: 'Wrong credentials.',
        duration: 1500,
        position: 'middle',
        color: 'danger',
      });
      loading.present();
      this.authService
        .login(this.formulario.value.email!, this.formulario.value.password!)
        .subscribe({
          next: (response: any) => {
            loading.remove();
            this.localService.setUserToken(response.token);
            this.localService.setUserName(response.user.name);
            if (response.user.role === 'admin') {
              this.router.navigate(['/backoffice']);
            } else {
              this.router.navigate(['/tpv']);
            }
          },
          error: (err) => {
            toast.present();
            loading.remove();
          },
        });
    }
  }
}
