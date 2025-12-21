import type { PageLoad } from './$types';
import { env } from '$env/dynamic/public';
import type { Category } from '$lib/types';

export const load: PageLoad = async ({ fetch }) => {
  const response = await fetch(`${env.PUBLIC_API_BASE_URL}/categories`);
  const categories = (await response.json()) as Category[];

  const pageTitle = 'Categories';

  return { categories, pageTitle };
};
