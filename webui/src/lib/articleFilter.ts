export enum Timespan {
  WEEK = 'WEEK',
  MONTH = 'MONTH',
  YEAR = 'YEAR',
  ALL_TIME = 'ALL_TIME'
}

export type ArticleFilter = {
  timespan: Timespan;
  excludeLive: boolean;
};

export const fromUrlSearchParams = (params: URLSearchParams): ArticleFilter => {
  return {
    timespan: params.has('timespan') ? (params.get('timespan') as Timespan) : Timespan.WEEK,
    excludeLive: params.get('excludeLive') === 'true'
  };
};

export const toUrlSearchParams = (filter: ArticleFilter): URLSearchParams => {
  return new URLSearchParams([
    ['timespan', filter.timespan],
    ['excludeLive', filter.excludeLive ? 'true' : 'false']
  ]);
};
