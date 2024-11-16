export interface Category {
  id: number;
  name: string;
  created_at: string;
  updated_at: string;
  pivot?: {
    movie_id: number;
    category_id: number;
  };
}

export interface MediaProps {
  id: number;
  title: string;
  description: string;
  release_date: string;
  image?: string;
  categories?: Category[];
  created_at?: string;
  updated_at?: string;
}
