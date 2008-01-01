<?php
/**
 * Internationalisation file for Renameuser extension.
 *
 * @addtogroup Extensions
*/

$messages = array();

$messages['en'] = array(
	'renameuser'       => 'Rename user',
	'renameuserold'    => 'Current username:',
	'renameusernew'    => 'New username:',
	'renameuserreason' => 'Reason for rename:',
	'renameusermove'   => 'Move user and talk pages (and their subpages) to new name',
	'renameusersubmit' => 'Submit',
	'renameusererrordoesnotexist' => 'The user "<nowiki>$1</nowiki>" does not exist',
	'renameusererrorexists'       => 'The user "<nowiki>$1</nowiki>" already exists',
	'renameusererrorinvalid'      => 'The username "<nowiki>$1</nowiki>" is invalid',
	'renameusererrortoomany'      => 'The user "<nowiki>$1</nowiki>" has $2 contributions, renaming a user with more than $3 contributions could adversely affect site performance',
	'renameusersuccess'           => 'The user "<nowiki>$1</nowiki>" has been renamed to "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'         => 'The page $1 already exists and cannot be automatically overwritten.',
	'renameuser-page-moved'          => 'The page $1 has been moved to $2.',
	'renameuser-page-unmoved'        => 'The page $1 could not be moved to $2.',
	'renameuserlogpage'     => 'User rename log',
	'renameuserlogpagetext' => 'This is a log of changes to user names',
	'renameuserlogentry'    => 'has renamed $1 to $2',
	'renameuser-log'        => '$1 edits. Reason: $2',
	'renameuser-move-log'   => 'Automatically moved page while renaming the user "[[User:$1|$1]]" to "[[User:$2|$2]]"',
);

$messages['af'] = array(
	'renameusererrordoesnotexist' => 'Die gebruiker "<nowiki>$1</nowiki>" bestaan nie',
	'renameusererrorexists'       => 'Die gebruiker "<nowiki>$1</nowiki>" bestaan reeds',
	'renameusererrorinvalid'      => '"<nowiki>$1</nowiki>" is \'n ongeldige gebruikernaam',
);

$messages['ar'] = array(
	'renameuser' => 'إعادة تسمية مستخدم',
	'renameuserold' => 'اسم المستخدم الحالي:',
	'renameusernew' => 'الاسم الجديد:',
	'renameuserreason' => 'السبب لإعادة التسمية:',
	'renameusermove' => 'انقل صفحات المستخدم ونقاشه (بالصفحات الفرعية) إلى الاسم الجديد',
	'renameusersubmit' => 'تنفيذ',
	'renameusererrordoesnotexist' => 'لا يوجد مستخدم بالاسم "<nowiki>$1</nowiki>"',
	'renameusererrorexists' => 'المستخدم "<nowiki>$1</nowiki>" موجود بالفعل',
	'renameusererrorinvalid' => 'اسم المستخدم "<nowiki>$1</nowiki>" غير صحيح',
	'renameusererrortoomany' => 'يمتلك المستخدم "<nowiki>$1</nowiki>" $2 مساهمة، إعادة تسمية مستخدم يمتلك أكثر من $3 مساهمة قد يؤثر سلبا على أداء الموقع.',
	'renameusersuccess' => 'تمت إعادة تسمية المستخدم "<nowiki>$1</nowiki>" إلى "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'الصفحة $1 موجودة بالفعل ولا يمكن إنشاء أخرى مكانها أوتوماتيكيا.',
	'renameuser-page-moved' => 'تم نقل الصفحة $1 إلى $2.',
	'renameuser-page-unmoved' => 'لم يتمكن من نقل الصفحة $1 إلى $2.',
	'renameuserlogpage' => 'سجل إعادة تسمية المستخدمين',
	'renameuserlogpagetext' => 'هذا سجل بالتغييرات في أسماء المستخدمين',
	'renameuserlogentry' => 'أعاد تسمية $1 باسم [[User:$2]]',
	'renameuser-log' => '$1 تعديل. السبب: $2',
	'renameuser-move-log' => 'نقل الصفحة تلقائيا خلال إعادة تسمية المستخدم من "[[User:$1|$1]]" إلى "[[User:$2|$2]]"',
);

$messages['arc'] = array(
	'renameusersubmit' => 'ܡܨܝܘܬܐ',
);

$messages['bcl'] = array(
	'renameusersubmit' => 'Isumitir',
	'renameusererrordoesnotexist' => 'An parágamit "<nowiki>$1</nowiki>" mayò man',
	'renameusererrorexists' => 'An parágamit "<nowiki>$1</nowiki>" yaon na',
	'renameuser-page-moved' => 'An páhinang $1 piglipat sa $2.',
	'renameuser-page-unmoved' => 'An páhinang $1 dai mailipat sa $2.',
	'renameuser-log' => '$1 mga hirá. Rasón: $2',
);

$messages['bg'] = array(
	'renameuser' => 'Преименуване на потребител',
	'renameuserold' => 'Текущо потребителско име:',
	'renameusernew' => 'Ново потребителско име:',
	'renameuserreason' => 'Причина за преименуването:',
	'renameusermove' => 'Преместване под новото име на потребителската лична страница и беседа (както и техните подстраници)',
	'renameusersubmit' => 'Изпълнение',
	'renameusererrordoesnotexist' => 'Потребителят „<nowiki>$1</nowiki>“ не съществува.',
	'renameusererrorexists' => 'Потребителят „<nowiki>$1</nowiki>“ вече съществува.',
	'renameusererrorinvalid' => 'Потребителското име „<nowiki>$1</nowiki>“ е невалидно.',
	'renameusererrortoomany' => 'Потребителят „<nowiki>$1</nowiki>“ има $2 приноса. Преименуването на потребители с повече от $3 приноса, може да се отрази зле на производителността на сайта.',
	'renameusersuccess' => 'Потребителят „<nowiki>$1</nowiki>“ беше преименуван на „<nowiki>$2</nowiki>“',
	'renameuser-page-exists' => 'Страницата $1 вече съществува и не може да бъде автоматично заместена.',
	'renameuser-page-moved' => 'Страницата $1 беше преместена като $2.',
	'renameuser-page-unmoved' => 'Страницата $1 не можа да бъде преместена като $2.',
	'renameuserlogpage' => 'Дневник на преименуванията',
	'renameuserlogpagetext' => 'Това е дневник на преименуванията на потребители',
	'renameuserlogentry' => 'преименува $1 на $2',
	'renameuser-log' => '$1 редакции. Причина: $2',
	'renameuser-move-log' => 'Автоматично преместена страница при преименуването на потребител "[[User:$1|$1]]" като "[[User:$2|$2]]"',
);

$messages['br'] = array(
	'renameuser'       => 'Adenvel an implijer',
	'renameuserold'    => 'Anv a-vremañ an implijer :',
	'renameusernew'    => 'Anv implijer nevez :',
	'renameusermove'   => 'Kas ar pajennoù implijer ha kaozeal (hag o ispajennoù) betek o anv nevez',
	'renameusersubmit' => 'Adenvel',

	'renameusererrordoesnotexist' => 'An implijer "<nowiki>$1</nowiki>" n\'eus ket anezhañ',
	'renameusererrorexists'       => 'Krouet eo bet an anv implijer "<nowiki>$1</nowiki>" dija',
	'renameusererrorinvalid'      => 'Faziek eo an anv implijer "<nowiki>$1</nowiki>"',
	'renameusererrortoomany'      => 'Deuet ez eus $2 degasadenn gant an implijer "<nowiki>$1</nowiki>"; adenvel un implijer degaset gantañ ouzhpenn $3 degasadenn a c\'hall noazout ouzh startijenn mont en-dro al lec\'hienn a-bezh',
	'renameusersuccess'           => 'Deuet eo an implijer "<nowiki>$1</nowiki>" da vezañ "<nowiki>$2</nowiki>"',

	'renameuser-page-exists'         => 'Bez\' ez eus eus ar bajenn $1 dija, n\'haller ket hec\'h erlec\'hiañ ent emgefreek.',
	'renameuser-page-moved'          => 'Adkaset eo bet ar bajenn $1 da $2.',
	'renameuser-page-unmoved'        => 'N\'eus ket bet gallet adkas ar bajenn $1 da $2.',

	'renameuserlogpage'     => 'Roll an implijerien bet adanvet',
	'renameuserlogpagetext' => 'Setu istor an implijerien bet cheñchet o anv ganto',
	'renameuser-log'        => 'Ssavet gantañ $1 degasadenn. $2',
	'renameuser-move-log'   => 'Pajenn dilec\'hiet ent emgefreek e-ser adenvel an implijer "[[Implijer:$1|$1]]" e "[[Implijer:$2|$2]]"',
);

$messages['ca'] = array(
	'renameuser'=> 'Reanomena l\'usuari',
	'renameuserold'=> 'Nom d\'usuari actual:',
	'renameusernew'=> 'Nou nom d\'usuari:',
	'renameusermove'=> 'Reanomena la pàgina d\'usuari, la de discussió i les subpàgines que tingui al nou nom',
	'renameusersubmit'=> 'Tramet',
	'renameusererrordoesnotexist'=> 'L\'usuari «<nowiki>$1</nowiki>» no existeix',
	'renameusererrorexists'=> 'L\'usuari «<nowiki>$1</nowiki>» ja existeix',
	'renameusererrorinvalid'=> 'El nom d\'usuari «<nowiki>$1</nowiki>» no és vàlid',
	'renameusererrortoomany'=> 'L\'usuari «<nowiki>$1</nowiki>» té $2 contribucions. Canviar el nom a un usuari amb més de $3 contribucions pot causar problemes',
	'renameusersuccess'=> 'L\'usuari «<nowiki>$1</nowiki>» s\'ha reanomenat com a «<nowiki>$2</nowiki>»',
	'renameuser-page-exists'=> 'La pàgina «$1» ja existeix i no pot ser sobreescrita automàticament',
	'renameuser-page-moved'=> 'La pàgina «$1» s\'ha reanomenat com a «$2».',
	'renameuser-page-unmoved'=> 'La pàgina $1 no s\'ha pogut reanomenar com a «$2».',
	'renameuserlogpage'=> 'Registre del canvi de nom d\'usuari',
	'renameuserlogpagetext'=> 'Aquest és un registre dels canvis als noms d\'usuari',
	'renameuser-log'=> 'Amb $1 contribucions. $2',
	'renameuser-move-log'=> 'S\'ha reanomenat automàticament la pàgina mentre es reanomenava l\'usuari «[[User:$1|$1]]» com «[[User:$2|$2]]»',
);
$messages['cdo'] = array(
	'renameuserold'    => 'Hiêng-sì-câi gì ê̤ṳng-hô-miàng:',
	'renameusernew'    => 'Sĭng ê̤ṳng-hô-miàng:',
	'renameuser-page-moved'          => 'Ciā hiĕk $1 ī-gĭng ké̤ṳk iè gáu $2.',
);

$messages['cs'] = array(
	'renameuser' => 'Přejmenovat uživatele',
	'renameuserold' => 'Stávající uživatelské jméno:',
	'renameusernew' => 'Nové uživatelské jméno:',
	'renameuserreason' => 'Důvod přejmenování:',
	'renameusermove' => 'Přesunout uživatelské a diskusní stránky (a jejich podstránky) na nové jméno',
	'renameusersubmit' => 'Přejmenovat',
	'renameusererrordoesnotexist' => 'Uživatel se jménem „<nowiki>$1</nowiki>“ neexistuje',
	'renameusererrorexists' => 'Uživatel se jménem „<nowiki>$1</nowiki>“ již existuje',
	'renameusererrorinvalid' => 'Uživatelské jméno „<nowiki>$1</nowiki>“ nelze použít',
	'renameusererrortoomany' => 'Uživatel „<nowiki>$1</nowiki>“ má $2 příspěvků, přejmenování uživatelů s více než $3 příspěvky je zakázáno, neboť by příliš zatěžovalo systém.\'',
	'renameusersuccess' => 'Uživatel „<nowiki>$1</nowiki>“ byl úspěšně přejmenován na „<nowiki>$2</nowiki>“',
	'renameuser-page-exists' => 'Stránka $1 již existuje a nelze ji automaticky přepsat.',
	'renameuser-page-moved' => 'Stránka $1 byla přesunuta na $2.',
	'renameuser-page-unmoved' => 'Stránku $1 se nepodařilo přesunout na $2.',
	'renameuserlogpage' => 'Kniha přejmenování uživatelů',
	'renameuserlogpagetext' => 'Toto je záznam přejmenování uživatelů (změn uživatelského jména).',
	'renameuserlogentry' => 'přejmenovává $1 na [[User:$2|$2]]',
	'renameuser-log' => '$1 editací. $2',
	'renameuser-move-log' => 'Automatický přesun při přejmenování uživatele „[[User:$1|$1]]“ na „[[User:$2|$2]]“',
);

