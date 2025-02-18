export default {
  build: [

    // Frontend - See includes/enqueue.php

    // {
    //   src: 'assets/src/index.js',
    //   dest: 'assets/build/data-structures-and-algorithms-plugin.min.js'
    // },
    // {
    //   src: 'assets/src/index.scss',
    //   dest: 'assets/build/data-structures-and-algorithms-plugin.min.css'
    // },

    // Admin

    {
      src: 'assets/src/css/admin.scss',
      dest: 'assets/build/admin.min.css'
    },

    {
      src: 'assets/src/css/sorting.scss',
      dest: 'assets/build/sorting.min.css'
    },

    {
      src: 'assets/src/js/sorting.js',
      dest: 'assets/build/sorting.min.js'
    }
  ],
  format: [
    'assets/src',
    'includes',
    '*.{php,js,json}'
  ],
  install: [
    {
      git: 'git@github.com:tangibleinc/framework',
      branch: 'main',
      dest: 'vendor/tangible/framework'
    },
    {
      git: 'git@github.com:tangibleinc/plugin-updater',
      branch: 'main',
      dest: 'vendor/tangible/plugin-updater'
    },
  ]
}
