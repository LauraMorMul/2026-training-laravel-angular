export interface IZone {
  id: string | null;
  restaurant_id: number;
  name: string;
  created_at: string | null;
  updated_at: string | null;
  deleted_at: string | null;
}

export type IZones = IZone[];
