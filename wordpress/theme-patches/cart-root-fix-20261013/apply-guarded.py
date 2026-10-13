# Apply from the active child-theme directory after taking private backups.
# Guarded against reapplication or changes since the inspected live version.
import hashlib,json
from pathlib import Path
PATCH=Path(__file__).resolve().parent
THEME=Path.cwd()
manifest=json.loads((PATCH/'manifest.json').read_text())
paths={'woocommerce.php':'inc/woocommerce.php','app.css':'assets/css/app.css','pro.css':'assets/css/pro.css','navar.min.css':'assets/css/navar.min.css'}
for x in manifest:
 p=THEME/paths[x['file']]
 if hashlib.sha256(p.read_bytes()).hexdigest()!=x['before_sha256']:raise SystemExit('Before SHA mismatch: '+str(p))
for x in manifest:
 name=x['file'];p=THEME/paths[name]
 if name=='woocommerce.php':s=(PATCH/'patched/woocommerce.php').read_text()
 else:
  s=p.read_text().replace('.prose table','.prose table:not(.wc-block-cart-items)').replace('.prose th','.prose table:not(.wc-block-cart-items) th').replace('.prose td','.prose table:not(.wc-block-cart-items) td')
  if name in ['pro.css','navar.min.css']:s+='\n'+(PATCH/'mobile-cart.css').read_text()
 if hashlib.sha256(s.encode()).hexdigest()!=x['after_sha256']:raise SystemExit('After SHA mismatch: '+str(p))
 p.write_text(s)
print('Four scoped files patched; refresh generated Rocket HTML/theme CSS cache and retest normal cart clicks.')
