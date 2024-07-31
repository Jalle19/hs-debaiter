import type { PageLoad } from './$types';
import { PUBLIC_BASE_URL } from '$env/static/public';

export const load: PageLoad = async ({ fetch, params }) => {
  const response = await fetch(`${PUBLIC_BASE_URL}/article/${params.guid}`);
  const article = await response.json();

  return { article };
};
