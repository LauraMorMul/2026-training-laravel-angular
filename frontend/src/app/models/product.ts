export interface IProduct {
    id: string;
    image_src: string;
    name: string;
    price: number;
    stock: number;
    active: boolean;
    family: {
        uuid: string;
        name: string;
        active: boolean;
    }
    tax: {
        uuid: string;
        name: string;
        percentage: number;
    };
    created_at: string;
    updated_at: string;
}

export type IProducts = IProduct[];