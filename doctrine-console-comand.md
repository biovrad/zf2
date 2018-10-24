
**in dir:**
_vova@vova:~/Документы/project/site/local.zf.com/vendor/bin_

php doctrine-module orm:convert-mapping --namespace="Blog\\Entity\\" --force --from-database annotation ./module/Blog/src/
php doctrine-module orm:generate-entities ./module/Blog/src/ --generate-annotations=true ﻿--forse