$messages['cu'] = array(
	'renameuser' => 'Прѣименѹи польѕевател҄ь',
	'renameuserold' => 'Нынѣщьнѥѥ имѧ:',
	'renameusernew' => 'Ново имѧ:',
	'renameuserreason' => 'Какъ съмыслъ:',
	'renameusermove' => 'Нарьци тако польѕевател страницѫ, бесѣдѫ и ихъ подъстраницѧ',
	'renameusersubmit' => 'Еи',
	'renameusererrordoesnotexist' => 'Польѕевател «<nowiki>$1</nowiki>» нѣстъ',
	'renameusererrorexists' => 'Польѕевател҄ь «<nowiki>$1</nowiki>» ѥстъ ю',
	'renameusererrorinvalid' => 'Имѧ «<nowiki>$1</nowiki>» нѣстъ годѣ',
	'renameusererrortoomany' => 'Польѕевател҄ь «<nowiki>$1</nowiki>» $2 {{PLURAL:$2|исправлѥниѥ|исправлѥнии|исправлѥни|исправлѥнии}} сътворилъ ѥстъ. Аще польѕевател прѣименѹѥши кыи болѥ $3 {{PLURAL:$3|исправлѥниѥ|исправлѥнии|исправлѥни|исправлѥнии}} сътворилъ ѥстъ, то зълѣ бѫдетъ.',
	'renameuserlogentry' => 'нарече $1 именьмь $2',
);

$messages['de'] = array(
	'renameuser'       => 'Benutzer umbenennen',
	'renameuserold'    => 'Bisheriger Benutzername:',
	'renameusernew'    => 'Neuer Benutzername:',
	'renameuserreason' => 'Grund:',
	'renameusermove'   => 'Verschiebe Benutzer-/Diskussionsseite inkl. Unterseiten auf den neuen Benutzernamen',
	'renameusersubmit' => 'Umbenennen',

	'renameusererrordoesnotexist' => 'Der Benutzername „<nowiki>$1</nowiki>“ existiert nicht.',
	'renameusererrorexists'       => 'Der Benutzername „<nowiki>$1</nowiki>“ existiert bereits.',
	'renameusererrorinvalid'      => 'Der Benutzername „<nowiki>$1</nowiki>“ ist ungültig.',
	'renameusererrortoomany'      => 'Der Benutzer „<nowiki>$1</nowiki>“ hat $2 Bearbeitungen. Die Namensänderung eines Benutzers mit mehr als $3 Bearbeitungen kann die Serverleistung nachteilig beeinflussen.',
	'renameusersuccess'           => 'Der Benutzer „<nowiki>$1</nowiki>“ wurde erfolgreich in „<nowiki>$2</nowiki>“ umbenannt.',

	'renameuser-page-exists'         => 'Die Seite $1 existiert bereits und kann nicht automatisch überschrieben werden.',
	'renameuser-page-moved'          => 'Die Seite $1 wurde nach $2 verschoben.',
	'renameuser-page-unmoved'        => 'Die Seite $1 konnte nicht nach $2 verschoben werden.',

	'renameuserlogpage'     => 'Benutzernamenänderungs-Logbuch',
	'renameuserlogpagetext' => 'In diesem Logbuch werden die Änderungen von Benutzernamen protokolliert.',
	'renameuserlogentry'    => 'hat „$1“ in „$2“ umbenannt',
	'renameuser-log'        => '$1 Bearbeitungen. Grund: $2',
	'renameuser-move-log'   => 'durch die Umbenennung von „[[{{ns:user}}:$1]]“ nach „[[{{ns:user}}:$2]]“ automatisch verschobene Seite.',
);

/** Greek (Ελληνικά)
 * @author Consta
 * @author MF-Warburg
 */
$messages['el'] = array(
	'renameusernew'      => 'Νέο όνομα χρήστη:',
	'renameuserlogentry' => '$1 μετονομάστηκε σε [[User:$2]]',
	'renameuser-log'     => '$1 επεξεργασίες. Λόγος: $2',
);

/** Japanese (日本語)
 * @author Suisui
 * @author Broad-Sky
 * @author Marine-Blue
 */
$messages['ja'] = array(
	'renameuser'                  => '利用者名の変更',
	'renameuserold'               => '現在の利用者名:',
	'renameusernew'               => '新しい利用者名:',
	'renameuserreason'            => '変更理由:',
	'renameusermove'              => '利用者ページと会話ページ及びそれらのサブページを新しい名前に移動する',
	'renameusersubmit'            => '変更',
	'renameusererrordoesnotexist' => '利用者 “<nowiki>$1</nowiki>” は存在しません。',
	'renameusererrorexists'       => '利用者 “<nowiki>$1</nowiki>” は既に存在しています。',
	'renameusererrorinvalid'      => '利用者名 “<nowiki>$1</nowiki>” は無効な値です。',
	'renameusererrortoomany'      => '利用者 "<nowiki>$1</nowiki>" には $2 件の投稿履歴があります。$3 件以上の投稿履歴がある利用者の名前を変更すると、サイトのパフォーマンスに悪影響を及ぼす可能性があります。',
	'renameusersuccess'           => '利用者 "[[User:$1|$1]]" を "[[User:$2|$2]]" に変更しました。',
	'renameuser-page-exists'      => '$1 が既に存在しているため、自動で上書きできませんでした。',
	'renameuser-page-moved'       => '$1 を $2 に移動しました。',
	'renameuser-page-unmoved'     => '$1 を $2 に移動できませんでした。',
	'renameuserlogpage'           => '利用者名変更記録',
	'renameuserlogpagetext'       => 'これは、利用者名の変更を記録したものです。',
	'renameuser-log'              => '投稿数 $1回. $2',
	'renameuser-move-log'         => '名前の変更と共に "[[User:$1|$1]]" を "[[User:$2|$2]]" へ移動しました。',
);

$messages['eo'] = array(
	'renameuser' => 'Alinomigu uzanton',
	'renameuserold' => 'Aktuala uzantonomo:',
	'renameusernew' => 'Nova uzantonomo:',
	'renameuserreason' => 'Kialo por alinomigo:',
	'renameusermove' => 'Movu uzantan kaj diskutan paĝojn (kaj ties subpaĝojn) al la nova nomo',
	'renameusersubmit' => 'Ek',
	'renameusererrordoesnotexist' => 'La uzanto "<nowiki>$1</nowiki>" ne ekzistas',
	'renameusererrorexists' => 'La uzanto "<nowiki>$1</nowiki>" jam ekzistas',
	'renameusererrorinvalid' => 'La uzantonomo "<nowiki>$1</nowiki>" estas malvalida',
	'renameusererrortoomany' => 'La uzanto "<nowiki>$1</nowiki>" havas $2 kontribuojn. Alinamigo de uzanto kun pli ol $3 kontribuoj povus malbone influi paĝaran funkciadon',
	'renameusersuccess' => 'La uzanto "<nowiki>$1</nowiki>" estas alinomita al "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'La paĝo $1 jam ekzistas kaj ne povas esti aŭtomate anstataŭata.',
	'renameuser-page-moved' => 'La paĝo $1 estis movita al $2.',
	'renameuser-page-unmoved' => 'La paĝo $1 ne povis esti movita al $2.',
	'renameuserlogpage' => 'Uzantoalinomada loglibro

<!--aŭ: Loglibro pri alinomigoj de uzantoj-->',
	'renameuserlogpagetext' => 'Ĉi tio estas loglibro pri ŝanĝoj de uzantonomoj',
	'renameuser-log' => '$1 redaktoj. Kialo: $2',
	'renameuser-move-log' => 'Aŭtomate movis paĝon dum alinomigo de la uzanto "[[User:$1|$1]]" al "[[User:$2|$2]]"',
);

$messages['es'] = array(
	'renameuser' => 'Renombrar usuario',
	'renameuserold' => 'Nombre actual:',
	'renameusernew' => 'Nuevo nombre de usuario:',
	'renameuserreason' => 'Motivo:',
	'renameusermove' => 'Trasladar las páginas de usuario y de discusión (y sus subpáginas) al nuevo nombre',
	'renameusersubmit' => 'Enviar',
	'renameusererrordoesnotexist' => 'El usuario «<nowiki>$1</nowiki>» no existe',
	'renameusererrorexists' => 'El usuario «<nowiki>$1</nowiki>» ya existe',
	'renameusererrorinvalid' => 'El nombre de usuario «<nowiki>$1</nowiki>» no es válido',
	'renameusererrortoomany' => 'El usuario «<nowiki>$1</nowiki>» tiene $2 contribuciones, cambiar el nombre de un usuario con más de $3 contribuciones podría afectar notablemente al rendimiento del sitio',
	'renameusersuccess' => 'El usuario «<nowiki>$1</nowiki>» ha sido renombrado a «<nowiki>$2</nowiki>»',
	'renameuser-page-exists' => 'La página $1 ya existe y no puede ser reemplazada automáticamente.',
	'renameuser-page-moved' => 'La página $1 ha sido trasladada a $2.',
	'renameuser-page-unmoved' => 'La página $1 no pudo ser trasladada a $2.',
	'renameuserlogpage' => 'Registro de cambios de nombre de usuarios',
	'renameuserlogpagetext' => 'Este es un registro de cambios de nombres de usuarios',
	'renameuserlogentry' => 'ha renombrado a $1 a [[Usuario:$2]]',
	'renameuser-log' => '$1 ediciones. Motivo: $2',
	'renameuser-move-log' => 'Página trasladada automáticamente al renombrar al usuario "[[User:$1|$1]]" a "[[User:$2|$2]]"',
);

$messages['et'] = array(
	'renameuser' => 'Muuda kasutajanime',
	'renameuserold' => 'Praegune kasutajanimi:',
	'renameusernew' => 'Uus kasutajanimi:',
);

$messages['ext'] = array(
	'renameuser-page-moved' => 'S´á moviu la páhina $1 a $2.',
);

$messages['fa'] = array(
	'renameuser' => 'تغییر نام کاربری',
	'renameuserold' => 'نام کاربری فعلی:',
	'renameusernew' => 'نام کاربری جدید:',
	'renameuserreason' => 'علت تغییر نام کاربری:',
	'renameusermove' => 'صفحه کاربر و صفحه بحث کاربر (و زیر صفحه‌های آن‌ها) را به نام جدید انتقال بده',
	'renameusersubmit' => 'ثبت',
	'renameusererrordoesnotexist' => 'نام کاربری «<nowiki>$1</nowiki>» وجود ندارد',
	'renameusererrorexists' => 'نام کاربری «<nowiki>$1</nowiki>» استفاده شده‌است',
	'renameusererrorinvalid' => 'نام کاربری «<nowiki>$1</nowiki>» غیر مجاز است',
	'renameusererrortoomany' => 'کاربر «<nowiki>$1</nowiki>» دارای $2 مشارکت است؛ تغییر نام کاربران با بیش از $3 ویرایش ممکن است عملکرد وبگاه را دچار مشکل کند.',
	'renameusersuccess' => 'نام کاربر «<nowiki>$1</nowiki>» به «<nowiki>$2</nowiki>» تغییر یافت.',
	'renameuser-page-exists' => 'صفحهٔ $1 از قبل وجود داشته و به طور خودکار قابل بازنویسی نیست.',
	'renameuser-page-moved' => 'صفحهٔ $1 به $2 انتقال داده شد.',
	'renameuser-page-unmoved' => 'امکان انتقال صفحهٔ $1 به $2 وجود ندارد.',
	'renameuserlogpage' => 'سیاهه تغییر نام کاربر',
	'renameuserlogpagetext' => 'این سیاههٔ تغییر نام کاربران است',
	'renameuserlogentry' => 'نام $1 را به $2 تغییر داد',
	'renameuser-log' => '$1 ویرایش. دلیل: $2',
	'renameuser-move-log' => 'صفحه در ضمن تغییر نام «[[User:$1|$1]]» به «[[User:$2|$2]]» به طور خودکار انتقال داده شد.',
);

