type ArticleTitle = {
  title: string;
  created_at: Date;
};

export type Article = {
  guid: string;
  created_at: Date;
  title: string;
  num_titles: number;
  image_url?: string;
  url: string;
  article_titles: ArticleTitle[];
};

export type Category = {
  name: string;
};
