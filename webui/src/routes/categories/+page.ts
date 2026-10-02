import type { PageLoad } from './$types';
import { env } from '$env/dynamic/public';
import type { Category } from '$lib/types';
import { DEFAULT_OG, getPageTitle } from '$lib/seo';

export const load: PageLoad = async ({ fetch }) => {
  const response = await fetch(`${env.PUBLIC_API_BASE_URL}/categories`);
  const categories = (await response.json()) as Category[];

  const pageTitle = 'Categories';

  const og = {
    ...DEFAULT_OG,
    title: getPageTitle(pageTitle)
  };

  return { categories, pageTitle, og };
};
