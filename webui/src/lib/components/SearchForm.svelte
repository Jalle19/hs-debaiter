<script lang="ts">
  import { goto } from '$app/navigation';
  import type { SearchQuery } from '$lib/types';

  export let searchQuery: SearchQuery;

  const searchButtonClicked = async () => {
    const query = searchQuery?.trim();

    if (query) {
      await goto(`/search?q=${encodeURIComponent(query)}`);
    }
  };
</script>

Search for articles by title (past or previous):

<form on:submit|preventDefault={searchButtonClicked}>
  <input type="text" bind:value={searchQuery} />
  <button>Search</button>
</form>
