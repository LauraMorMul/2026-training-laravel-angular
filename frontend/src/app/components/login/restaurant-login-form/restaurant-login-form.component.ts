import { Component, inject } from '@angular/core';
import {
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  Validators,
} from '@angular/forms';
import { Router } from '@angular/router';
import { LoadingController } from '@ionic/angular';
import {
  IonInput,
  IonInputPasswordToggle,
  IonButton,
  IonCard,
  IonCardContent,
  IonCardTitle,
  ToastController,
} from '@ionic/angular/standalone';
import { AuthService } from 'src/app/services/auth/auth-service';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';

@Component({
  selector: 'app-restaurant-login-form',
  templateUrl: './restaurant-login-form.component.html',
  styleUrls: ['./restaurant-login-form.component.scss'],
  imports: [
    IonInput,
    IonInputPasswordToggle,
    IonButton,
    ReactiveFormsModule,
    IonCard,
    IonCardContent,
    IonCardTitle,
  ],
})
export class RestaurantLoginFormComponent {
  private authService = inject(AuthService);
  private localService = inject(LocalStorageService);
  private router = inject(Router);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);

  formulario = new FormGroup({
    email: new FormControl('', Validators.required),
    password: new FormControl('', Validators.required),
  });

  respuesta: any | null;

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
        .context(this.formulario.value.email!, this.formulario.value.password!)
        .subscribe({
          next: (response: any) => {
            console.log(JSON.stringify(response));
            loading.remove();
            this.localService.setRestaurantToken(response.token);
            this.localService.setRestName(response.restaurant.name);
            this.router.navigate(['/login']);
          },
          error: (err) => {
            toast.present();
            console.log(JSON.stringify(err));
            loading.remove();
          },
        });
    }
  }
}