$messages['fi'] = array(
	'renameuser' => 'Käyttäjätunnuksen vaihto',
	'renameuserold' => 'Nykyinen tunnus',
	'renameusernew' => 'Uusi tunnus',
	'renameuserreason' => 'Kommentti',
	'renameusermove' => 'Siirrä käyttäjä- ja keskustelusivut alasivuineen uudelle nimelle',
	'renameusersubmit' => 'Nimeä',
	'renameusererrordoesnotexist' => 'Tunnusta ”<nowiki>$1</nowiki>” ei ole',
	'renameusererrorexists' => 'Tunnus ”<nowiki>$1</nowiki>” on jo olemassa',
	'renameusererrorinvalid' => 'Tunnus ”<nowiki>$1</nowiki>” ei ole kelvollinen',
	'renameusererrortoomany' => 'Tunnuksella ”<nowiki>$1</nowiki>” on $2 muokkausta. Tunnuksen, jolla on yli $3 muokkausta, vaihtaminen voi haitata sivuston suorituskykyä.',
	'renameusersuccess' => 'Käyttäjän ”<nowiki>$1</nowiki>” tunnus on nyt ”<nowiki>$2</nowiki>”.',
	'renameuser-page-exists' => 'Sivu $1 on jo olemassa eikä sitä korvattu.',
	'renameuser-page-moved' => 'Sivu $1 siirrettiin nimelle $2.',
	'renameuser-page-unmoved' => 'Sivun $1 siirtäminen nimelle $2 ei onnistunut.',
	'renameuserlogpage' => 'Tunnusten vaihdot',
	'renameuserlogpagetext' => 'Tämä on loki käyttäjätunnuksien vaihdoista.',
	'renameuserlogentry' => 'on nimennyt käyttäjän $1 käyttäjäksi [[User:$2|$2]]',
	'renameuser-log' => 'Tehnyt $1 muokkausta. $2”',
	'renameuser-move-log' => 'Siirretty automaattisesti tunnukselta ”[[User:$1|$1]]” tunnukselle ”[[User:$2|$2]]”',
);

$messages['fo'] = array(
	'renameusernew' => 'Nýtt brúkaranavn:',
);

/** French (Français)
 * @author Hégésippe Cormier
 */
$messages['fr'] = array(
	'renameuser'                  => 'Renommer l’utilisateur',
	'renameuserold'               => 'Nom actuel de l’utilisateur :',
	'renameusernew'               => 'Nouveau nom de l’utilisateur :',
	'renameuserreason'            => 'Motif du renommage :',
	'renameusermove'              => 'Déplacer toutes les pages de l’utilisateur vers le nouveau nom',
	'renameusersubmit'            => 'Soumettre',
	'renameusererrordoesnotexist' => 'L’utilisateur « <nowiki>$1</nowiki> » n’existe pas',
	'renameusererrorexists'       => 'L’utilisateur « <nowiki>$1</nowiki> » existe déjà',
	'renameusererrorinvalid'      => 'Le nom d’utilisateur « <nowiki>$1</nowiki> » n’est pas valide',
	'renameusererrortoomany'      => 'L’utilisateur « <nowiki>$1</nowiki> » a $2 contributions. Renommer un utilisateur ayant plus de $3 contributions à son actif peut affecter les performances du site.',
	'renameusersuccess'           => 'L’utilisateur « <nowiki>$1</nowiki> » a été renommé « <nowiki>$2</nowiki> »',
	'renameuser-page-exists'      => 'La page $1 existe déjà et ne peut pas être automatiquement remplacée.',
	'renameuser-page-moved'       => 'La page $1 a été déplacée vers $2.',
	'renameuser-page-unmoved'     => 'La page $1 ne peut pas être renommée en $2.',
	'renameuserlogpage'           => 'Historique des renommages d’utilisateur',
	'renameuserlogpagetext'       => "Ceci est l’historique des changements de noms d'utilisateur",
	'renameuserlogentry'          => 'a renommé $1 vers $2',
	'renameuser-log'              => '$1 éditions. Motif : $2',
	'renameuser-move-log'         => 'Page automatiquement déplacée lors du renommage de l’utilisateur "[[Utilisateur:$1|$1]]" en "[[Utilisateur:$2|$2]]"',
);

/** Irish (Gaeilge)
 * @author SPQRobin
 */
$messages['ga'] = array(
	'renameuser'             => 'Athainmnigh úsáideoir',
	'renameuserold'          => 'Ainm reatha úsáideora:',
	'renameusernew'          => 'Ainm nua úsáideora:',
	'renameusersuccess'      => 'Athainmníodh úsáideoir "<nowiki>$1</nowiki>" mar "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'Tá leathanach "$1" ann chean féin; ní féidir ábhar a scríobh thairis go huathoibríoch.',
);

$messages['gl'] = array(
	'renameuser' => 'Mudar o nome de usuario',
	'renameuserold' => 'Nome de usuario actual:',
	'renameusernew' => 'Novo nome de usuario:',
	'renameuserreason' => 'Razón para mudar o nome:',
	'renameusermove' => 'Mover usuario e páxinas de talk (e as súas subpáxinas) a un novo nome',
	'renameusersubmit' => 'Presentar',
	'renameusererrordoesnotexist' => 'O usuario "<nowiki>$1</nowiki>" non existe',
	'renameusererrorexists' => 'O usuario "<nowiki>$1</nowiki>"  xa existe',
	'renameusererrorinvalid' => 'O nome de usuario "<nowiki>$1</nowiki>" non é válido',
	'renameusererrortoomany' => 'O usuario "<nowiki>$1</nowiki>" ten $2 contribucións, mudando o nome dun usuario con máis de $3 contribucións podería afectar negativamente á execución do sitio',
	'renameusersuccess' => 'O usuario "<nowiki>$1</nowiki>" mudou o nome a "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'A páxina $1 xa existe e non pode ser automaticamente sobreescrita.',
	'renameuser-page-moved' => 'A páxina $1 foi movida a $2.',
	'renameuser-page-unmoved' => 'A páxina $1 non pode ser movida a $2.',
	'renameuserlogpage' => 'Rexistro de usuarios que mudaron o nome',
	'renameuserlogpagetext' => 'Este é un rexistro dos cambios dos nomes de usuarios',
	'renameuserlogentry' => 'mudou o nome $1 a $2',
	'renameuser-log' => '$1 edicións. Razón: $2',
	'renameuser-move-log' => 'A páxina moveuse automaticamente cando se mudou o nome do usuario "[[User:$1|$1]]" a "[[User:$2|$2]]"',
);

$messages['he'] = array(
	'renameuser'       => 'שינוי שם משתמש',
	'renameuserold'    => 'שם משתמש נוכחי:',
	'renameusernew'    => 'שם משתמש חדש:',
	'renameuserreason' => 'סיבה לשינוי השם:',
	'renameusermove'   => 'העבר את דפי המשתמש והשיחה (כולל דפי המשנה שלהם) לשם החדש',
	'renameusersubmit' => 'שנה שם משתמש',

	'renameusererrordoesnotexist' => 'המשתמש "<nowiki>$1</nowiki>" אינו קיים.',
	'renameusererrorexists'       => 'המשתמש "<nowiki>$1</nowiki>" כבר קיים.',
	'renameusererrorinvalid'      => 'שם המשתמש "<nowiki>$1</nowiki>" אינו תקין.',
	'renameusererrortoomany'      => 'למשתמש "<nowiki>$1</nowiki>" יש $2 תרומות; שינוי שם משתמש של משתמש עם יותר מ־$3 תרומות עלול להשפיע לרעה על ביצועי האתר.',
	'renameusersuccess'           => 'שם המשתמש של "<nowiki>$1</nowiki>" שונה לשם "<nowiki>$2</nowiki>"',

	'renameuser-page-exists'  => 'הדף $1 כבר קיים ולא ניתן לדרוס אותו אוטומטית.',
	'renameuser-page-moved'   => 'הדף $1 הועבר לשם $2.',
	'renameuser-page-unmoved' => 'אי אפשר היה להעביר את הדף $1 לשם $2.',

	'renameuserlogpage'     => 'יומן שינויי שמות משתמש',
	'renameuserlogpagetext' => 'זהו יומן השינויים בשמות המשתמשים.',
	'renameuserlogentry'    => 'שינה את שם המשתמש "$1" לשם "$2"',
	'renameuser-log'        => '$1 עריכות. סיבה: $2',
	'renameuser-move-log'   => 'העברה אוטומטית בעקבות שינוי שם המשתמש "[[{{ns:user}}:$1|$1]]" לשם "[[{{ns:user:}}:$2|$2]]"',
);

$messages['hr'] = array(
	'renameuser' => 'Promijeni ime suradnika',
	'renameuserold' => 'Trenutno suradničko ime:',
	'renameusernew' => 'Novo suradničko ime:',
	'renameuserreason' => 'Razlog za promjenu imena:',
	'renameusermove' => 'Premjesti suradnikove stranice (glavnu, stranicu za razgovor i podstranice, ako postoje) na novo ime',
	'renameusersubmit' => 'Potvrdi',
	'renameusererrordoesnotexist' => 'Suradnik "<nowiki>$1</nowiki>" ne postoji (suradničko ime nije zauzeto).',
	'renameusererrorexists' => 'Suradničko ime "<nowiki>$1</nowiki>" već postoji',
	'renameusererrorinvalid' => 'Suradničko ime "<nowiki>$1</nowiki>" nije valjano',
	'renameusererrortoomany' => 'Suradnik "<nowiki>$1</nowiki>" ima $2 uređivanja, preimenovanje suradnika s više od $3 uređivanja moglo bi usporiti ovaj wiki',
	'renameusersuccess' => 'Suradnik "<nowiki>$1</nowiki>" je preimenovan u "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'Stranica $1 već postoji i ne može biti prepisana.',
	'renameuser-page-moved' => 'Suradnikova stranica $1 je premještena, sad se zove: $2.',
	'renameuser-page-unmoved' => 'Stranica $1 ne može biti preimenovana u $2.',
	'renameuserlogpage' => 'Evidencija preimenovanja suradnika',
	'renameuserlogpagetext' => 'Ovo je evidencija promjena suradničkih imena',
	'renameuserlogentry' => 'je promijenio suradničko ime $1 u $2',
	'renameuser-log' => '$1 uređivanja. Razlog: $2',
	'renameuser-move-log' => 'Stranica suradnika je premještena prilikom promjena imena iz "[[User:$1|$1]]" u "[[User:$2|$2]]"',
);

$messages['hsb'] = array(
	'renameuser' => 'Wužiwarja přemjenować',
	'renameuserold' => 'Tuchwilne wužiwarske mjeno:',
	'renameusernew' => 'Nowe wužiwarske mjeno:',
	'renameuserreason' => 'Přičina za přemjenowanje:',
	'renameusermove' => 'Wužiwarsku stronu a wužiwarsku diskusiju (a jeju podstrony) na nowe mjeno přesunyć',
	'renameusersubmit' => 'Składować',
	'renameusererrordoesnotexist' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ njeeksistuje.',
	'renameusererrorexists' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ hižo eksistuje.',
	'renameusererrorinvalid' => 'Wužiwarske mjeno „<nowiki>$1</nowiki>“ njeje płaćiwe.',
	'renameusererrortoomany' => 'Wužiwar „<nowiki>$1</nowiki>“ je $2 wobdźěłanjow sčinił. Přemjenowanje wužiwarja z wjace hač $3 wobdźěłanjemi móže so njepřihódnje na wukonitosć serwera wuskutkować.',
	'renameusersuccess' => 'Wužiwar „<nowiki>$1</nowiki>“ bu wuspěšnje na „<nowiki>$2</nowiki>“ přemjenowany.',
	'renameuser-page-exists' => 'Strona $1 hižo eksistuje a njemóže so awtomatisce přepisować.',
	'renameuser-page-moved' => 'Strona $1 bu pod nowy titul $2 přesunjena.',
	'renameuser-page-unmoved' => 'Njemóžno stronu $1 pod titul $2 přesunyć.',
	'renameuserlogpage' => 'Protokol přemjenowanja wužiwarjow',
	'renameuserlogpagetext' => 'Tu protokoluja so wšě přemjenowanja wužiwarjow.',
	'renameuserlogentry' => 'je $1 do [[User:$2]] přemjenował',
	'renameuser-log' => 'z $1 wobdźěłanjemi. $2',
	'renameuser-move-log' => 'Přez přemjenowanje wužiwarja „[[{{ns:user}}:$1|$1]]“ na „[[{{ns:user}}:$2|$2]]“ awtomatisce přesunjena strona.',
);

