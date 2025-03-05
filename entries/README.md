# Entry Points Directory

This is the directory where `alley-build` will detect entry point directories that are not blocks. These entries can be slotfills or webpack entry points.

Each entry point should contain an `index.ts` file that will be used as the entry point for webpack. The entry point directory should also contain any other files that are needed for the entry point to work.

## Entry point directory structure
```
entries/
└── example/
    ├── index.ts
    ├── file1.ts
    └── file2.ts
```
The above example will create a webpack entry point called `example` that will be built to `build/example/index.js`.

### Including styles
Import styles in the index.ts file in order to include styles.

```shell
entries/
└── example/
    ├── index.ts
    ├── index.scss
    ├── file1.ts
    └── file2.ts
```

```ts
// index.ts
import './index.scss';
```

The above example will build a stylesheet with the `example` entry to `build/example/index.css`.

### Including PHP files

The entry point can also include php files that will be copied to the build directory. This is useful for slotfills or other entries where script registration and enqueueing can be authored alongside the script itself.

```
entries/
└── example/
    ├── index.ts
    ├── file1.ts
    ├── file2.ts
    └── index.php
```
