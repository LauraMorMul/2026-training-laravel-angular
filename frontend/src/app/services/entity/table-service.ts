import { Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { ITables } from 'src/app/models/table';
import { BehaviorSubject, Observable, tap } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class TableService extends BaseApiService{
  private tables$ = new BehaviorSubject<ITables>([]);
  
    getAll(): Observable<ITables> {
      if (this.tables$.getValue().length === 0) {
        this.loadZones();
      }
  
      return this.tables$.asObservable();
    }
  
    private loadZones(): void {
      this.httpCall('/tables/restaurant', null, 'get').subscribe({
        next: (response: ApiResponse) => {
          const tables = response as unknown as ITables;
          this.tables$.next(tables);
        },
      });
    }
  
    refreshZones(): void {
      this.loadZones();
    }
  
    add(formData: FormData): Observable<ApiResponse> {
      return this.httpCall('/tables', formData, 'post').pipe(
        tap(() => this.refreshZones()),
      );
    }
  
    delete(id: string): Observable<ApiResponse> {
      return this.httpCall(`/tables/${id}`, null, 'delete').pipe(
        tap(() => this.refreshZones()),
      );
    }
  
    update(id: string, formData: FormData): Observable<ApiResponse> {
      return this.httpCall(`/tables/${id}`, formData, 'patch').pipe(
        tap(() => this.refreshZones()),
      );
    }
}