$messages['hu'] = array(
	'renameuser'       => 'Szerkesztő átnevezése',

	'renameusererrordoesnotexist' => '„<nowiki>$1</nowiki>” nevű szerkesztő nem létezik',
	'renameusererrorexists'       => '„<nowiki>$1</nowiki>” nevű szerkesztő már létezik',
	'renameusererrorinvalid'      => 'A „<nowiki>$1</nowiki>” felhasználónév hibás',

	'renameuser-page-exists'         => '$1 már létezik és nem lehet automatikusan felülírni.',
	'renameuser-page-moved'          => '$1 átmozgatva a következőre: $2.',
	'renameuser-page-unmoved'        => '$1-t nem lehet átnevezni a következőre: $2.',

	'renameuserlogpage'     => 'Felhasználó-átnevezési napló',
	'renameuser-move-log'   => '„[[User:$1|$1]]” „[[User:$2|$2]]”-re való átnevezése közben automatikusan átnevezett oldal',
);

$messages['id'] = array(
	'renameuser'       => 'Penggantian nama pengguna',
	'renameuserold'    => 'Nama sekarang:',
	'renameusernew'    => 'Nama baru:',
	'renameusermove'   => 'Pindahkan halaman pengguna dan pembicaraannya (berikut subhalamannya) ke nama baru',
	'renameusersubmit' => 'Simpan',

	'renameusererrordoesnotexist' => 'Pengguna "<nowiki>$1</nowiki>" tidak ada',
	'renameusererrorexists'       => 'Pengguna "<nowiki>$1</nowiki>" telah ada',
	'renameusererrorinvalid'      => 'Nama pengguna "<nowiki>$1</nowiki>" tidak sah',
	'renameusererrortoomany'      => 'Pengguna "<nowiki>$1</nowiki>" telah memiliki $2 suntingan. Penggantian nama pengguna dengan lebih dari $3 suntingan dapat mempengaruhi kinerja situs',
	'renameusersuccess'           => 'Pengguna "<nowiki>$1</nowiki>" telah diganti namanya menjadi "<nowiki>$2</nowiki>"',

	'renameuser-page-exists'         => 'Halaman $1 telah ada dan tidak dapat ditimpa secara otomatis.',
	'renameuser-page-moved'          => 'Halaman $1 telah dipindah ke $2.',
	'renameuser-page-unmoved'        => 'Halaman $1 tidak dapat dipindah ke $2.',

	'renameuserlogpage'     => 'Log penggantian nama pengguna',
	'renameuserlogpagetext' => 'Di bawah ini adalah log penggantian nama pengguna',
	'renameuser-log'        => 'yang telah memiliki $1 suntingan. $2',
	'renameuser-move-log'   => 'Secara otomatis memindahkan halaman sewaktu mengganti nama pengguna "[[User:$1|$1]]" menjadi "[[User:$2|$2]]"',
);

$messages['is'] = array(
	'renameuser' => 'Breyta notandanafni',
	'renameuserold' => 'Núverandi notandanafn:',
	'renameusernew' => 'Nýja notandanafnið:',
	'renameusererrordoesnotexist' => 'Notandinn „<nowiki>$1</nowiki>“ er ekki til',
	'renameusererrorexists' => 'Notandinn „<nowiki>$1</nowiki>“ er nú þegar til',
	'renameusererrorinvalid' => 'Notandanafnið „<nowiki>$1</nowiki>“ er ógilt',
	'renameuser-page-exists' => 'Síða sem heitir $1 er nú þegar til og það er ekki hægt að búa til nýja grein með sama heiti.',
	'renameuser-page-moved' => 'Síðan $1 hefur verið færð á $2.',
	'renameuser-page-unmoved' => 'Ekki var hægt að færa síðuna $1 á $2.',
	'renameuserlogpage' => 'Skrá yfir nafnabreytingar notenda',
	'renameuserlogpagetext' => 'Þetta er skrá yfir nýlegar breytingar á notendanöfnum.',
);

$messages['it'] = array(
	'renameuser' => 'Modifica del nome utente',
	'renameuserold' => 'Nome utente attuale:',
	'renameusernew' => 'Nuovo nome utente:',
	'renameuserreason' => 'Motivo del cambio nome',
	'renameusermove' => 'Rinomina anche la pagina utente, la pagina di discussione e le relative sottopagine',
	'renameusersubmit' => 'Invia',
	'renameusererrordoesnotexist' => 'Il nome utente "<nowiki>$1</nowiki>" non esiste',
	'renameusererrorexists' => 'Il nome utente "<nowiki>$1</nowiki>" esiste già',
	'renameusererrorinvalid' => 'Il nome utente "<nowiki>$1</nowiki>" non è valido',
	'renameusererrortoomany' => 'Il nome utente "<nowiki>$1</nowiki>" ha $2 contributi. Modificare il nome di un utente con più di $3 contributi potrebbe incidere negativamente sulle prestazioni del sito',
	'renameusersuccess' => 'Il nome utente "<nowiki>$1</nowiki>" è stato modificato in "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'La pagina $1 esiste già; impossibile sovrascriverla automaticamente.',
	'renameuser-page-moved' => 'La pagina $1 è stata spostata a $2.',
	'renameuser-page-unmoved' => 'Impossibile spostare la pagina $1 a $2.',
	'renameuserlogpage' => 'Utenti rinominati',
	'renameuserlogpagetext' => 'Di seguito viene presentato il registro delle modifiche ai nomi utente',
	'renameuserlogentry' => 'ha rinominato $1 in [[Utente:$2]]',
	'renameuser-log' => 'Che ha $1 contributi. $2',
	'renameuser-move-log' => 'Spostamento automatico della pagina - utente rinominato da "[[User:$1|$1]]" a "[[User:$2|$2]]"',
);
$messages['ja'] = array(
	'renameuser' => '利用者名の変更',
	'renameuserold' => '現在の利用者名:',
	'renameusernew' => '新しい利用者名:',
	'renameusermove' => '利用者ページと会話ページ及びそれらのサブページを新しい名前に移動する',
	'renameusersubmit' => '変更',
	'renameusererrordoesnotexist' => '利用者 “<nowiki>$1</nowiki>” は存在しません。',
	'renameusererrorexists' => '利用者 “<nowiki>$1</nowiki>” は既に存在しています。',
	'renameusererrorinvalid' => '利用者名 “<nowiki>$1</nowiki>” は無効な値です。',
	'renameusererrortoomany' => '利用者 "<nowiki>$1</nowiki>" には $2 件の投稿履歴があります。$3 件以上の投稿履歴がある利用者の名前を変更すると、サイトのパフォーマンスに悪影響を及ぼす可能性があります。',
	'renameusersuccess' => '利用者 "[[User:$1|$1]]" を "[[User:$2|$2]]" に変更しました。',
	'renameuser-page-exists' => '$1 が既に存在しているため、自動で上書きできませんでした。',
	'renameuser-page-moved' => '$1 を $2 に移動しました。',
	'renameuser-page-unmoved' => '$1 を $2 に移動できませんでした。',
	'renameuserlogpage' => '利用者名変更記録',
	'renameuserlogpagetext' => 'これは、利用者名の変更を記録したものです。',
	'renameuser-log' => '投稿数 $1回. $2',
	'renameuser-move-log' => '名前の変更と共に "[[User:$1|$1]]" を "[[User:$2|$2]]" へ移動しました。',
);

$messages['ka'] = array(
	'renameuser'       => 'მომხმარებლის სახელის გამოცვლა',
	'renameuserold'    => 'ამჟამინდელი მომხმარებლის სახელი:',
	'renameusernew'    => 'ახალი მომხმარებლის სახელი:',
	'renameusermove'   => 'მომხმარებლისა და განხილვის გვერდების (და მათი დაქვემდებარებული გვერდების) გადატანა ახალ დასახელებაზე',
	'renameusersubmit' => 'გაგზავნა',

	'renameusererrordoesnotexist' => 'მომხმარებელი "<nowiki>$1</nowiki>" არ არსებობს',
	'renameusererrorexists'       => 'მომხმარებელი "<nowiki>$1</nowiki>" უკვე არსებობს',
	'renameusererrorinvalid'      => 'მომხმარებლის სახელი "<nowiki>$1</nowiki>" არასწორია',
	'renameusererrortoomany'      => 'მომხმარებელს "<nowiki>$1</nowiki>" გაკეთებული აქვს $2 რედაქცია. სახელის შეცვლამ მომხმარებლისათვის, რომელიც $3-ზე მეტ რედაქციას ითვლის, შესაძლოა ზიანი მიაყენოს საიტის ქმედითობას',
	'renameusersuccess'           => 'მომხმარებლის სახელი - "<nowiki>$1</nowiki>", შეიცვალა "<nowiki>$2</nowiki>"-ით',

	'renameuser-page-exists'         => 'გვერდი $1 უკვე არსებობს და მისი ავტომატურად შენაცვლება შეუძლებელია.',
	'renameuser-page-moved'          => 'გვერდი $1 გადატანილია $2-ზე.',
	'renameuser-page-unmoved'        => 'არ მოხერხდა გვერდის $1 გადატანა $2-ზე.',

	'renameuserlogpage'     => 'მომხმარებლის სახელის გადარქმევის რეგისტრაციის ჟურნალი',
	'renameuserlogpagetext' => 'ეს არის ჟურნალი, სადაც აღრიცხულია მომხმარებლის სახელთა ცვლილებები',
	'renameuser-log'        => 'რომელსაც გაკეთებული ჰქონდა $1 რედაქცია. $2',
	'renameuser-move-log'   => 'ავტომატურად იქნა გადატანილი გვერდი მომხმარებლის "[[{{ns:user}}:$1|$1]]" სახელის შეცვლისას "[[{{ns:user}}:$2|$2]]-ით"',
);

$messages['kk-cyrl'] = array(
	'renameuser'       => 'Қатысушыны қайта атау',
	'renameuserold'    => 'Ағымдағы қатысушы аты:',
	'renameusernew'    => 'Жаңа қатысушы аты:',
	'renameuserreason' => 'Қайта атау себебі:',
	'renameusermove'   => 'Қатысушының жеке және талқылау беттерін (және де олардың төменгі беттерін) жаңа атауға жылжыту',
	'renameusersubmit' => 'Жіберу',

	'renameusererrordoesnotexist' => '«<nowiki>$1</nowiki>» деген қатысушы жоқ',
	'renameusererrorexists'       => '«<nowiki>$1</nowiki>» деген қатысушы бар түге ',
	'renameusererrorinvalid'      => '«<nowiki>$1</nowiki>» қатысушы аты жарамсыз ',
	'renameusererrortoomany'      => '«<nowiki>$1</nowiki>» қатысушы $2 үлес берген, $3 арта үлесі бар қатысушыны қайта атауы торап өнімділігіне ықпал етеді',
	'renameusersuccess'           => '«<nowiki>$1</nowiki>» деген қатысушы аты «<nowiki>$2</nowiki>» дегенге ауыстырылды',

	'renameuser-page-exists'         => '$1 деген бет бар түге, және өздік түрде оның үстіне ештеңе жазылмайды.',
	'renameuser-page-moved'          => '$1 деген бет $2 деген бетке жылжытылды.',
	'renameuser-page-unmoved'        => '$1 деген бет $2 деген бетке жылжытылмады.',

	'renameuserlogpage'     => 'Қатысушыны қайта атау журналы',
	'renameuserlogpagetext' => 'Бұл қатысушы атындағы өзгерістер журналы',
	'renameuserlogentry'    => '$1 атауын $2 дегенге өзгертті',
	'renameuser-log'        => '$1 түзетуі бар. $2',
	'renameuser-move-log'   => '«[[{{ns:user}}:$1|$1]]» деген қатысушы атын «[[{{ns:user}}:$2|$2]]» дегенге ауысқанда бет өздік түрде жылжытылды',
);

