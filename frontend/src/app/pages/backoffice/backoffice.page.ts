import { Component, inject, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { IonContent } from '@ionic/angular/standalone';
import { HeaderComponent } from "src/app/components/backoffice/shared/header/header.component";
import { Router, RouterOutlet } from '@angular/router';
import { LocalStorageService } from 'src/app/services/storage/local-storage-service';

@Component({
  selector: 'app-backoffice',
  templateUrl: './backoffice.page.html',
  styleUrls: ['./backoffice.page.scss'],
  standalone: true,
  imports: [IonContent, CommonModule, FormsModule, HeaderComponent, RouterOutlet]
})
export class BackofficePage implements OnInit {
  private localService = inject(LocalStorageService);
  private router = inject(Router);
  constructor() { }

  ngOnInit() {
    console.log('Iniciado backoffice');
  }

  ionViewWillEnter() {
    if(this.localService.getUserToken() === null) {
      this.router.navigate(['/login']);
    }
  }
}
