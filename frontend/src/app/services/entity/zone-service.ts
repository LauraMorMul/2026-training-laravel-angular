import { Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { IZones } from '../../../app/models/zone';

@Injectable({
  providedIn: 'root',
})
export class ZoneService extends BaseApiService {
  private zones$ = new BehaviorSubject<IZones>([]);

  getAll(): Observable<IZones> {
    if (this.zones$.getValue().length === 0) {
      this.loadZones();
    }

    return this.zones$.asObservable();
  }

  private loadZones(): void {
    this.httpCall('/zones/restaurant', null, 'get').subscribe({
      next: (response: ApiResponse) => {
        const zones = response as unknown as IZones;
        this.zones$.next(zones);
      },
    });
  }

  refreshZones(): void {
    this.loadZones();
  }

  add(formData: FormData): Observable<ApiResponse> {
    return this.httpCall('/zones', formData, 'post').pipe(
      tap(() => this.refreshZones()),
    );
  }

  delete(id: string): Observable<ApiResponse> {
    return this.httpCall(`/zones/${id}`, null, 'delete').pipe(
      tap(() => this.refreshZones()),
    );
  }

  update(id: string, formData: FormData): Observable<ApiResponse> {
    return this.httpCall(`/zones/${id}`, formData, 'patch').pipe(
      tap(() => this.refreshZones()),
    );
  }
}
