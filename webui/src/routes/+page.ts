import type { PageLoad } from './$types';
import { PUBLIC_API_BASE_URL } from '$env/static/public';

export const load: PageLoad = async ({ fetch }) => {
  // Fetch articles
  let response = await fetch(`${PUBLIC_API_BASE_URL}/articles`);
  const articles = await response.json();

  // Fetch frequently changed articles
  response = await fetch(`${PUBLIC_API_BASE_URL}/articles/frequently-changed`);
  const frequentlyChangedArticles = await response.json();

  return { articles, frequentlyChangedArticles };
};
