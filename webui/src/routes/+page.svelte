<script lang="ts">
    import {goto} from "$app/navigation";

    export let data

    let inputArticleUrl: string

    const debaitButtonClicked = async () => {
        // Parse the URL to get the GUID from it
        const url = new URL(inputArticleUrl)
        const path = url.pathname

        let guid = path.substring(path.lastIndexOf('art-') + 4, path.lastIndexOf('.'))

        // Navigate
        await goto(`/article/hs-${guid}`)
    }
</script>

<p>See beyond the veil and expose the true agenda &#128517;</p>

Paste a link to an article:
<form on:submit|preventDefault={debaitButtonClicked}>
    <input type="text" bind:value={inputArticleUrl}/>
    <button>Debait</button>
</form>

<h2>Latest articles</h2>

<ul>
    {#each data.articles as article}
        <li>[{article.num_titles}] <a href="/article/{article.guid}">{article.title}</a></li>
    {/each}
</ul>

<h2>Frequently changed articles</h2>

<ul>
    {#each data.frequentlyChangedArticles as article}
        <li>[{article.num_titles}] <a href="/article/{article.guid}">{article.title}</a></li>
    {/each}
</ul>