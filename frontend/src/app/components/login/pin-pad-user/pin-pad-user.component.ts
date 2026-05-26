import { Component, EventEmitter, inject, Input, Output } from '@angular/core';
import { Router } from '@angular/router';
import {
  IonHeader,
  IonContent,
  IonToolbar,
  IonTitle,
  IonButton,
  ModalController,
  ToastController,
  LoadingController,
} from '@ionic/angular/standalone';
import { AuthService } from 'src/app/services/auth/auth-service';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';

@Component({
  selector: 'app-pin-pad-user',
  templateUrl: './pin-pad-user.component.html',
  styleUrls: ['./pin-pad-user.component.scss'],
  imports: [IonHeader, IonContent, IonToolbar, IonTitle, IonButton],
})
export class PinPadUserComponent {
  @Input() email!: string;
  @Input() tableId!: string;
  @Output() success = new EventEmitter<string>();
  @Output() back = new EventEmitter<void>();
  private modalCtrl = inject(ModalController);
  private loadingController = inject(LoadingController);
  private toastController = inject(ToastController);
  private authService = inject(AuthService);
  private localService = inject(LocalStorageService);
  private router = inject(Router);

  origin: string | undefined;
  pin: string = '';

  handleInput(pin: string) {
    if (pin === 'clear') {
      this.pin = '';
      return;
    }

    if (pin === '<-' || pin === 'x') {
      if (pin === '<-') {
        this.pin = this.pin.slice(0, -1);
      } else {
        this.modalCtrl.dismiss();
      }
    } else {
      this.pin += pin;
    }

    if (this.pin.length === 4) {
      this.pinLogin(this.email, this.pin);

      return;
    }
  }

  async pinLogin(email: string, pin: string) {
    const loading = await this.loadingController.create({
      message: 'Iniciando sesión',
    });
    const toast = await this.toastController.create({
      message: 'Wrong credentials.',
      duration: 1500,
      position: 'middle',
      color: 'danger',
    });
    loading.present();
    this.authService.loginPin(email, pin).subscribe({
      next: (response: any) => {
        loading.remove();
        this.localService.setUserToken(response.token);
        this.localService.setUserName(response.user.name);
        this.localService.setUserImg(response.user.imageSrc);
        this.modalCtrl.dismiss({ success: true, role: response.user.role, tableId: this.tableId });
      },
      error: (err) => {
        toast.present();
        loading.remove();
        this.pin = '';
      },
    });
  }
}