$messages['kk-latn'] = array(
	'renameuser'       => 'Qatıswşını qaýta ataw',
	'renameuserold'    => 'Ağımdağı qatıswşı atı:',
	'renameusernew'    => 'Jaña qatıswşı atı:',
	'renameuserreason' => 'Qaýta ataw sebebi:',
	'renameusermove'   => 'Qatıswşınıñ jeke jäne talqılaw betterin (jäne de olardıñ tömengi betterin) jaña atawğa jıljıtw',
	'renameusersubmit' => 'Jiberw',

	'renameusererrordoesnotexist' => '«<nowiki>$1</nowiki>» degen qatıswşı joq',
	'renameusererrorexists'       => '«<nowiki>$1</nowiki>» degen qatıswşı bar tüge ',
	'renameusererrorinvalid'      => '«<nowiki>$1</nowiki>» qatıswşı atı jaramsız ',
	'renameusererrortoomany'      => '«<nowiki>$1</nowiki>» qatıswşı $2 üles bergen, $3 arta ülesi bar qatıswşını qaýta atawı torap önimdiligine ıqpal etedi',
	'renameusersuccess'           => '«<nowiki>$1</nowiki>» degen qatıswşı atı «<nowiki>$2</nowiki>» degenge awıstırıldı',

	'renameuser-page-exists'         => '$1 degen bet bar tüge, jäne özdik türde onıñ üstine eşteñe jazılmaýdı.',
	'renameuser-page-moved'          => '$1 degen bet $2 degen betke jıljıtıldı.',
	'renameuser-page-unmoved'        => '$1 degen bet $2 degen betke jıljıtılmadı.',

	'renameuserlogpage'     => 'Qatıswşını qaýta ataw jwrnalı',
	'renameuserlogpagetext' => 'Bul qatıswşı atındağı özgerister jwrnalı',
	'renameuserlogentry'    => '$1 atawın $2 degenge özgertti',
	'renameuser-log'        => '$1 tüzetwi bar. $2',
	'renameuser-move-log'   => '«[[{{ns:user}}:$1|$1]]» degen qatıswşı atın «[[{{ns:user}}:$2|$2]]» degenge awısqanda bet özdik türde jıljıtıldı',
);

$messages['kk-arab'] = array(
	'renameuser'       => 'قاتىسۋشىنى قايتا اتاۋ',
	'renameuserold'    => 'اعىمداعى قاتىسۋشى اتى:',
	'renameusernew'    => 'جاڭا قاتىسۋشى اتى:',
	'renameuserreason' => 'قايتا اتاۋ سەبەبٸ:',
	'renameusermove'   => 'قاتىسۋشىنىڭ جەكە جٵنە تالقىلاۋ بەتتەرٸن (جٵنە دە ولاردىڭ تٶمەنگٸ بەتتەرٸن) جاڭا اتاۋعا جىلجىتۋ',
	'renameusersubmit' => 'جٸبەرۋ',

	'renameusererrordoesnotexist' => '«<nowiki>$1</nowiki>» دەگەن قاتىسۋشى جوق',
	'renameusererrorexists'       => '«<nowiki>$1</nowiki>» دەگەن قاتىسۋشى بار تٷگە ',
	'renameusererrorinvalid'      => '«<nowiki>$1</nowiki>» قاتىسۋشى اتى جارامسىز ',
	'renameusererrortoomany'      => '«<nowiki>$1</nowiki>» قاتىسۋشى $2 ٷلەس بەرگەن, $3 ارتا ٷلەسٸ بار قاتىسۋشىنى قايتا اتاۋى توراپ ٶنٸمدٸلٸگٸنە ىقپال ەتەدٸ',
	'renameusersuccess'           => '«<nowiki>$1</nowiki>» دەگەن قاتىسۋشى اتى «<nowiki>$2</nowiki>» دەگەنگە اۋىستىرىلدى',

	'renameuser-page-exists'         => '$1 دەگەن بەت بار تٷگە, جٵنە ٶزدٸك تٷردە ونىڭ ٷستٸنە ەشتەڭە جازىلمايدى.',
	'renameuser-page-moved'          => '$1 دەگەن بەت $2 دەگەن بەتكە جىلجىتىلدى.',
	'renameuser-page-unmoved'        => '$1 دەگەن بەت $2 دەگەن بەتكە جىلجىتىلمادى.',
	'renameuserlogentry'    => '$1 اتاۋىن $2 دەگەنگە ٶزگەرتتٸ',
	'renameuserlogpage'     => 'قاتىسۋشىنى قايتا اتاۋ جۋرنالى',
	'renameuserlogpagetext' => 'بۇل قاتىسۋشى اتىنداعى ٶزگەرٸستەر جۋرنالى',

	'renameuser-log'        => '$1 تٷزەتۋٸ بار. $2',
	'renameuser-move-log'   => '«[[{{ns:user}}:$1|$1]]» دەگەن قاتىسۋشى اتىن «[[{{ns:user}}:$2|$2]]» دەگەنگە اۋىسقاندا بەت ٶزدٸك تٷردە جىلجىتىلدى',
);

$messages['kn'] = array(
	'renameuser' => 'ಸದಸ್ಯರನ್ನು ಮರುನಾಮಕರಣ ಮಾಡಿ',
);

$messages['ko'] = array(
	'renameuser'       => '사용자 이름 변경',
	'renameuserold'    => '기존 사용자 이름:',
	'renameusernew'    => '새 이름:',
	'renameusermove'   => '사용자 문서와 토론 문서, 하위 문서를 새 사용자 이름으로 이동하기',
	'renameusersubmit' => '변경',
	'renameusererrordoesnotexist' => '‘<nowiki>$1</nowiki>’ 사용자가 존재하지 않습니다.',
	'renameusererrorexists'       => '‘<nowiki>$1</nowiki>’ 사용자가 이미 존재합니다.',
	'renameusererrorinvalid'      => '‘<nowiki>$1</nowiki>’ 사용자 이름이 잘못되었습니다.',
	'renameusererrortoomany'      => '‘<nowiki>$1</nowiki>’ 사용자는 $2번의 기여를 했습니다. $3번을 넘는 기여를 한 사용자의 이름을 변경하는 것은 성능 저하를 일으킬 수 있습니다.',
	'renameusersuccess'           => '‘<nowiki>$1</nowiki>’ 사용자가 ‘<nowiki>$2</nowiki>’(으)로 변경되었습니다.',
	'renameuser-page-exists'         => '$1 문서가 이미 존재하여 자동으로 이동하지 못했습니다.',
	'renameuser-page-moved'          => '$1 문서를 $2(으)로 이동했습니다.',
	'renameuser-page-unmoved'        => '$1 문서를 $2(으)로 이동하지 못했습니다.',
	'renameuserlogpage'     => '이름 변경 기록',
	'renameuserlogpagetext' => '사용자 이름 변경 기록입니다.',
	'renameuser-log'        => '$1개의 기여. $2',
	'renameuser-move-log'   => '‘[[User:$1|$1]]’ 사용자를 ‘[[User:$2|$2]]’(으)로 바꾸면서 문서를 자동으로 이동함',
);

$messages['ku'] = array(
	'renameuser'        => 'Navî bikarhênerê biguherîne',
	'renameuserold'     => 'Navî niha:',
	'renameusernew'     => 'Navî nuh:',
	'renameusersuccess' => 'Navî bikarhênerê "<nowiki>$1</nowiki>" bû "<nowiki>$2</nowiki>"',
	'renameusersubmit'  => 'Bike',
	'renameuser-log'    => 'yê $1 beşdarîyên xwe hebû. $2',
);

$messages['la'] = array(
	'renameuser' => 'Usorem renominare',
	'renameuserold' => 'Praesente nomen usoris:',
	'renameusernew' => 'Novum nomen usoris:',
	'renameuserreason' => 'Causa renominationis:',
	'renameusermove' => 'Movere paginas usoris et disputationis (et subpaginae) in nomen novum',
	'renameusersubmit' => 'Renominare',
	'renameusererrordoesnotexist' => 'Usor "<nowiki>$1</nowiki>" non existit',
	'renameusererrorexists' => 'Usor "<nowiki>$1</nowiki>" iam existit',
	'renameusererrorinvalid' => 'Nomen usoris "<nowiki>$1</nowiki>" irritum est',
	'renameusererrortoomany' => 'Usor "<nowiki>$1</nowiki>" $2 recensiones fecit. Usorem plus quam $3 recensiones habentem renominando hoc vici lentescere potest.',
	'renameusersuccess' => 'Usor "<nowiki>$1</nowiki>" renominatus est in "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'Pagina $1 iam existit et non potest automatice deleri.',
	'renameuser-page-moved' => 'Pagina $1 mota est ad $2.',
	'renameuser-page-unmoved' => 'Pagina $1 ad $2 moveri non potuit.',
	'renameuserlogpage' => 'Index renominationum usorum',
	'renameuserlogpagetext' => 'Hic est index renominationum usorum',
	'renameuserlogentry' => 'renominavit $1 in [[{{ns:user}}:$2]]',
	'renameuser-log' => '$1 recensiones. Causa: $2',
	'renameuser-move-log' => 'movit paginam automatice in renominando usorem "[[User:$1|$1]]" in "[[User:$2|$2]]"',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'renameuser'                  => 'Benotzer ëmbenennen',
	'renameuserold'               => 'Aktuelle Benotzernumm:',
	'renameusernew'               => 'Neie Benotzernumm:',
	'renameuserreason'            => "Grond fir d'Ëmbenennung:",
	'renameusermove'              => 'Benotzer- an Diskussiounssäiten (an déi jeweileg Ënnersäiten) op den neie Benotzernumm réckelen',
	'renameusersubmit'            => 'Ëmbenennen',
	'renameusererrordoesnotexist' => 'De Benotzer "<nowiki>$1</nowiki>" gëtt et net.',
	'renameusererrorexists'       => 'De Benotzer "<nowiki>$1</nowiki>" gët et schonn.',
	'renameusererrorinvalid'      => 'De Benotzernumm "<nowiki>$1</nowiki>" kann net benotzt ginn.',
	'renameusererrortoomany'      => 'De benotzer "<nowiki>$1</nowiki>" huet $2 Ännerunge gemaach. D¨¨annerung vum Benotzernumm vun engem Benotzer mat méi wéi $3 Ännerungen kann d\'Vitesse vum Site staark beaflossen (De Server gëtt lues).',
	'renameusersuccess'           => 'De Benotzer "<nowiki>$1</nowiki>" gouf "<nowiki>$2</nowiki>" ëmbenannt.',
	'renameuser-page-exists'      => "D'Säit $1 gëtt et schonns a kann net automatesch iwwerschriwwe ginn.",
	'renameuser-page-moved'       => "D'Säit $1 gouf op $2 geréckelt.",
	'renameuser-page-unmoved'     => "D'Säit $1 konnt net op $2 geréckelt ginn.",
	'renameuserlogpage'           => 'Logbuch vun den Ännerungen vum Benotzernumm',
	'renameuserlogpagetext'       => "An dësem Logbuch ginn d'Ännerungen vum Benotzernumm festgehal.",
	'renameuserlogentry'          => 'huet de Benotzer $1 als Benotzer $2 ëmbenannt',
	'renameuser-log'              => '$1 Ännerungen. Grond: $2',
	'renameuser-move-log'         => 'Duerch d\'Réckele vum Benotzer  "[[Benotzer:$1|$1]]" op "[[Benotzer:$2|$2]]" goufen déi folgend Säiten automatesch matgeréckelt:',
);

$messages['mk'] = array(
	'renameuser' => 'Преименувај корисник',
	'renameuserold' => 'Сегашно корисничко име:',
	'renameusernew' => 'Ново корисничко име:',
	'renameusersubmit' => 'Внеси',
	'renameusererrordoesnotexist' => 'Корисникот "<nowiki>$1</nowiki>" не постои',
	'renameusererrorexists' => 'Корисникот "<nowiki>$1</nowiki>" веќе постои',
	'renameusererrorinvalid' => 'Корисничкото име "<nowiki>$1</nowiki>" не е валидно',
	'renameusererrortoomany' => 'Корисникот "<nowiki>$1</nowiki>" има $2 придонеси, преименување на корисник со повеќе од $3 придонеси може негативно да се одрази на перформансите на сајтот',
	'renameusersuccess' => 'Корисникот "<nowiki>$1</nowiki>" е преименуван во "<nowiki>$2</nowiki>"',
	'renameuserlogpage' => 'Историја на преименувања на корисници',
	'renameuserlogpagetext' => 'Ово е историја на преименувања на корисници',
);

/** Latvian (Latviešu)
 * @author SPQRobin
 */
