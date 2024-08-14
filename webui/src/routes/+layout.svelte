<script lang="ts">
  import { page } from '$app/stores';

  import 'purecss/build/pure.css';
  import './styles.css';
  import Navigation from './Navigation.svelte';
  import { getPageTitle, og } from '$lib/seo';
  import MetaTags from '$lib/components/MetaTags.svelte';

  $: pageTitle = getPageTitle($page.data.pageTitle);
</script>

<svelte:head>
  <title>{pageTitle}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <MetaTags og={$og} />
</svelte:head>

<div class="pure-g container">
  <div class="pure-u-1-1 l-box">
    <Navigation></Navigation>
  </div>

  <slot />
</div>
