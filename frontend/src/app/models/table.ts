export interface ITable {
    id: string;
    zone: {
        id: string;
        name: string;
    };
    name: string;
    created_at: string;
    updated_at: string
};

export type ITables = ITable[];