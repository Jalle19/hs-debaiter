import type { PageLoad } from './$types';
import { env } from '$env/dynamic/public';
import { DEFAULT_OG } from '$lib/seo';
import { fromUrlSearchParams, toUrlSearchParams } from '$lib/articleFilter';

export const load: PageLoad = async ({ fetch, url }) => {
  // Construct search filter
  const articleFilter = fromUrlSearchParams(url.searchParams);

  // Fetch articles
  let response = await fetch(`${env.PUBLIC_API_BASE_URL}/articles/todays-changed`);
  const todaysChangedArticles = await response.json();

  // Fetch frequently changed articles
  response = await fetch(
    `${env.PUBLIC_API_BASE_URL}/articles/frequently-changed?${toUrlSearchParams(articleFilter)}`
  );
  const frequentlyChangedArticles = await response.json();

  const tagLine = 'See beyond the veil and expose the true agenda';

  const og = {
    ...DEFAULT_OG,
    description: tagLine
  };

  return { articleFilter, todaysChangedArticles, frequentlyChangedArticles, tagLine, og };
};
