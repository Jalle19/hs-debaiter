<script lang="ts">
  import { DEFAULT_OG, getPageTitle, og } from '$lib/seo';
  import ArticleSummary from '$lib/components/ArticleSummary.svelte';
  import SearchForm from '$lib/components/SearchForm.svelte';

  export let data;

  $og = {
    ...DEFAULT_OG,
    description: getPageTitle(`Search results for "${data.searchQuery}"`)
  };
</script>

<div class="pure-u-1-1 l-box">
  <SearchForm searchQuery={data.searchQuery}></SearchForm>
</div>

<div class="pure-u-1-1 l-box">
  {#if data.searchQuery}
    <h2>Search results for <i>"{data.searchQuery}"</i></h2>
    {#if data.searchResults.length > 0}
      <ul>
        {#each data.searchResults as article}
          <li>
            <ArticleSummary {article}></ArticleSummary>
          </li>
        {/each}
      </ul>
    {:else}
      <p>No articles found matching your search</p>
    {/if}
  {/if}
</div>
