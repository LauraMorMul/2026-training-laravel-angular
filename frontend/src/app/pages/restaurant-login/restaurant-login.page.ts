import { Component, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { AuthService } from 'src/app/services/auth/auth-service';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';
import { Router } from '@angular/router';
import { LoadingController, ToastController, IonContent, IonCard, IonCardTitle, IonCardContent, IonInput, IonInputPasswordToggle, IonButton } from '@ionic/angular/standalone';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';

@Component({
  selector: 'app-restaurant-login',
  templateUrl: './restaurant-login.page.html',
  styleUrls: ['./restaurant-login.page.scss'],
  standalone: true,
  imports: [
    CommonModule,
    IonContent,
    IonCard,
    IonCardTitle,
    IonCardContent,
    IonInput,
    IonInputPasswordToggle,
    IonButton,
    ReactiveFormsModule
],
})
export class RestaurantLoginPage implements OnInit{
  private authService = inject(AuthService);
  private localService = inject(LocalStorageService);
  private router = inject(Router);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);

  formulario = new FormGroup({
    email: new FormControl('', Validators.required),
    password: new FormControl('', Validators.required),
  });

  ngOnInit(): void {
    if(this.localService.isThereRestToken()) {
      this.router.navigate(['/login']);
    }
  }

  respuesta: any | null;

  async login() {
    if (this.formulario.invalid) {
      this.formulario.markAllAsTouched();
      return;
    } else {
      const loading = await this.loadingController.create({
        message: 'Accediendo al restaurante.',
      });
      const toast = await this.toastController.create({
        message: 'Credenciales incorrectas.',
        duration: 1500,
        position: 'middle',
        color: 'danger',
      });
      loading.present();
      this.authService
        .context(this.formulario.value.email!, this.formulario.value.password!)
        .subscribe({
          next: (response: any) => {
            loading.remove();
            this.localService.setRestaurantToken(response.token);
            this.localService.setRestaurant(response.restaurant);
            this.router.navigate(['/login']);
          },
          error: (err) => {
            toast.present();
            loading.remove();
          },
        });
    }
  }
}
