export interface ITable {
    id: string;
    zone: {
        id: string;
        name: string;
    };
    name: string;
    created_at: string;
    updated_at: string;
    __occupied?: boolean;
};

export type ITables = ITable[];