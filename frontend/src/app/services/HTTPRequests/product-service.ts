import { Injectable } from '@angular/core';
import { ApiResponse, BaseApiService } from '../api/base-api.service';
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { IProducts } from 'src/app/models/product';

@Injectable({
  providedIn: 'root',
})
export class ProductService extends BaseApiService{
  private products$ = new BehaviorSubject<IProducts>([]);
  
    getAll(): Observable<IProducts> {
      if (this.products$.getValue().length === 0) {
        this.loadProducts();
      }
  
      return this.products$.asObservable();
    }
  
    private loadProducts(): void {
      this.httpCall('/products/restaurant', null, 'get').subscribe({
        next: (response: any) => {
          const products = response as unknown as IProducts;
          this.products$.next(products);
        },
      });
    }
  
    refreshProducts(): void {
      this.loadProducts();
    }
  
    add(formData: FormData): Observable<ApiResponse> {
      return this.httpCall('/products', formData, 'post').pipe(
        tap(() => this.refreshProducts()),
      );
    }
  
    delete(id: string): Observable<ApiResponse> {
      return this.httpCall(`/products/${id}`, null, 'delete').pipe(
        tap(() => this.refreshProducts()),
      );
    }
  
    update(id: string, formData: FormData): Observable<ApiResponse> {
      return this.httpCall(`/products/${id}`, formData, 'patch').pipe(
        tap(() => this.refreshProducts()),
      );
    }
}