$messages['lv'] = array(
	'renameuserlogpage'     => 'Lietotāju pārdēvēšanas reģistrs',
	'renameuserlogpagetext' => 'Lietotājvārdu maiņas reģistrs',
);

$messages['nan'] = array(
	'renameuser'       => 'Kái iōng-chiá ê miâ',
	'renameuser-page-moved'          => '$1 í-keng sóa khì tī $2.',
	'renameuserlogpagetext' => 'Chit-ê log lia̍t-chhut kái-piàn iōng-chiá miâ-jī ê tōng-chok.',
);

$messages['nds'] = array(
	'renameuser' => 'Brukernaam ännern',
	'renameuserold' => 'Brukernaam nu:',
	'renameusernew' => 'Nee Brukernaam:',
	'renameusermove' => 'Brukersieden op’n ne’en Naam schuven',
	'renameusersubmit' => 'Ännern',
	'renameusererrordoesnotexist' => 'Bruker \'\'<nowiki>$1</nowiki>\'\' gifft dat nich',
	'renameusererrorexists' => 'Bruker \'\'<nowiki>$1</nowiki>\'\' gifft dat al',
	'renameusererrorinvalid' => 'Brukernaam \'\'<nowiki>$1</nowiki>\'\' geiht nich',
	'renameusererrortoomany' => 'Bruker \'\'<nowiki>$1</nowiki>\'\' hett $2 Bidrääg. Den Naam ännern kann bi Brukers mit mehr as $3 Bidrääg de Software lahm maken',
	'renameusersuccess' => 'Brukernaam \'\'<nowiki>$1</nowiki>\'\' op \'\'<nowiki>$2</nowiki>\'\' ännert',
	'renameuser-page-exists' => 'Siet $1 gifft dat al un kann nichautomaatsch överschreven warrn.',
	'renameuser-page-moved' => 'Siet $1 schaven na $2.',
	'renameuser-page-unmoved' => 'Siet $1 kunn nich na $2 schaven warrn.',
	'renameuserlogpage' => 'Ännerte-Brukernaams-Logbook',
	'renameuserlogpagetext' => 'Dit is dat Logbook för ännerte Brukernaams',
	'renameuser-move-log' => 'Siet bi dat Ännern vun’n Brukernaam \'\'[[{{ns:2}}:$1|$1]]\'\' na \'\'[[{{ns:2}}:$2|$2]]\'\' automaatsch schaven',
);

$messages['nl'] = array(
	'renameuser' => 'Gebruiker hernoemen',
	'renameuserold' => 'Huidige gebruikersnaam:',
	'renameusernew' => 'Nieuwe gebruikersnaam:',
	'renameuserreason' => 'Reden voor hernoemen:',
	'renameusermove' => 'De gebruikerspagina en overlegpagina (en eventuele subpagina\'s) hernoemen naar de nieuwe gebruikersnaam',
	'renameusersubmit' => 'Hernoemen',
	'renameusererrordoesnotexist' => 'De gebruiker "<nowiki>$1</nowiki>" bestaat niet.',
	'renameusererrorexists' => 'De gebruiker "<nowiki>$1</nowiki>" bestaat al.',
	'renameusererrorinvalid' => 'De gebruikersnaam "<nowiki>$1</nowiki>" is ongeldig.',
	'renameusererrortoomany' => 'De gebruiker "<nowiki>$1</nowiki>" heeft $2 bewerkingen gedaan; het hernoemen van een gebruiker met meer dan $3 bijdragen kan de prestaties van de site nadelig beïnvloeden',
	'renameusersuccess' => 'De gebruiker "<nowiki>$1</nowiki>" is hernoemd naar "<nowiki>$2</nowiki>".',
	'renameuser-page-exists' => 'De pagina $1 bestaat al en kan niet automatisch overschreven worden.',
	'renameuser-page-moved' => 'De pagina $1 is hernoemd naar $2.',
	'renameuser-page-unmoved' => 'De pagina $1 kon niet hernoemd worden naar $2.',
	'renameuserlogpage' => 'Logboek gebruikersnaamwijzigingen',
	'renameuserlogpagetext' => 'Hieronder staan gebruikersnamen die gewijzigd zijn',
	'renameuserlogentry' => 'heeft $1 hernoemd naar $2',
	'renameuser-log' => '$1 bewerkingen. $2',
	'renameuser-move-log' => 'Automatisch hernoemd bij het wijzigen van gebruiker "[[User:$1|$1]]" naar "[[User:$2|$2]]"',
);

/** Norwegian (‪Norsk (bokmål)‬)
 * @author Jon Harald Søby
 */
$messages['no'] = array(
	'renameuser'                  => 'Omdøp bruker',
	'renameuserold'               => 'Nåværende navn:',
	'renameusernew'               => 'Nytt brukernavn:',
	'renameuserreason'            => 'Grunn for omdøping:',
	'renameusermove'              => 'Flytt bruker- og brukerdiskusjonssider (og deres undersider) til nytt navn',
	'renameusersubmit'            => 'Omdøp',
	'renameusererrordoesnotexist' => 'Brukeren «<nowiki>$1</nowiki>» finnes ikke',
	'renameusererrorexists'       => 'Brukeren «<nowiki>$1</nowiki>» finnes allerede',
	'renameusererrorinvalid'      => 'Brukernavnet «<nowiki>$1</nowiki>» er ugyldig',
	'renameusererrortoomany'      => 'Brukeren «<nowiki>$1</nowiki>» har $2&nbsp;redigeringer. Å omdøpe brukere med mer enn $3&nbsp;redigeringer kan kunne påvirke sidens ytelse.',
	'renameusersuccess'           => 'Brukeren «<nowiki>$1</nowiki>» har blitt omdøpt til «<nowiki>$2</nowiki>»',
	'renameuser-page-exists'      => 'Siden $1 finnes allerede, og kunne ikke erstattes automatisk.',
	'renameuser-page-moved'       => 'Siden $1 har blitt flyttet til $2.',
	'renameuser-page-unmoved'     => 'Siden $1 kunne ikke flyttes til $2.',
	'renameuserlogpage'           => 'Omdøpingslogg',
	'renameuserlogpagetext'       => 'Dette er en logg over endringer i brukernavn.',
	'renameuserlogentry'          => 'har omdøpt $1 til $2',
	'renameuser-log'              => '$1 redigeringer. Grunn: $2',
	'renameuser-move-log'         => 'Flyttet side automatisk under omdøping av brukeren «[[User:$1|$1]]» til «[[User:$2|$2]]»',
);

$messages['oc'] = array(
	'renameuser' => 'Renomenar l\'utilizaire',
	'renameuserold' => 'Nom actual de l\'utilizaire :',
	'renameusernew' => 'Nom novèl de l\'utilizaire :',
	'renameuserreason' => 'Motiu del renomenatge :',
	'renameusermove' => 'Desplaçar totas las paginas de l’utilizaire vèrs lo nom novèl',
	'renameusersubmit' => 'Sometre',
	'renameusererrordoesnotexist' => 'Lo nom d\'utilizaire « <nowiki>$1</nowiki> » es pas valid',
	'renameusererrorexists' => 'Lo nom d\'utilizaire « <nowiki>$1</nowiki> » existís ja',
	'renameusererrorinvalid' => 'Lo nom d\'utilizaire « <nowiki>$1</nowiki> » existís pas',
	'renameusererrortoomany' => 'L\'utilizaire « <nowiki>$1</nowiki> » a $2 contribucions. Renomenar un utilizaire qu\'a mai de $3 contribucions a son actiu pòt afectar las performanças del siti.',
	'renameusersuccess' => 'L\'utilizaire « <nowiki>$1</nowiki> » es plan estat renomenat en « <nowiki>$2</nowiki> »',
	'renameuser-page-exists' => 'La pagina $1 existís ja e pòt pas èsser remplaçada automaticament.',
	'renameuser-page-moved' => 'La pagina $1 es estada desplaçada vèrs $2.',
	'renameuser-page-unmoved' => 'La pagina $1 pòt pas èsser renomenada en $2.',
	'renameuserlogpage' => 'Istoric dels renomenatges d\'utilizaire',
	'renameuserlogpagetext' => 'Aquò es l\'istoric dels cambiaments de nom dels utilizaires',
	'renameuserlogentry' => 'a renomenat $1 en $2',
	'renameuser-log' => 'qu\'aviá $1 edicions a son actiu. $2',
	'renameuser-move-log' => 'Pagina desplaçada automaticament al moment del renomenatge de l’utilizaire "[[Utilizaire:$1|$1]]" en "[[Utilizaire:$2|$2]]"',
);

$messages['pl'] = array(
	'renameuser' => 'Zmiana nazwy użytkownika',
	'renameuserold' => 'Obecna nazwa użytkownika:',
	'renameusernew' => 'Nowa nazwa użytkownika:',
	'renameuserreason' => 'Przyczyna zmiany nazwy:',
	'renameusermove' => 'Przeniesienie strony osobistej i strony dyskusji użytkownika (oraz ich podstron) pod nową nazwę użytkownika',
	'renameusersubmit' => 'Zmień',
	'renameusererrordoesnotexist' => 'Użytkownik "<nowiki>$1</nowiki>" nie istnieje',
	'renameusererrorexists' => 'Użytkownik "<nowiki>$1</nowiki>" już istnieje w bazie',
	'renameusererrorinvalid' => 'Niepoprawna nazwa użytkownika "<nowiki>$1</nowiki>"',
	'renameusererrortoomany' => 'Użytkownik "<nowiki>$1</nowiki>" ma $2 edycji. Zmiana nazwy użytkownika mającego powyżej $3 edycji może wpłynąć na wydajność serwisu.',
	'renameusersuccess' => 'Nazwa użytkownika "<nowiki>$1</nowiki>" została zmieniona na "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'Strona "$1" już istnieje i nie może być automatycznie nadpisana.',
	'renameuser-page-moved' => 'Strona "$1" została przeniesiona do "$2".',
	'renameuser-page-unmoved' => 'Strona "$1" nie mogła zostać przeniesiona do "$2".',
	'renameuserlogpage' => 'Zmiany nazw użytkowników',
	'renameuserlogpagetext' => 'To jest rejestr zmian nazw użytkowników',
	'renameuserlogentry' => 'zmieniono użytkownikowi $1 nazwę na [[User:$2|$2]]',
	'renameuser-log' => '$1 edycji. Powód: $2',
	'renameuser-move-log' => 'Automatyczne przeniesienie stron użytkownika po zmianie nazwy konta z "[[User:$1|$1]]" na "[[User:$2|$2]]"',
);

/* Piedmontese (Bèrto 'd Sèra) */
$messages['pms'] = array(
	'renameuser' => 'Arbatié n\'utent',
	'renameuserold' => 'Stranòm corent:',
	'renameusernew' => 'Stranòm neuv:',
	'renameuserreason' => 'Rason ch\'as cambia stranòm:',
	'renameusermove' => 'Tramuda ëdcò la pàgina utent e cola dle ciaciarade (con tute soe sotapàgine) a lë stranòm neuv',
	'renameusersubmit' => 'Falo',
	'renameusererrordoesnotexist' => 'A-i é pa gnun utent ch\'as ës-ciama "<nowiki>$1</nowiki>"',
	'renameusererrorexists' => 'N\'utent ch\'as ës-ciama "<nowiki>$1</nowiki>" a-i é già',
	'renameusererrorinvalid' => 'Lë stranòm "<nowiki>$1</nowiki>" a l\'é nen bon',
	'renameusererrortoomany' => 'L\'utent "<nowiki>$1</nowiki>" a l\'ha fait $2 modìfiche, ch\'a ten-a present che arbatié n\'utent ch\'a l\'abia pì che $3 modìfiche a podrìa feje un brut efet a le prestassion dël sit.',
	'renameusersuccess' => 'L\'utent "<nowiki>$1</nowiki>" a l\'é stait arbatià an "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'La pàgina $1 a-i é già e as peul nen passe-ie dzora n\'aotomàtich.',
	'renameuser-page-moved' => 'La pàgina $1 a l\'ha fait San Martin a $2.',
	'renameuser-page-unmoved' => 'La pàgina $1 a l\'é pa podusse tramudé a $2.',
	'renameuserlogpage' => 'Registr dj\'arbatiagi',
	'renameuserlogpagetext' => 'Sossì a l\'é un registr dle modìfiche djë stranòm dj\'utent',
	'renameuserlogentry' => 'a l\'ha arbatià $1 coma $2',
	'renameuser-log' => 'ch\'a l\'avìa $1 modìfiche. $2',
	'renameuser-move-log' => 'Pàgina utent tramudà n\'aotomàtich damëntrè ch\'as arbatiava "[[User:$1|$1]]" an "[[User:$2|$2]]"',
);

