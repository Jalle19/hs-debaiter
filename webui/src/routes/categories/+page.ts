import type { PageLoad } from './$types';
import { PUBLIC_API_BASE_URL } from '$env/static/public';
import type { Category } from '$lib/types';

export const load: PageLoad = async ({ fetch }) => {
  const response = await fetch(`${PUBLIC_API_BASE_URL}/categories`);
  const categories = (await response.json()) as Category[];

  const pageTitle = 'Categories';

  return { categories, pageTitle };
};
