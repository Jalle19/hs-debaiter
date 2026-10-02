import type { PageLoad } from './$types';
import { env } from '$env/dynamic/public';
import type { SearchQuery } from '$lib/types';
import { DEFAULT_OG, getPageTitle } from '$lib/seo';

export const load: PageLoad = async ({ fetch, url }) => {
  let searchResults = [];

  const searchQuery: SearchQuery = url.searchParams.get('q');

  if (searchQuery !== null) {
    try {
      const response = await fetch(
        `${env.PUBLIC_API_BASE_URL}/articles/search?q=${encodeURIComponent(searchQuery)}`
      );

      if (response.ok) {
        searchResults = await response.json();
      }
    } catch (err) {
      console.error('Search failed: ', err);
    }
  }

  const pageTitle = searchQuery !== null ? `Search results for "${searchQuery}"` : 'Search';
  const og = {
    ...DEFAULT_OG,
    title: pageTitle
  };

  return { pageTitle, searchQuery, searchResults, og };
};
