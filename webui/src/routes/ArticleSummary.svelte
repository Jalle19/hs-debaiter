<script lang="ts">
  import type { Article } from '$lib/types';

  export let article: Article;
</script>

[{article.num_titles}] <a href="/article/{article.guid}">{article.title}</a> ({article.created_at})
