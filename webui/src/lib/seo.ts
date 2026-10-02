export const APP_NAME = 'hs-debaiter';

type OpenGraph = {
  title: string;
  image: string;
  description?: string;
};

export const DEFAULT_OG: Partial<OpenGraph> = {
  image: '/hs-debaiter_default.png'
};

export const formatPageTitle = (pageTitle?: string): string => {
  if (pageTitle) {
    return `${pageTitle} | ${APP_NAME}`;
  } else {
    return APP_NAME;
  }
};