/** Portuguese (Português)
 * @author 555
 */
$messages['pt'] = array(
	'renameuser'                  => 'Renomear utilizador',
	'renameuserold'               => 'Nome de utilizador actual:',
	'renameusernew'               => 'Novo nome de utilizador:',
	'renameuserreason'            => 'Motivo de renomear:',
	'renameusermove'              => 'Mover as páginas de utilizador, páginas de discussão de utilizador e sub-páginas para o novo nome',
	'renameusersubmit'            => 'Enviar',
	'renameusererrordoesnotexist' => 'O utilizador "<nowiki>$1</nowiki>" não existe',
	'renameusererrorexists'       => 'O utilizador "<nowiki>$1</nowiki>" já existe',
	'renameusererrorinvalid'      => 'O nome de utilizador "<nowiki>$1</nowiki>" é inválido',
	'renameusererrortoomany'      => 'O utilizador "<nowiki>$1</nowiki>" possui $2 contribuições. Renomear um utilizador com mais de $3 contribuições pode afectar o desempenho do site',
	'renameusersuccess'           => 'O utilizador "<nowiki>$1</nowiki>" foi renomeado para "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'A página $1 atualmente já existe e não poderá ser sobre-escrita automaticamente.',
	'renameuser-page-moved'       => 'A página $1 foi movida com sucesso para $2.',
	'renameuser-page-unmoved'     => 'Não foi possível mover a página $1 para $2.',
	'renameuserlogpage'           => 'Registo de renomeação de utilizadores',
	'renameuserlogpagetext'       => 'Este é um registo de alterações efectuadas a nomes de utilizadores',
	'renameuserlogentry'          => 'renomeou $1 para $2',
	'renameuser-log'              => 'que possuia $1 edições. Motivo: $2',
	'renameuser-move-log'         => 'Foram movidas páginas de forma automática ao renomear o utilizador "[[User:$1|$1]]" para "[[User:$2|$2]]"',
);

$messages['rmy'] = array(
	'renameusersubmit' => 'De le jeneske aver nav',
);

$messages['ro'] = array(
	'renameuser' => 'Redenumeşte utilizator',
	'renameuserold' => 'Numele de utilizator existent:',
	'renameusernew' => 'Numele de utilizator nou:',
	'renameusermove' => 'Mută pagina de utilizator şi pagina de discuţii (şi subpaginile lor) la noul nume',
	'renameusersubmit' => 'Trimite',
	'renameusererrordoesnotexist' => 'Utilizatorul "$1" nu există',
	'renameusererrorexists' => 'Utilizatorul "$1" există deja',
	'renameusererrorinvalid' => 'Numele de utilizator "<nowiki>$1</nowiki>" este invalid',
	'renameusererrortoomany' => 'Utilizatorul "<nowiki>$1</nowiki>" are $2 contribuţii, redenumirea unui utilizator cu mai mult de $3 contribuţii ar putea afecta performanţa sitului',
	'renameusersuccess' => 'Utilizatorul "$1" a fost redenumit în "$2"',
	'renameuser-page-exists' => 'Pagina $1 există deja şi nu poate fi suprascrisă automat.',
	'renameuser-page-moved' => 'Pagina $1 a fost mutată la $2.',
	'renameuser-page-unmoved' => 'Pagina $1 nu poate fi mutată la $2.',
	'renameuserlogpage' => 'Raport redenumiri utilizatori',
	'renameuserlogpagetext' => 'Acesta este un raport al modificărilor de nume de utilizator',
	'renameuser-move-log' => 'Pagină mutată automat la redenumirea utilizatorului de la "[[Utilizator:$1|$1]]" la "[[Utilizator:$2|$2]]"',
);

/** Russian (Русский)
 * @author .:Ajvol:.
 */
$messages['ru'] = array(
	'renameuser'                  => 'Переименовать участника',
	'renameuserold'               => 'Имя в настоящий момент:',
	'renameusernew'               => 'Новое имя:',
	'renameuserreason'            => 'Причина переименования:',
	'renameusermove'              => 'Переименовать также страницу участника, личное обсуждение и их подстраницы',
	'renameusersubmit'            => 'Выполнить',
	'renameusererrordoesnotexist' => 'Участника с именем «<nowiki>$1</nowiki>» не зарегистрировано',
	'renameusererrorexists'       => 'Участник с именем «<nowiki>$1</nowiki>» уже зарегистрирован',
	'renameusererrorinvalid'      => 'Недопустимое имя участника: <nowiki>$1</nowiki>',
	'renameusererrortoomany'      => 'Участник <nowiki>$1</nowiki> внёс $2 правок, переименование участника с более чем $3 правками может оказать негативное влияние на доступ к сайту',
	'renameusersuccess'           => 'Участник «<nowiki>$1</nowiki>» был переименован в «<nowiki>$2</nowiki>»',
	'renameuser-page-exists'      => 'Страница $1 уже существует и не может быть перезаписана автоматически.',
	'renameuser-page-moved'       => 'Страница $1 была переименована в $2.',
	'renameuser-page-unmoved'     => 'Страница $1 не может быть переименована в $2.',
	'renameuserlogpage'           => 'Журнал переименований участников',
	'renameuserlogpagetext'       => 'Это журнал произведённых переименований зарегистрированных участников',
	'renameuserlogentry'          => 'переименовал $1 в [[$2]]',
	'renameuser-log'              => 'имеющий $1 правок. $2',
	'renameuser-move-log'         => 'Автоматически в связи с переименованием учётной записи «[[Участник:$1]]» в «[[Участник:$2]]»',
);

$messages['sk'] = array(
	'renameuser' => 'Premenovať používateľa',
	'renameuserold' => 'Súčasné používateľské meno:',
	'renameusernew' => 'Nové používateľské meno:',
	'renameuserreason' => 'Dôvod premenovania:',
	'renameusermove' => 'Presunúť používateľské a diskusné stránky (a ich podstránky) na nový názov',
	'renameusersubmit' => 'Odoslať',
	'renameusererrordoesnotexist' => 'Používateľ "<nowiki>$1</nowiki>" neexistuje',
	'renameusererrorexists' => 'Používateľ "<nowiki>$1</nowiki>" už existuje',
	'renameusererrorinvalid' => 'Používateľské meno "<nowiki>$1</nowiki>" je neplatné',
	'renameusererrortoomany' => 'Používateľ "<nowiki>$1</nowiki>" má $2 príspevkov, premenovanie používateľa s počtom príspevkov väčším ako $3 by sa mohlo nepriaznivo odraziť na výkone stránky',
	'renameusersuccess' => 'Používateľ "<nowiki>$1</nowiki>" bol premenovaný na "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'Stránka $1 už existuje a nie je možné ju automaticky prepísať.',
	'renameuser-page-moved' => 'Stránka $1 bola presunutá na $2.',
	'renameuser-page-unmoved' => 'Stránku $1 nebolo možné presunúť na $2.',
	'renameuserlogpage' => 'Záznam premenovaní používateľov',
	'renameuserlogpagetext' => 'Toto je záznam premenovaní používateľov',
	'renameuserlogentry' => 'premenoval používateľa $1 na [[User:$2]]',
	'renameuser-log' => 'mal $1 úpravy. $2',
	'renameuser-move-log' => 'Automaticky presunutá stránka počas premenovania používateľa "[[User:$1|$1]]" na "[[User:$2|$2]]"',
);
$messages['sq'] = array(
	'renameuser'                  => 'Ndërrim përdoruesi',
	'renameusererrordoesnotexist' => 'Përdoruesi me emër "<nowiki>$1</nowiki>" nuk ekziston',
	'renameusererrorexists'       => 'Përdoruesi me emër "<nowiki>$1</nowiki>" ekziston',
	'renameusererrorinvalid'      => 'Emri "<nowiki>$1</nowiki>" nuk është i lejuar',
	'renameusererrortoomany'      => 'Përdoruesi "<nowiki>$1</nowiki>" ka dhënë $2 kontribute. Ndryshimi i emrit të një përdoruesi me më shumë se $3 kontribute mund të ndikojë rëndë tek rendimenti i shërbyesave.',
	'renameuser-log'              => 'me $1 kontribute. $2',
	'renameuserlogpage'           => 'Regjistri i emër-ndryshimeve',
	'renameuserlogpagetext'       => 'Ky është një regjistër i ndryshimeve së emrave të përdoruesve',
	'renameusermove'              => 'Zhvendos faqet e përdoruesit dhe të diskutimit (dhe nën-faqet e tyre) tek emri i ri',
	'renameusernew'               => 'Emri i ri',
	'renameuserold'               => 'Emri i tanishëm',
	'renameusersubmit'            => 'Ndryshoje',
	'renameusersuccess'           => 'Përdoruesi "<nowiki>$1</nowiki>" u riemërua në "<nowiki>$2</nowiki>"',
);

/** Seeltersk (Seeltersk)
 * @author Maartenvdbent
 * @author Pyt
 */
$messages['stq'] = array(
	'renameuser'                  => 'Benutsernoome annerje',
	'renameuserold'               => 'Benutsernoomer bithäär:',
	'renameusernew'               => 'Näie Benutsernoome:',
	'renameuserreason'            => 'Gruund foar Uumenaame:',
	'renameusermove'              => 'Ferschuuwe Benutser-/Diskussionssiede inkl. Unnersieden ap dän näie Benutsernoome',
	'renameusersubmit'            => 'Uumbenaame',
	'renameusererrordoesnotexist' => 'Die Benutsernoome "<nowiki>$1</nowiki>" bestoant nit',
	'renameusererrorexists'       => 'Die Benutsernoome "<nowiki>$1</nowiki>" bestoant al',
	'renameusererrorinvalid'      => 'Die Benutsernoome "<nowiki>$1</nowiki>" is uungultich',
	'renameusererrortoomany'      => 'Die Benutser "<nowiki>$1</nowiki>" häd $2 Edits. Ju Noomensannerenge fon aan Benutser mäd moor as $3 Edits kon ju Serverlaistenge toun Ätterdeel beienfloudje.',
	'renameusersuccess'           => 'Die Benutser "<nowiki>$1</nowiki>" wuude mäd Ärfoulch uumenaamd in "<nowiki>$2</nowiki>"',
	'renameuser-page-exists'      => 'Ju Siede $1 bestoant al un kon nit automatisk uurschrieuwen wäide.',
	'renameuser-page-moved'       => 'Ju Siede $1 wuude ätter $2 ferschäuwen.',
	'renameuser-page-unmoved'     => 'Ju Siede $1 kuude nit ätter $2 ferschäuwen wäide.',
	'renameuserlogpage'           => 'Benutsernoomenannerengs-Logbouk',
	'renameuserlogpagetext'       => 'In dit Logbouk wäide do Annerengen fon Benutsernoomen protokollierd.',
	'renameuserlogentry'          => 'Benutser "$1" uumenaamd in "$2"',
	'renameuser-log'              => '$1 Beoarbaidengen. Gruund: $2',
	'renameuser-move-log'         => 'truch ju Uumbenaamenge fon „[[{{ns:user}}:$1]]“ ätter „[[{{ns:user}}:$2]]“ automatisk ferschäuwene Siede.',
);

$messages['su'] = array(
	'renameuser' => 'Ganti ngaran pamaké',
	'renameuserold' => 'Ngaran pamaké ayeuna:',
	'renameusernew' => 'Ngaran pamaké anyar:',
	'renameusermove' => 'Pindahkeun kaca pamaké jeung obrolanna (jeung sub-kacanna) ka ngaran anyar',
	'renameusersubmit' => 'Kirim',
	'renameusererrordoesnotexist' => 'Euweuh pamaké nu ngaranna "<nowiki>$1</nowiki>"',
	'renameusererrorexists' => 'Pamaké "<nowiki>$1</nowiki>" geus aya',
	'renameusererrorinvalid' => 'Ngaran pamaké "<nowiki>$1</nowiki>" teu sah',
	'renameusererrortoomany' => 'Pamaké "<nowiki>$1</nowiki>" boga $2 kontribusi, ngaganti ngaran pamaké nu boga kontribusi leuwih ti $3 bakal mangaruhan kinerja loka',
	'renameusersuccess' => 'Pamaké "<nowiki>$1</nowiki>" geus diganti ngaranna jadi "<nowiki>$2</nowiki>"',
);

