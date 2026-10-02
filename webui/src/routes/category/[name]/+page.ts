import type { PageLoad } from './$types';
import { env } from '$env/dynamic/public';
import { DEFAULT_OG, getPageTitle } from '$lib/seo';

export const load: PageLoad = async ({ fetch, params }) => {
  const response = await fetch(`${env.PUBLIC_API_BASE_URL}/articles/category/${params.name}`);
  const categoryArticles = await response.json();

  const pageTitle = params.name;

  const og = {
    ...DEFAULT_OG,
    title: getPageTitle(pageTitle)
  };

  return { categoryArticles, pageTitle, og };
};
