<script lang="ts">
    import {page} from "$app/stores";

    const guid = $page.params?.guid
    export let data

    console.dir(data)
</script>

<h2>Article {guid}</h2>
<a href="{data.article.url}" target="_blank">{data.article.url}</a>
<p>Current title: {data.article.title}</p>
<h3>Previous titles (including current)</h3>
<ul>
    {#each data.article.article_titles as title}
        <li>{title.title} ({title.created_at}</li>
    {/each}
</ul>