const path = require('path');
const glob = require('glob'); // eslint-disable-line import/no-extraneous-dependencies
const defaultConfig = require('@alleyinteractive/build-tool/dist/cjs/config/webpack.config');

// The entry is a function that returns the default entry object.
const defaultEntries = defaultConfig.default.entry();

const config = {
  // Add entries for block styles.
  entry: () => {
    const filePath = path.join(__dirname, '/assets/scss/blocks');
    const globDirs = glob.sync(`${filePath}/**/*.{scss,css}`, { dotRelative: true, posix: true });

    const blockStyleEntries = globDirs.reduce((acc, entry) => {
      const entryName = path.basename(entry, path.extname(entry));
      const namespace = path.basename(path.dirname(entry));

      return {
        ...acc,
        [`block-styles/${namespace}/${entryName}`]: entry,
      };
    }, {});

    return {
      ...defaultEntries,
      ...blockStyleEntries,
    };
  },
};

module.exports = config;
