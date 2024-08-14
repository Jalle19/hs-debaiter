import { writable } from 'svelte/store';

export const APP_NAME = 'hs-debaiter';

type OpenGraph = {
  title: string;
  image: string;
  description?: string;
};

export const DEFAULT_OG: OpenGraph = {
  title: APP_NAME,
  image: '/hs-debaiter_default.png'
};

export const og = writable(DEFAULT_OG);

export const getPageTitle = (pageTitle?: string): string => {
  if (pageTitle) {
    return `${pageTitle} | ${APP_NAME}`;
  } else {
    return APP_NAME;
  }
};
