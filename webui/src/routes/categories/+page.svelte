<script lang="ts">
  export let data;
</script>

<div class="pure-u-1-1 l-box">
  <h1>Categories</h1>

  <ul>
    {#each data.categories as category}
      <li>
        <a href="/category/{encodeURIComponent(category.name)}">{category.name}</a>
      </li>
    {/each}
  </ul>
</div>
