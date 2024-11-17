export interface Genre {
  id: number;
  name: string;
  created_at: string;
  updated_at: string;
  pivot?: {
    media_id: number;
    genre_id: number;
  };
}

interface Comment {
  id: number;
  content: string;
  likes: number;
  created_at: string;
  user: {
    id: number;
    name: string;
    profile_pic: string;
  };
}


export interface CastMember {
  id: string;
  movie_id: number;
  name: string;
  original_name: string;
  popularity: string;
  profile_path: string;
  character: string;
  created_at: string | null;
  updated_at: string | null;
}

export interface MediaProps {
  id: number;
  type: string;
  title: string;
  overview: string;
  popularity: number;
  image?: string;
  latest_comments?: Comment[];
  vote_average: number;
  vote_count: number;
  cast: CastMember[];
  created_at: string;
  updated_at: string;
  genres?: Genre[];
}
