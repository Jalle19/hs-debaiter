<script lang="ts">
  import { goto } from '$app/navigation';
  import { type ArticleFilter, Timespan, toUrlSearchParams } from '$lib/articleFilter';

  export let filter: ArticleFilter;

  const filterChanged = async () => {
    const urlParams = toUrlSearchParams(filter);

    await goto(`/?${urlParams.toString()}`);
  };
</script>

<form>
  <select bind:value={filter.timespan} on:change={filterChanged}>
    <option value={Timespan.WEEK}>Past week</option>
    <option value={Timespan.MONTH}>Past month</option>
    <option value={Timespan.YEAR}>Past year</option>
    <option value={Timespan.ALL_TIME}>All time</option>
  </select>

  <label for="exclude-live">
    Exclude live
    <input type="checkbox" bind:checked={filter.excludeLive} on:change={filterChanged} />
  </label>
</form>
