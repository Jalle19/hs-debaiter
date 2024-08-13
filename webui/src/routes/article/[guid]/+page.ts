import type { PageLoad } from './$types';
import { PUBLIC_API_BASE_URL } from '$env/static/public';
import type { Article } from '$lib/types';

export const load: PageLoad = async ({ fetch, params }) => {
  const response = await fetch(`${PUBLIC_API_BASE_URL}/article/${params.guid}`);
  const article = (await response.json()) as Article;

  const pageTitle = article.title;

  return { article, pageTitle };
};
