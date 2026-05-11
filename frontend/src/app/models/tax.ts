export interface ITax {
    id: string;
    name: string;
    percentage: number;
    created_at: string;
    updated_at: string;
};

export type ITaxes = ITax[];