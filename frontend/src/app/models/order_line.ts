export interface IOrderLine {
    id?: string,
    order_id?: string,
    product_id: string,
    product_name?: string,
    user_id?: string,
    quantity: number,
    price: number,
    percentage?: number
}

export type IOrderLines = IOrderLine[];