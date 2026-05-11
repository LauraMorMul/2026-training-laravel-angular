import { Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { ITaxes } from 'src/app/models/tax';

@Injectable({
  providedIn: 'root',
})
export class TaxService extends BaseApiService{
  private taxes$ = new BehaviorSubject<ITaxes>([]);
    
      getAll(): Observable<ITaxes> {
        if (this.taxes$.getValue().length === 0) {
          this.loadTaxes();
        }
    
        return this.taxes$.asObservable();
      }
    
      private loadTaxes(): void {
        this.httpCall('/taxes/restaurant', null, 'get').subscribe({
          next: (response: ApiResponse) => {
            const taxes = response as unknown as ITaxes;
            this.taxes$.next(taxes);
          },
        });
      }
    
      refreshTaxes(): void {
        this.loadTaxes();
      }
    
      add(formData: FormData): Observable<ApiResponse> {
        return this.httpCall('/taxes', formData, 'post').pipe(
          tap(() => this.refreshTaxes()),
        );
      }
    
      delete(id: string): Observable<ApiResponse> {
        return this.httpCall(`/taxes/${id}`, null, 'delete').pipe(
          tap(() => this.refreshTaxes()),
        );
      }
    
      update(id: string, formData: FormData): Observable<ApiResponse> {
        return this.httpCall(`/taxes/${id}`, formData, 'patch').pipe(
          tap(() => this.refreshTaxes()),
        );
      }
}
