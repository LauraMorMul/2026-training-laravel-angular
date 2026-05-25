export interface IOrder {
    id: string,
    status: string,
    table_id: string,
    opened_by_user_id : string,
    closed_by_user_id: string,
    diners: number,
    opened_at: string,
    closed_at: string
}