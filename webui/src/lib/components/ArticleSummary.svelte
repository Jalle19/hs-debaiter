<script lang="ts">
  import type { Article } from '$lib/types';

  export let article: Article;
</script>

[{article.num_titles}/{article.num_test_titles}]
{#if article.live}
  <span class="dot"></span>
{/if}
<a href="/article/{article.guid}">{article.title}</a>
({article.created_at})

<style>
  .dot {
    height: 0.75em;
    width: 0.75em;
    background-color: rgb(246, 86, 81);
    border-radius: 50%;
    display: inline-block;
  }
</style>
