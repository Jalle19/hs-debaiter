<script lang="ts">
  import { DEFAULT_OG } from '$lib/seo';

  export let og = DEFAULT_OG;
</script>

<meta property="og:title" content={og.title} />
<meta property="og:image" content={og.image} />
{#if og.description}
  <meta property="og:description" content={og.description} />
{/if}
