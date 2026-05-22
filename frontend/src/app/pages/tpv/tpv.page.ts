import { Component, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import {
  IonContent,
  IonHeader,
  IonTitle,
  IonToolbar,
  IonButtons,
  IonButton,
  IonChip,
  IonAvatar,
  IonLabel,
} from '@ionic/angular/standalone';
import { Router, RouterLink, RouterOutlet } from '@angular/router';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';
import { AuthService } from 'src/app/services/auth/auth-service';
import { ImageFormatter } from 'src/app/services/helper/image-formatter';

@Component({
  selector: 'app-tpv',
  templateUrl: './tpv.page.html',
  styleUrls: ['./tpv.page.scss'],
  standalone: true,
  imports: [
    IonContent,
    IonHeader,
    IonTitle,
    IonToolbar,
    CommonModule,
    FormsModule,
    IonButtons,
    IonButton,
    RouterOutlet,
    RouterLink,
    IonChip,
    IonAvatar,
    IonLabel,
  ],
})
export class TpvPage implements OnInit {
  private localService = inject(LocalStorageService);
  private authService = inject(AuthService);
  private router = inject(Router);
  public imageService = inject(ImageFormatter);
  userName: string | null = null;
  userImg: string | null = null;

  ngOnInit() {
    this.localService.removeUserToken();
    this.userName = this.localService.getUserName();
    this.userImg = this.localService.getUserImg();
    if (this.userImg === null) {
      this.userImg = '';
    }
  }

  cerrarSesion() {
    this.userName = null;
    this.userImg = null;
    this.router.navigate(['/tpv/tables']);
    if (this.localService.isThereUserToken()) {
      this.authService.logout().subscribe({
        next: (response: any) => {
          this.localService.removeUserToken();
          
        },
      });
    }
  }
}
