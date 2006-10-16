<?php
/** Bashkir (Башҡорт)
  *
  * @package MediaWiki
  * @subpackage Language
  */

$fallback = 'ru';


$namespaceNames = array(
	NS_MEDIA            => 'Медиа',
	NS_SPECIAL          => 'Ярҙамсы',
	NS_MAIN             => '',
	NS_TALK             => 'Фекер_алышыу',
	NS_USER             => 'Ҡатнашыусы',
	NS_USER_TALK        => 'Ҡатнашыусы_м-н_фекер_алышыу', 
	#NS_PROJECT set by $wgMetaNamespace
  	NS_PROJECT_TALK     => '$1_б-са_фекер_алышыу',
	NS_IMAGE            => 'Рәсем',
	NS_IMAGE_TALK       => 'Рәсем_б-са_фекер_алышыу',
	NS_MEDIAWIKI        => 'MediaWiki',
	NS_MEDIAWIKI_TALK   => 'MediaWiki_б-са_фекер_алышыу',
	NS_TEMPLATE         => 'Ҡалып',
	NS_TEMPLATE_TALK    => 'Ҡалып_б-са_фекер_алышыу',
	NS_HELP             => 'Белешмә',
	NS_HELP_TALK        => 'Белешмә_б-са_фекер_алышыу',
	NS_CATEGORY         => 'Категория',
	NS_CATEGORY_TALK    => 'Категория_б-са_фекер_алышыу',
);

$linkTrail = '/^((?:[a-z]|а|б|в|г|д|е|ё|ж|з|и|й|к|л|м|н|о|п|р|с|т|у|ф|х|ц|ч|ш|щ|ъ|ы|ь|э|ю|я|ә|ө|ү|ғ|ҡ|ң|ҙ|ҫ|һ|“|»)+)(.*)$/sDu';