$messages['sv'] = array(
	'renameuser' => 'Byt användarnamn',
	'renameuserold' => 'Nuvarande användarnamn:',
	'renameusernew' => 'Nytt användarnamn:',
	'renameuserreason' => 'Anledning till namnbytet:',
	'renameusermove' => 'Flytta användarsidan och användardiskussionen (och deras undersidor) till det nya namnet',
	'renameusersubmit' => 'Byt',
	'renameusererrordoesnotexist' => 'Användaren "<nowiki>$1</nowiki>" finns inte',
	'renameusererrorexists' => 'Användarnamnet "<nowiki>$1</nowiki>" finns redan',
	'renameusererrorinvalid' => 'Användarnamnet "<nowiki>$1</nowiki>" är felaktigt',
	'renameusererrortoomany' => 'Användaren "<nowiki>$1</nowiki>" har $2 redigeringar. Att byta namn på en användare som gjort mer än $3 redigeringar kan påverka webbplatsens prestanda negativt.',
	'renameusersuccess' => 'Användaren "<nowiki>$1</nowiki>" har döpts om till "<nowiki>$2</nowiki>"',
	'renameuser-page-exists' => 'Sidan $1 finns redan och kan inte skrivas över automatiskt.',
	'renameuser-page-moved' => 'Sidan $1 flyttades till $2.',
	'renameuser-page-unmoved' => 'Sidan $1 kunde inte flyttas till $2.',
	'renameuserlogpage' => 'Omdöpningslogg',
	'renameuserlogpagetext' => 'Detta är en logg över byten av användarnamn',
	'renameuserlogentry' => 'döpte om $1 till $2',
	'renameuser-log' => 'som hade gjort $1 redigeringar. $2',
	'renameuser-move-log' => 'Automatisk sidflytt när användaren "[[User:$1|$1]]" döptes om till "[[User:$2|$2]]"',
);

/** Tonga (faka-Tonga)
 * @author SPQRobin
 */
$messages['to'] = array(
	'renameuser'                  => 'Liliu hingoa ʻo e ʻetita',
	'renameuserold'               => 'Hingoa motuʻa ʻo e ʻetita:',
	'renameusernew'               => 'Hingoa foʻou ʻo e ʻetita:',
	'renameusersubmit'            => 'Fai ā liliuhingoa',
	'renameusererrordoesnotexist' => 'Ko e ʻetita "<nowiki>$1</nowiki>" ʻoku ʻikai toka tuʻu ia',
	'renameusererrorexists'       => 'Ko e ʻetita "<nowiki>$1</nowiki>" ʻoku toka tuʻu ia',
	'renameusererrorinvalid'      => 'ʻOku taʻeʻaonga ʻa e hingoa fakaʻetita ko "<nowiki>$1</nowiki>"',
	'renameusersuccess'           => 'Ko e ʻetita "<nowiki>$1</nowiki>" kuo liliuhingoa ia kia "<nowiki>$2</nowiki>"',
	'renameuserlogpage'           => 'Tohinoa ʻo e liliu he hingoa ʻo e ʻetita',
	'renameuserlogpagetext'       => 'Ko e tohinoa ʻeni ʻo e ngaahi liliu ki he hingoa ʻo e kau ʻetita',
);

$messages['tr'] = array(
	'renameuserold' => 'Şu anda ki kullanıcı adı:',
	'renameusernew' => 'Yeni kullanıcı adı:',
	'renameusersubmit' => 'Gönder',
	'renameusersuccess' => 'Daha önce "<nowiki>$1</nowiki>" olarak kayıtlı kullanıcının rumuzu "<nowiki>$2</nowiki>" olarak değiştirilmiştir.',
	'renameuserlogpage' => 'Kullanıcı adı değişikliği kayıtları',
	'renameuserlogpagetext' => 'Aşağıda bulunan liste adı değiştirilmiş kullanıcıları gösterir.',
);

$messages['ur'] = array(
	'renameuser'       => 'صارف کا نام تبدیل کریں',
	'renameuser-log'   => 'جن کی $1 ترامیم تھیں. $2',
);

$messages['vec'] = array(
	'renameuser' => 'Rinomina utente',
	'renameuserold' => 'Vecio nome utente:',
	'renameusernew' => 'Novo nome utente:',
);

/** Volapük (Volapük)
 * @author Malafaya
 */
$messages['vo'] = array(
	'renameuser'     => 'Votanemön gebani',
	'renameuserold'  => 'Gebananem anuik:',
	'renameusernew'  => 'Gebananem nulik:',
	'renameuser-log' => 'Redakams $1. Kod: $2',
);

$messages['wa'] = array(
	'renameuser' => 'Rilomer èn uzeu',
	'renameuserold' => 'No d\' elodjaedje pol moumint:',
	'renameusernew' => 'Novea no d\' elodjaedje:',
	'renameuserreason' => 'Råjhon pol rilomaedje:',
	'renameusermove' => 'Displaecî les pådjes d\' uzeu et d\' copene (eyet leus dzo-pådjes) viè l\' novea no',
	'renameusersubmit' => 'Evoye',
	'renameusererrordoesnotexist' => 'L\' uzeu «<nowiki>$1</nowiki>» n\' egzistêye nén',
	'renameusererrorexists' => 'L\' uzeu «<nowiki>$1</nowiki>» egzistêye dedja',
	'renameusererrorinvalid' => 'Li no d\' elodjaedje «<nowiki>$1</nowiki>» n\' est nén on no valide',
	'renameusererrortoomany' => 'L\' uzeu «<nowiki>$1</nowiki>» a $2 contribouwaedjes, rilomer èn uzeu avou pus di $3 contribouwaedjes pout aveur des consecwinces sol performance del waibe',
	'renameusersuccess' => 'L\' uzeu «<nowiki>$1</nowiki>» a stî rlomé a «<nowiki>$2</nowiki>»',
	'renameuser-page-exists' => 'Li pådje $1 egzistêye dedja et n\' pout nén esse otomaticmint spotcheye.',
	'renameuser-page-moved' => 'Li pådje $1 a stî displaeceye viè $2.',
	'renameuser-page-unmoved' => 'Li pådje $1 èn pout nén esse displaeceye viè $2.',
	'renameuserlogpage' => 'Djournå des candjmints d\' no d\' uzeus',
	'renameuserlogpagetext' => 'Chal pa dzo c\' est ene djivêye des uzeus k\' ont candjî leu no d\' elodjaedje.',
	'renameuser-log' => 'k\' aveut ddja fwait $1 candjmints. $2',
	'renameuser-move-log' => 'Pådje displaeceye otomaticmint tot rlomant l\' uzeu «[[User:$1|$1]]» viè «[[User:$2|$2]]»',
);

$messages['yue'] = array(
	'renameuser'       => '改用戶名',
	'renameuserold'    => '現時嘅用戶名:',
	'renameusernew'    => '新嘅用戶名:',
	'renameuserreason' => '改名嘅原因:',
	'renameusermove'   => '搬用戶頁同埋佢嘅對話頁（同埋佢哋嘅細頁）到新名',
	'renameusersubmit' => '遞交',

	'renameusererrordoesnotexist' => '用戶"<nowiki>$1</nowiki>"唔存在',
	'renameusererrorexists'       => '用戶"<nowiki>$1</nowiki>"已經存在',
	'renameusererrorinvalid'      => '用戶名"<nowiki>$1</nowiki>"唔正確',
	'renameusererrortoomany'      => '用戶"<nowiki>$1</nowiki>"貢獻咗$2次，對改一個超過$3次的用戶名嘅用戶可能會影響網站嘅效能',
	'renameusersuccess'           => '用戶"<nowiki>$1</nowiki>"已經改咗名做"<nowiki>$2</nowiki>"',

	'renameuser-page-exists'         => '$1呢一版已經存在，唔可以自動重寫。',
	'renameuser-page-moved'          => '$1呢一版已經搬到去$2。',
	'renameuser-page-unmoved'        => '$1呢一版唔能夠搬到去$2。',

	'renameuserlogpage'     => '用戶改名日誌',
	'renameuserlogpagetext' => '呢個係改用戶名嘅日誌',
	'renameuserlogentry'    => '已經幫 $1 改咗名做 $2',
	'renameuser-log'        => '擁有$1次編輯. $2',
	'renameuser-move-log'   => '當由"[[User:$1|$1]]"改名做"[[User:$2|$2]]"嗰陣已經自動搬咗用戶頁',
);

$messages['zh-hans'] = array(
	'renameuser'       => '用户重命名',
	'renameuserold'    => '当前用户名：',
	'renameusernew'    => '新用户名：',
	'renameuserreason' => '重命名的原因:',
	'renameusermove'   => '移动用户页及其对话页（包括各子页）到新的名字',
	'renameusersubmit' => '提交',

	'renameusererrordoesnotexist' => '用户"<nowiki>$1</nowiki>"不存在',
	'renameusererrorexists'       => '用户"<nowiki>$1</nowiki>"已存在',
	'renameusererrorinvalid'      => '用户名"<nowiki>$1</nowiki>"不可用',
	'renameusererrortoomany'      => '用户"<nowiki>$1</nowiki>"贡献了$2次，重命名一个超过$3次的用户会影响站点性能',
	'renameusersuccess'           => '用户"<nowiki>$1</nowiki>"已经更名为"<nowiki>$2</nowiki>"',

	'renameuser-page-exists'         => '$1这一页己经存在，不能自动覆写。',
	'renameuser-page-moved'          => '$1这一页已经移动到$2。',
	'renameuser-page-unmoved'        => '$1这一页不能移动到$2。',

	'renameuserlogpage'     => '用户名变更日志',
	'renameuserlogpagetext' => '这是用户名更改的日志',
	'renameuserlogentry'    => '已经把 $1 重命名为 $2',
	'renameuser-log'        => '拥有$1次编辑. $2',
	'renameuser-move-log'   => '当由"[[User:$1|$1]]"重命名作"[[User:$2|$2]]"时已经自动移动用户页',
);

$messages['zh-hant'] = array(
	'renameuser'       => '用戶重新命名',
	'renameuserold'    => '現時用戶名:',
	'renameusernew'    => '新用戶名:',
	'renameuserreason' => '重新命名的原因:',
	'renameusermove'   => '移動用戶頁及其對話頁（包括各子頁）到新的名字',
	'renameusersubmit' => '提交',

	'renameusererrordoesnotexist' => '用戶"<nowiki>$1</nowiki>"不存在',
	'renameusererrorexists'       => '用戶"<nowiki>$1</nowiki>"已存在',
	'renameusererrorinvalid'      => '用戶名"<nowiki>$1</nowiki>"不可用',
	'renameusererrortoomany'      => '用戶"<nowiki>$1</nowiki>"貢獻了$2次，重新命名一個超過$3次的用戶會影響網站效能',
	'renameusersuccess'           => '用戶"<nowiki>$1</nowiki>"已經更名為"<nowiki>$2</nowiki>"',

	'renameuser-page-exists'         => '$1這一頁己經存在，不能自動覆寫。',
	'renameuser-page-moved'          => '$1這一頁已經移動到$2。',
	'renameuser-page-unmoved'        => '$1這一頁不能移動到$2。',

	'renameuserlogpage'     => '用戶名變更日誌',
	'renameuserlogpagetext' => '這是用戶名更改的日誌',
	'renameuserlogentry'    => '已經把 $1 重新命名為 $2',
	'renameuser-log'        => '擁有$1次編輯. $2',
	'renameuser-move-log'   => '當由"[[User:$1|$1]]"重新命名作"[[User:$2|$2]]"時已經自動移動用戶頁',
);

# Kazakh fallback
$messages['kk-kz'] = $messages['kk-cyrl'];
$messages['kk-tr'] = $messages['kk-latn'];
$messages['kk-cn'] = $messages['kk-arab'];
$messages['kk'] = $messages['kk-cyrl'];

# Chinese fallback
$messages['zh'] = $messages['zh-hans'];
$messages['zh-cn'] = $messages['zh-hans'];
$messages['zh-hk'] = $messages['zh-hant'];
$messages['zh-min-nan'] = $messages['nan'];
$messages['zh-sg'] = $messages['zh-hans'];
$messages['zh-tw'] = $messages['zh-hant'];
$messages['zh-yue'] = $messages['yue'];
