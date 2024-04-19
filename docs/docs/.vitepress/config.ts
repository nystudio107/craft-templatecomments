import {defineConfig} from 'vitepress'

export default defineConfig({
  title: 'Template Comments Plugin',
  description: 'Documentation for the Template Comments plugin',
  base: '/docs/template-comments/',
  lang: 'en-US',
  head: [
    ['meta', {content: 'https://github.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://twitter.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://youtube.com/nystudio107', property: 'og:see_also',}],
    ['meta', {content: 'https://www.facebook.com/newyorkstudio107', property: 'og:see_also',}],
  ],
  themeConfig: {
    socialLinks: [
      {icon: 'github', link: 'https://github.com/nystudio107'},
      {icon: 'twitter', link: 'https://twitter.com/nystudio107'},
    ],
    logo: '/img/plugin-logo.svg',
    editLink: {
      pattern: 'https://github.com/nystudio107/craft-templatecomments/edit/develop-v5/docs/docs/:path',
      text: 'Edit this page on GitHub'
    },
    algolia: {
      appId: '',
      apiKey: '',
      indexName: '',
      searchParameters: {
        facetFilters: ["version:v5"],
      },
    },
    lastUpdatedText: 'Last Updated',
    sidebar: [],
    nav: [
      {text: 'Home', link: 'https://nystudio107.com/plugins/template-comments'},
      {text: 'Store', link: 'https://plugins.craftcms.com/templatecomments'},
      {text: 'Changelog', link: 'https://nystudio107.com/plugins/template-comments/changelog'},
      {text: 'Issues', link: 'https://github.com/nystudio107/craft-templatecomments/issues'},
      {
        text: 'v5', items: [
          {text: 'v5', link: '/'},
          {text: 'v4', link: 'https://nystudio107.com/docs/template-comments/v4/'},
          {text: 'v1', link: 'https://nystudio107.com/docs/template-comments/v1/'},
        ],
      },
    ]
  },
});
