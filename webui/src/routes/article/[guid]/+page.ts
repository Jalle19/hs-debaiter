import type { PageLoad } from './$types';
import { env } from '$env/dynamic/public';
import type { Article } from '$lib/types';
import { DEFAULT_OG, getPageTitle } from '$lib/seo';

export const load: PageLoad = async ({ fetch, params }) => {
  const response = await fetch(`${env.PUBLIC_API_BASE_URL}/article/${params.guid}`);
  const article = (await response.json()) as Article;

  const pageTitle = article.title;

  const og = {
    ...DEFAULT_OG,
    title: getPageTitle(pageTitle),
    image: article.image_url ?? DEFAULT_OG.image,
    description: `The article title has been changed ${article.article_titles.length - 1} times`
  };

  return { article, pageTitle, og };
};
