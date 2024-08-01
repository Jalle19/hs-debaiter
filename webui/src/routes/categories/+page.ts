import type { PageLoad } from './$types';
import { PUBLIC_API_BASE_URL } from '$env/static/public';

export const load: PageLoad = async ({ fetch }) => {
  const response = await fetch(`${PUBLIC_API_BASE_URL}/categories`);
  const categories = await response.json();

  return { categories };
};