$messages = array(

# User preference toggles
'about' => 'Тасуирлау',
'aboutpage' => '{{ns:project}}:Тасуирлама',
'aboutsite' => '{{grammar:genitive|{{SITENAME}}}}-ның тасуирламаһы',
'actioncomplete' => 'Ғәмәл үтәлде',
'addedwatch' => 'Күҙәтеү исемлегенә өҫтәлде',
'allarticles' => 'Бөтә мәҡәләләр',
'allinnamespace' => 'Бөтә биттәр (Исемдәре «$1» арауығында)',
'allmessagesname' => 'Хәбәр',
'allnotinnamespace' => 'Бөтә биттәр («$1» исемдәр арауығынан башҡа)',
'allpages' => 'Бөтә биттәр',
'allpagesfrom' => 'Ошондай хәрефтәрҙән башланған биттәрҙе күрһәтергә:',
'allpagesnext' => 'Киләһе',
'allpagesprev' => 'Алдағы',
'allpagessubmit' => 'Үтәргә',
'alphaindexline' => '$1 алып $2 тиклем',
'ancientpages' => 'Иң иҫке мәҡәләләр',
'and' => 'һәм',
'article' => 'Мәҡәлә',
'articlepage' => 'Мәҡәләне ҡарап сығырға',
'badarticleerror' => 'Был биттә ундай ғәмәл үтәргә ярамай',
'badquery' => 'Һорау дөрөҫ төҙөлмәгән',
'badquerytext' => 'Һорауығыҙҙы үтәп булмай. Моғайын, Һеҙ өс хәрефтән ҡыҫҡараҡ һүҙ эҙләйһегеҙҙер, йәки һүҙегеҙҙә хата барҙыр. Һорауығыҙҙы яңынан төҙөп ҡарағыҙ әле.',
'badtitle' => 'Ярамаған исем',
'blanknamespace' => 'Мәҡәләләр',
'blockip' => 'Ҡатнашыусыны ябыу',
'cancel' => 'Бөтөрөргә',
'changed' => 'үҙгәртелгән',
'changes' => 'үҙгәрештәр',
'contributions' => 'Ҡатнашыусы өлөшө',
'copyright' => '<p> $1 ярашлы эстәлеге менән һәр кем файҙалана ала.',
'createaccount' => 'Яңы ҡатнашыусыны теркәү',
'createaccountmail' => 'эл. почта буйынса',
'currentevents' => 'Ағымдағы ваҡиғалар',
'currentevents-url' => 'Ағымдағы ваҡиғалар',
'delete' => 'Юҡ  итергә',
'disclaimerpage' => 'Project:Яуаплылыҡтан баш тартыу',
'disclaimers' => 'Яуаплылыҡтан баш тартыу',
'edit' => 'Үҙгәртергә',
'edithelp' => 'Мөхәрирләү белешмәһе',
'editing' => 'Мөхәрирләү  $1',
'editinguser' => 'Мөхәрирләү  $1',
'editingcomment' => 'Мөхәрирләү $1 (комментарий)',
'editingsection' => 'Мөхәрирләү  $1 (секция)',
'edittools' => '<charinsert>[[|]] {{}}  Ә ә  Ө ө  Ү ү  Ғ ғ  Ҡ ҡ  Ң ң  Ҙ ҙ  Ҫ ҫ  Һ һ «» | </charinsert>',
'editsection' => 'үҙгәртергә',
'editthispage' => 'Был мәҡәләне үҙгәртергә',
'emailfrom' => 'Кемдән',
'emailmessage' => 'Хәбәр',
'emailto' => 'Кемгә',
'emailuser' => 'Ҡатнашыусыға хат',
'enotif_newpagetext' => 'Был яңы бит.',
'error' => 'Хата',
'errorpagetitle' => 'Хата',
'go' => 'Күсеү',
'searcharticle' => 'Күсеү',
'gotaccount' => 'Әгәр Һеҙ теркәлеү үткән булһағыҙ? $1.',
'gotaccountlink' => 'Үҙегеҙ менән таныштырығыҙ',
'group-all' => '(бөтә)',
'help' => 'Белешмә',
'hidetoc' => 'йәшерергә',
'history' => 'Тарих',
'history_short' => 'Тарих',
'imagelist_user' => 'Ҡатнашыусы',
'imagelistall' => 'бөтә',
'info_short' => 'Мәғлүмәт',
'jumpto' => 'Унда күсергә:',
'jumptosearch' => 'эҙләү',
'lastmodifiedat' => 'Был биттең һуңғы тапҡыр үҙгәртелеү ваҡыты: $2, $1 .',
'listusers' => 'Ҡатнашыусылар исемлеге',
'login' => 'Танышыу йәки теркәлеү',
'loginpagetitle' => 'Танышыу йәки теркәлеү',
'loginsuccess' => 'Хәҙер һеҙ $1 исеме менән эшләйһегеҙ.',
'loginsuccesstitle' => 'Танышыу уңышлы үтте',
'logout' => 'Тамамлау',
'mailmypassword' => 'Яңы пароль ебәрергә',
'mainpage' => 'Баш бит',
'makesysopname' => 'Ҡатнашыусы исеме:',
'mimesearch' => 'MIME буйынса эҙләү',
'minoredit' => 'Әҙ генә үҙгәрештәр',
'move' => 'Яңы исем биреү',
'mycontris' => 'ҡылған эштәр',
'mypage' => 'Шәхси бит',
'mytalk' => 'Минең менән фекер алышыу',
'namespace' => 'Исемдәр арауығы:',
'namespacesall' => 'бөтә',
'navigation' => 'Төп йүнәлештәр',
'newpages-username' => 'Ҡатнашыусы:',
'newwindow' => '(яңы биттә)',
'nologin' => 'Һеҙ әле теркәлмәгәнме? $1.',
'nologinlink' => 'Иҫәп яҙыуын булдырырға',
'notanarticle' => 'Мәҡәлә түгел',
'nstab-main' => 'Мәҡәлә',
'nstab-mediawiki' => 'MediaWiki белдереүе',
'nstab-special' => 'Ярҙамсы бит',
'nstab-user' => 'Ҡатнашыусы',
'otherlanguages' => 'Башҡа телдәрҙә',
'permalink' => 'Даими һылтау',
'portal' => 'Берләшмә',
'portal-url' => '{{ns:project}}:Берләшмә ҡоро',
'preferences' => 'Көйләүҙәр',
'prefs-help-email' => '* Электрон почта (күрһәтмәһәң дә була) башҡа ҡатнашыусылар менән туры бәйләнешкә инергә мөмкинселек бирә.',
'preview' => 'Ҡарап сығыу',
'previewnote' => 'Ҡарап сығыу өлгөһө, әлегә үҙгәрештәр яҙҙырылмаған!',
'printableversion' => 'Ҡағыҙға баҫыу өлгөһө',
'privacy' => 'Сер һаҡлау сәйәсәте',
'protect' => 'Һаҡларға',
'qbfind' => 'Эҙләү',
'qbmyoptions' => 'Көйләү',
'qbspecialpages' => 'Махсус биттәр',
'randompage' => 'Осраҡлы мәҡәлә',
'recentchanges' => 'Һуңғы үҙгәртеүҙәр',
'recentchangesall' => 'бөтә',
'recentchangeslinked' => 'Бәйле үҙгәртеүҙәр',
'recentchangestext' => '{{grammar:genitive|{{SITENAME}}}}. биттәрендә индерелгән һуңғы үҙгәртеүҙәр исемлеге',
'remembermypassword' => 'Парольде хәтерҙә ҡалдырырға',
'returnto' => '$1 битенә ҡайтыу.',
'savearticle' => 'Яҙҙырып ҡуйырға',
'search' => 'Эҙләү',
'searchbutton' => 'Табыу',
'showdiff' => 'Индерелгән үҙгәрештәр',
'showpreview' => 'Ҡарап сығырға',
'showtoc' => 'күрһәтергә',
'sitesupport' => 'Ярҙам итеү',
'sitesupport-url' => '{{ns:project}}:Эскерһеҙ ярҙам',
'siteuser' => '{{grammar:genitive|{{SITENAME}}}} - ла ҡатнашыусы $1',
'siteusers' => '{{grammar:genitive|{{SITENAME}}}} - ла ҡатнашыусы (-лар) $1',
'specialloguserlabel' => 'Ҡатнашыусы:',
'specialpage' => 'Ярҙамсы бит',
'specialpages' => 'Махсус биттәр',
'spheading' => 'Ярҙамсы биттәр',
'summary' => 'Үҙгәртеүҙең ҡыҫҡаса тасуирламаһы',
'talk' => 'Фекер алышыу',
'talkpage' => 'Фекер алышыу',
'toc' => 'Эстәлеге',
'toolbox' => 'Ярҙамсы йүнәлештәр',
'unwatch' => 'Күҙәтмәҫкә',
'unwatchedpages' => 'Бер кем дә күҙәтмәгән биттәр',
'userlogin' => 'Танышыу йәки теркәлеү',
'userlogout' => 'Тамамлау',
'userstatstext' => 'Бөтәһе \'\'\'$1\'\'\' ҡатнашыусы теркәлгән, шуларҙан \'\'\'$2\'\'\' ($4 %) хәким бурыстарын үтәй ([[Wikipedia:Хәкимдәр|Хәкимдәр]]).',
'watch' => 'Күҙәтергә',
'watchlist' => 'Күҙәтеү исемлеге',
'watchlistall1' => 'бөтә',
'watchlistall2' => 'бөтә',
'watchnologin' => 'Үҙегеҙҙе танытырға кәрәк',
'watchthis' => 'Был битте күҙәтеүҙәр исемлегенә индерергә',
'whatlinkshere' => 'Бында һылтанмалар',
'wrongpassword' => 'Һеҙ ҡулланған пароль ҡабул ителмәй. Яңынан яҙып ҡарағыҙ.',
'yourdiff' => 'Айырмалыҡтар',
'yourdomainname' => 'Һеҙҙең домен',
'youremail' => 'Электрон почта *',
'yourlanguage' => 'Тышҡы күренештә ҡулланылған тел:',
'yourname' => 'Ҡатнашыусы исеме',
'yournick' => 'Һеҙҙең уйҙырма исемегеҙ/ҡушаматығыҙ (имза өсөн):',
'yourpassword' => 'Һеҙҙең пароль',
'yourpasswordagain' => 'Парольде ҡабаттан яҙыу',
'yourrealname' => 'Һеҙҙең ысын исемегеҙ (*)',
'yourtext' => 'Һеҙҙең текст',
'yourvariant' => 'Тел төрө',

);



?>
