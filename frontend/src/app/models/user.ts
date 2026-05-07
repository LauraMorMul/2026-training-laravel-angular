export interface IUser {
  id: string;
  name: string;
  email: string;
  role: string;
  imageSrc: string;
  pin: string;
  createdAt: string;
  updatedAt: string;
}

export type IUsers = IUser[];
