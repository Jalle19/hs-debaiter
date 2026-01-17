type ArticleTitle = {
  title: string;
  created_at: Date;
};

type ArticleTestTitle = {
  title: string;
};

export type Article = {
  guid: string;
  created_at: Date;
  title: string;
  num_titles: number;
  image_url?: string;
  url: string;
  article_titles: ArticleTitle[];
  num_test_titles: number;
  article_test_titles: ArticleTestTitle[];
};

export type Category = {
  name: string;
};

export type SearchQuery = string | null;
