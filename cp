#!/usr/bin/env bash
TO_PATH="./../bestlang/laracms"
# 模板
cp -rf ./resources/views/vendor/laracms/dark "$TO_PATH"/resources/views/laracms/
# 管理后台代码
#rsync -a --delete --exclude-from=./resources/admin/node_modules/  ./resources/admin "$TO_PATH"/resources/
# 包主要代码
rsync -a ./packages/bestlang/laracms/ "$TO_PATH"/
# 编译好的js与css
rsync -ax ./public/vendor/ "$TO_PATH"/resources/vendor/

cd "$TO_PATH" && git add . && git commit -m '#' && git push

open /Users/lu/PhpstormProjects/bestlang/laracms
