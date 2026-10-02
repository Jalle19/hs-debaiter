import type { PageLoad } from './$types';
import { env } from '$env/dynamic/public';
import { DEFAULT_OG } from '$lib/seo';

export const load: PageLoad = async ({ fetch }) => {
  // Fetch articles
  let response = await fetch(`${env.PUBLIC_API_BASE_URL}/articles/todays-changed`);
  const todaysChangedArticles = await response.json();

  // Fetch frequently changed articles
  response = await fetch(`${env.PUBLIC_API_BASE_URL}/articles/frequently-changed`);
  const frequentlyChangedArticles = await response.json();

  const tagLine = 'See beyond the veil and expose the true agenda';

  const og = {
    ...DEFAULT_OG,
    description: tagLine
  };

  return { todaysChangedArticles, frequentlyChangedArticles, tagLine, og };
};
