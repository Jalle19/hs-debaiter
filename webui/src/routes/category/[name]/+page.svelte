<script>
  import ArticleSummary from '../../ArticleSummary.svelte';
  import { page } from '$app/stores';

  export let data;
</script>

<div class="pure-u-1-1 l-box">
  <h2>Recent articles from category <i>{$page.params.name}</i></h2>

  {#if data.categoryArticles.length > 0}
    <ul>
      {#each data.categoryArticles as article}
        <li>
          <ArticleSummary {article}></ArticleSummary>
        </li>
      {/each}
    </ul>
  {:else}
    <p>No recent articles found</p>
  {/if}
</div>
