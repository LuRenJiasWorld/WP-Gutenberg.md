### WP-Gutenberg.md

这是一个基于WordPress 5.0 Gutenberg 编辑器进行扩展而来的插件。

目前实现了Markdown功能，原版是JetPack markdown抽取出来单独使用。

TODO：

- 插件实现

编译环境：

WSL, Linux, macOS

编译命令：

`npm run sdk -- gutenberg client/gutenberg/extensions/presets/gmd`

```bash
npm run sdk -- gutenberg client/gutenberg/extensions/presets/gmd && rm -rf /mnt/e/WinNMP/www/wordpress/wp-content/plugins/WP-GMD/assets/editor/editor.* && cp client/gutenberg/extensions/presets/gmd/build/editor.css /mnt/e/WinNMP/www/wordpress/wp-content/plugins/WP-GMD/assets/editor/ && cp client/gutenberg/extensions/presets/gmd/build/editor.js /mnt/e/WinNMP/www/wordpress/wp-content/plugins/WP-GMD/assets/editor/
```

注意事项：

第一次安装环境，如果需要功能插件支持请在根目录安装：

```bash
npm i markdown-it-plugin-katex # KaTeX
npm i markdown-it-plugin-mermaid # mermaid
npm i markdown-it-prism # Prism.js
```