<script>
  import 'purecss/build/pure.css';
  import './styles.css';
  import Navigation from './Navigation.svelte';
</script>

<svelte:head>
  <title>hs-debaiter</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
</svelte:head>

<div class="pure-g container">
  <div class="pure-u-1-1 l-box">
    <Navigation></Navigation>
  </div>

  <slot />
</div>
