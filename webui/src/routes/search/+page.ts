import type { PageLoad } from './$types';
import { env } from '$env/dynamic/public';
import type { SearchQuery } from '$lib/types';

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

  return { searchQuery, searchResults };
};
