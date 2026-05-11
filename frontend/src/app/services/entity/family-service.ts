import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { IFamilies } from 'src/app/models/family';

@Injectable({
  providedIn: 'root',
})
export class FamilyService extends BaseApiService{
  private families$ = new BehaviorSubject<IFamilies>([]);
    
      getAll(): Observable<IFamilies> {
        if (this.families$.getValue().length === 0) {
          this.loadFamilies();
        }
    
        return this.families$.asObservable();
      }
    
      private loadFamilies(): void {
        this.httpCall('/families/restaurant', null, 'get').subscribe({
          next: (response: ApiResponse) => {
            const families = response as unknown as IFamilies;
            this.families$.next(families);
          },
        });
      }
    
      refreshFamilies(): void {
        this.loadFamilies();
      }
    
      add(formData: FormData): Observable<ApiResponse> {
        return this.httpCall('/families', formData, 'post').pipe(
          tap(() => this.refreshFamilies()),
        );
      }
    
      delete(id: string): Observable<ApiResponse> {
        return this.httpCall(`/families/${id}`, null, 'delete').pipe(
          tap(() => this.refreshFamilies()),
        );
      }
    
      update(id: string, formData: FormData): Observable<ApiResponse> {
        return this.httpCall(`/families/${id}`, formData, 'patch').pipe(
          tap(() => this.refreshFamilies()),
        );
      }
}
