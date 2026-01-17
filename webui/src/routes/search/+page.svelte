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
  <h2>Search</h2>

  <p>Remember reading some ragebait but now you can't find it? No problem!</p>
  <p>You can use some basic tricks to help find what you're looking for:</p>
  <ul>
    <li>
      <pre>erika vikman</pre>
      will find articles containing either
      <pre>erika</pre>
      or
      <pre>vikman</pre>
    </li>
    <li>
      <pre>"erika vikman"</pre>
      will find articles containing literally "erika vikman"
    </li>
    <li>
      <pre>erika -vikman</pre>
      will find articles about all the other Erikas
    </li>
  </ul>
  <p>All the usual caveats about the computer not actually understanding Finnish apply.</p>
</div>

<div class="pure-u-1-1 l-box">
  <SearchForm searchQuery={data.searchQuery}></SearchForm>
</div>

<div class="pure-u-1-1 l-box">
  {#if data.searchQuery}
    <h2>
      Search results for <pre>{data.searchQuery}</pre>
    </h2>
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

<style>
  pre {
    display: inline-block;
    margin: 0;
    background-color: #ddd;
  }
</style>
