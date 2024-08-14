<script lang="ts">
  import { DEFAULT_OG, getPageTitle, og } from '$lib/seo';

  export let data;

  const parseTitleCategory = (title: string): string => {
    const pos = title.indexOf(' | ');

    return title.substring(0, pos);
  };

  const parseTitle = (title: string): string => {
    const pos = title.indexOf(' | ');

    return title.substring(pos + 3, title.length);
  };

  $og = {
    ...DEFAULT_OG,
    title: getPageTitle(data.pageTitle),
    image: data.article.image_url ?? DEFAULT_OG.image,
    description: `The article title has been changed ${data.article.article_titles.length - 1} times`
  };
</script>

<div class="pure-g">
  <div class="pure-u-1-4 l-box">
    {#if data.article.image_url}
      <img src={data.article.image_url} alt="" />
    {/if}
  </div>

  <div class="pure-u-3-4 l-box">
    <h2>{data.article.title}</h2>

    <p>
      <a href={data.article.url} target="_blank">{data.article.url}</a>
    </p>
  </div>

  <div class="pure-u-1-1 l-box">
    <h3>Previous titles (including current)</h3>
    <p>
      The article title has been changed {data.article.article_titles.length - 1} times
    </p>
    <ul>
      {#each data.article.article_titles as title}
        <li>
          {parseTitleCategory(title.title)} | <span class="title">{parseTitle(title.title)}</span>
          ({title.created_at})
        </li>
      {/each}
    </ul>
  </div>
</div>

<style>
  img {
    max-width: 100%;
  }

  span.title {
    font-weight: bold;
  }
</style>
