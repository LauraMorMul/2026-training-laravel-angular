import { Pipe, PipeTransform } from '@angular/core';
import { environment } from 'src/environments/environment';

@Pipe({
  name: 'imageFormatterPipe'
})
export class ImageFormatterPipePipe implements PipeTransform {

  transform(value: string | null | undefined): string {
    if(!value) return "https://ionicframework.com/docs/img/demos/avatar.svg";
    return `${environment.apiUrl.replace('/api', '')}/storage/${value}`;
  }
}
