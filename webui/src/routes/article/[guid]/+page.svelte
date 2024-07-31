<script lang="ts">
  export let data;
</script>

<style>
  img {
    max-width: 100%;
  }
</style>

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
    <ul>
      {#each data.article.article_titles as title}
        <li>{title.title} ({title.created_at})</li>
      {/each}
    </ul>
  </div>
</div>
