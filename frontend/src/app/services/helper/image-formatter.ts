import { Injectable } from '@angular/core';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class ImageFormatter {
  formatImageSrc(value: string | null | undefined): string {
    if(!value || value === 'null') return "https://ionicframework.com/docs/img/demos/avatar.svg";
        return `${environment.apiUrl.replace('/api', '')}/storage/${value}`;
  }
}
