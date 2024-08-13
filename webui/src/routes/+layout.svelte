<script lang="ts">
  import { page } from '$app/stores';

  import 'purecss/build/pure.css';
  import './styles.css';
  import Navigation from './Navigation.svelte';

  const getPageTitle = (pageTitle: string | undefined): string => {
    const appName = 'hs-debaiter';

    if (pageTitle) {
      return `${pageTitle} | ${appName}`;
    } else {
      return appName;
    }
  };

  $: pageTitle = getPageTitle($page.data.pageTitle);
</script>

<svelte:head>
  <title>{pageTitle}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
</svelte:head>

<div class="pure-g container">
  <div class="pure-u-1-1 l-box">
    <Navigation></Navigation>
  </div>

  <slot />
</div>
