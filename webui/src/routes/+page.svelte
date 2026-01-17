<script lang="ts">
  import { goto } from '$app/navigation';
  import { APP_NAME, DEFAULT_OG, og } from '$lib/seo';
  import ArticleSummary from '$lib/components/ArticleSummary.svelte';
  import SearchForm from '$lib/components/SearchForm.svelte';

  export let data;

  let inputArticleUrl: string;

  const debaitButtonClicked = async () => {
    // Parse the URL to get the GUID from it
    try {
      const url = new URL(inputArticleUrl);
      const path = url.pathname;
      let guid = path.substring(path.lastIndexOf('art-') + 4, path.lastIndexOf('.'));

      // Navigate
      await goto(`/article/hs-${guid}`);
    } catch (e) {
      // Ignore unparsable input
      console.error(`Unable to parse URL:`, e);
    }
  };

  const tagLine = 'See beyond the veil and expose the true agenda';
  $og = {
    ...DEFAULT_OG,
    description: tagLine
  };
</script>

<div class="pure-u-1-1 l-box">
  <h1 style="margin-bottom: 0;">{APP_NAME}</h1>
  <p>{tagLine} &#128517;</p>
</div>

<div class="pure-u-1-2 l-box">
  Paste a link to an article:
  <form on:submit|preventDefault={debaitButtonClicked}>
    <input type="text" bind:value={inputArticleUrl} />
    <button>Debait</button>
  </form>
</div>

<div class="pure-u-1-2 l-box">
  <SearchForm searchQuery=""></SearchForm>
</div>

<div class="pure-u-1-1 l-box">
  <h2>Articles with title changes (last 24 hours)</h2>

  <ul>
    {#each data.todaysChangedArticles as article}
      <li>
        <ArticleSummary {article}></ArticleSummary>
      </li>
    {/each}
  </ul>
</div>

<div class="pure-u-1-1 l-box">
  <h2>Most updated articles (last 7 days)</h2>

  <ul>
    {#each data.frequentlyChangedArticles as article}
      <li>
        <ArticleSummary {article}></ArticleSummary>
      </li>
    {/each}
  </ul>
</div>
