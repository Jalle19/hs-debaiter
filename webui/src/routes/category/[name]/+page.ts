import type { PageLoad } from './$types';
import { env } from '$env/dynamic/public';

export const load: PageLoad = async ({ fetch, params }) => {
  const response = await fetch(`${env.PUBLIC_API_BASE_URL}/articles/category/${params.name}`);
  const categoryArticles = await response.json();

  const pageTitle = params.name;

  return { categoryArticles, pageTitle };
};
